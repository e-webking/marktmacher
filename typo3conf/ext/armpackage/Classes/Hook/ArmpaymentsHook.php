<?php
namespace ARM\Armpackage\Hook;

if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('armpdfkit')) {
    require_once(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('armpdfkit').'Classes/Pdf/Pdf.php');
}

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2016 Anisur Mullick <anisur@armtechnologies.com>, ARMTech
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
 *
 * @package kursmanagement
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \ARM\Armpackage\Domain\Model\Registration;

class ArmpaymentsHook
{

	/**
	 * registrationRepository
	 *
	 * @var \ARM\Armpackage\Domain\Repository\RegistrationRepository
	 * @inject
	 */
	protected $registrationRepository;

	/**
	 * @param string $tablename
	 * @param integer $orderId
	 * @param float $amount
	 * @param float $vat
	 * @param array $returnArr
	 */
	public function paymentProcess_beforeToken($tablename, $orderid, $amount, $vat, $currency, $pid, &$returnArr) {

            if ($orderid != '' && $tablename != '') {	
                $data['status'] = 1;
                $data['tstamp'] = time();
                $GLOBALS['TYPO3_DB']->exec_UPDATEquery($tablename, 'uid='.$orderid, $data);

                $returnArr['orderid'] = $orderid;
                $returnArr['tablename'] = $tablename;
                $returnArr['amount'] = $amount;
            }
	}

	/**
	 *
	 * @param \ARM\Armpayments\Domain\Model\Payment $payObj
	 */
	public function paymentProcess_postSave(\ARM\Armpayments\Domain\Model\Payment $payObj) {

            $objectManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
            $configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
            $settings = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManager::CONFIGURATION_TYPE_FRAMEWORK, 'armpackage', 'tx_armpackage');

            //GET THE STATUS
            $status = $payObj->getStatus();
            $transactionId = $payObj->getTransactionid();
            $orderid = $payObj->getOrderid();
            $tablename = $payObj->getTablename();
            $gateway = $payObj->getGateway();
            $amount = $payObj->getAmount();

            $data['tstamp'] = time();

            //Email template
            $template = 'Stripe';
            $subject = 'www.marktmacher.ch: Registration Zahlungsbestätigung für Rechnungsnummer '. $orderid;

            $emailArr['total'] = sprintf("%.02f", $amount);
            $emailArr['currency'] = $payObj->getCurrency();

            if ($transactionId != '' && $status==1) {
                $data['status'] = 2; //update the payment status
                $data['total'] = $amount;
                //send email
                $emailArr['pstatus'] = 'BEZAHLT';
                $emailArr['payment'] = 'Transaction ID - '.$transactionId;
                $emailArr['information'] = 'Online ['. $gateway .']';
                
                //update the fe_user table
                $GLOBALS['TYPO3_DB']->exec_UPDATEquery('fe_users', 'uid='. $GLOBALS['TSFE']->fe_user->user['uid'], array('tx_femanager_activepack'=>1));
            } else {
                $emailArr['pstatus'] = 'UNPAID';
                $emailArr['payment'] = 'Zahlungstransaktion nicht erfolgreich!';
                $emailArr['information'] = 'Online ['. $gateway .']';
            }

            $GLOBALS['TYPO3_DB']->exec_UPDATEquery($tablename, 'uid='.$orderid, $data);

            //Send email to admin and user
            $record = $GLOBALS['TYPO3_DB']->exec_SELECTgetSingleRow('*', $tablename, 'uid='.$orderid);

            $senderMail = trim($settings['settings']['senderEmailAdresse']);
            $senderName = trim($settings['settings']['senderName']);
            $recipient = $GLOBALS['TSFE']->fe_user->user['email'];
            $name = $GLOBALS['TSFE']->fe_user->user['company'];

            $emailArr['status'] = $status;
            $emailArr['username'] = $GLOBALS['TSFE']->fe_user->user['username'];
            $emailArr['company'] =  $GLOBALS['TSFE']->fe_user->user['company'];
            $emailArr['email'] =  $GLOBALS['TSFE']->fe_user->user['email'];
            $emailArr['package'] =  $record['ptitle'];
            $emailArr['rate'] =  $record['rate'];
            $emailArr['qty'] =  $record['qty'];
            $emailArr['amount'] =  $record['amount'];
            $emailArr['discount'] =  $record['discount'];
            $emailArr['vat'] =  $record['vat'];
            $emailArr['orderid'] = $orderid;
            $emailArr['pdate'] = date("d-M-Y");

            $objectManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
            $tplObj = $objectManager->get('TYPO3\\CMS\\Fluid\\View\\StandaloneView');
            $tplObj->setFormat('html');

            $templateRootPath = GeneralUtility::getFileAbsFileName($settings['view']['templateRootPaths'][0]);
            $templatePathAndFilename = $templateRootPath. '/Email/Stripe.html';
            
            $tplObj->setTemplatePathAndFilename($templatePathAndFilename);
            $tplObj->assignMultiple($emailArr);		
            $body = $tplObj->render();

            //Send Email
            $mail = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Mail\\MailMessage');
            
            if (GeneralUtility::validEmail($recipient)) {
                // If payment successful, then generate invoice and attach
                if ($status==1) {
                    if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('armpdfkit')) {
                        $rechnungPDF = PATH_site . 'uploads/tx_armpackage/Rechnung_'.$orderid.'.pdf';

                        if (file_exists($rechnungPDF)) {
                            
                            $pdf = GeneralUtility::makeInstance('ARM\\Armpdfkit\\Pdf\\Pdf');
                            $pdf::initFpdi('P');
                            
                            $pdf::$fpdi->SetFont('helvetica','B',16);
                            $pdf::$fpdi->SetY(20);
                            $pdf::$fpdi->Cell(35,10, ' ');
                            $pdf::$fpdi->Cell(40,10,'/ Quittung');
                            $pdf::$fpdi->SetFont('helvetica','',8);
                            $pdf::$fpdi->SetY(126);
                            $pdf::$fpdi->Cell(40,10, ' ');
                            $pdf::$fpdi->Cell(60,10,'Zahlung erhalten per Kreditkarte.');
                            
                            //Copy the invoice
                            $pdf::$fpdi->SetY(0);
                            $pdf::$fpdi->setSourceFile($rechnungPDF);
                            $tplIdx = $pdf::$fpdi->importPage(1);
                            $pdf::$fpdi->useTemplate($tplIdx, 0, 0, 0, 0, true);
                            $fileInv = PATH_site . 'uploads/tx_armpackage/Rechnung_Quittung_'.$orderid.'.pdf';
                            $pdf::$fpdi->Output($fileInv, 'f');
                            
                            $mail->attach(\Swift_Attachment::fromPath($fileInv));
                        }
                    }
                }
                
		$mail->setFrom(array($senderMail => $senderName))
		    ->setTo(array($recipient => $name))
		    ->setCc(array($senderMail => $senderName))
		    ->setSubject($subject)
		    ->setBody($body, 'text/html')
		    ->send();
		}
	}
}
