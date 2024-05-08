<?php
namespace ARM\Armpayments\Controller;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Anisur R. Mullick <anisur@armtechnologies.com>, ARM Technologies
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 *
 * @package TYPO3
 * @subpackage armpayments
 * @author Anisur R. Mullick <anisur@armtechnologies.com>
 * @version 1.1.0
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 *
 */
class PaymentController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

    /**
     *
     * @var \ARM\Armpayments\Domain\Repository\PaymentRepository
     * @inject
     */
    protected $paymentRepository;

    /**
     * 
     * @var \array
     */
    protected $conf;

    /**
     * 
     * @var \float
     */
    protected $amount;

    /**
     * 
     * @var \int
     */
    protected $amountCent;

    /**
     * 
     * @var \float
     */
    protected $vat;

    /**
     * 
     * @var \string
     */
    protected $currency;

    /**
     * 
     * @var \string
     */
    protected $tablename;

    /**
     * 
     * @var \int
     */
    protected $orderid;

    /**
     *
     * @var \string
     */
    protected $payerId;

    /**
     * The stripe payment form
     * @return string
     */
    public function stripeformAction() {

        $this->conf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['armpayments']);
        $apiSecretKey =  $this->conf['stripeApiKey'];
        $publishKey = $this->conf['stripePubKey'];
        $stripeObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('ARM\\Armpayments\\Libraries\\Stripe\\T3Stripe', $apiSecretKey, $publishKey);
        $stripeObj->init();

        $orderid = $this->request->getArgument('orderid');
        $amount = $this->request->getArgument('amount');
        $amountCent = intval($this->request->getArgument('amountcent'));
        $vat = $this->request->getArgument('vat');
        $tablename = $this->request->getArgument('tablename');
        $currency = $this->request->getArgument('currency');
        $description = $this->request->getArgument('description');
        $method = $this->request->getArgument('method');
        $mail = $this->request->getArgument('email');

        $this->view->assign('stripePubKey', $publishKey);
        $this->view->assign('orderid', $orderid);
        $this->view->assign('amount', $amount);
        $this->view->assign('amountCent', $amountCent);
        $this->view->assign('vat', $vat);
        $this->view->assign('currency', $currency);
        $this->view->assign('description', urldecode($description));
        $this->view->assign('tablename', $tablename);            
        $this->view->assign('method', $method);
        $this->view->assign('email', $mail);

    }

    /**
     * Stripe return 
     */
    public function stripereturnAction() {
        $sendMail = false;
        $payConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['armpayments']);
        $apiSecretKey = $payConf['stripeApiKey'];
        $publishKey = $payConf['stripePubKey'];

        $stripeObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('ARM\\Armpayments\\Libraries\\Stripe\\T3Stripe', $apiSecretKey, $publishKey);
        $stripeObj->init();

        $token  = $_POST['stripeToken'];
        $email  = $_POST['stripeEmail'];
        $amount = $_POST['amount'];
        $amountCent = intval($amount * 100);
        $vat = $_POST['vat'];
        $currency = $_POST['currency'];
        $ordid = $_POST['orderid'];
        $tablename = $_POST['tablename'];

        $customer = $stripeObj->createCustomer($email,$token);
        $this->payerId = $customer->id;

        //charge customer
        $charge = $stripeObj->charge($customer, $amountCent, strtolower($currency));
        
        $refId = $charge->id;
        $captured = $charge->captured;
        $status = $charge->status;

        $payment = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('ARM\\Armpayments\\Domain\\Model\\Payment');

        $subtotal = $amount;
        $payment->setGateway('Stripe');
        $payment->setAmount($amount);
        $payment->setOrderid($ordid);
        $payment->setTablename($tablename);
        $payment->setCurrency($currency);
        $payment->setToken($token);
        $payment->setSubtotal($subtotal);
        $payment->setTax($vat);
        $payment->setPayer($customer->id);

        $this->view->assign('payerId', $customer->id);
        $this->view->assign('trxid', $refId);
        $this->view->assign('subtotal', $subtotal);
        $this->view->assign('tax', $vat);
        $this->view->assign('total', $amount);

        if ($captured && $status == 'succeeded') {

            $payment->setStatus(1);
            $payment->setTransactionid($refId);
            $sendMail = true;

        } else {

            $payment->setStatus(-1);
            $this->view->assign('error', 1);
        }

        $this->paymentRepository->add($payment);

        if ($payment instanceof \ARM\Armpayments\Domain\Model\Payment) {
            //execute the hooks
            if ($sendMail==true) {
                if (is_array($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['armpayments']['tx_armpayments_pi1']['paymentProcess'])) {
                    foreach($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['armpayments']['tx_armpayments_pi1']['paymentProcess'] as $classRef) {
                        $hookObj = \TYPO3\CMS\Core\Utility\GeneralUtility::getUserObj($classRef);
                        if (method_exists($hookObj, 'paymentProcess_postSave')) {
                            $hookObj->paymentProcess_postSave($payment);
                        }
                    }
                }
            }
        }
    }
}