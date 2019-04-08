<?php
namespace ARM\Armpackage\Controller;

/***
 *
 * This file is part of the "Courses" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2019 Anisur Rahaman Mullick <anisur.mullick@gmail.com>, ARM Technologies
 *
 ***/

use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Core\Database\ConnectionPool;

/**
 * PackageController
 */
class PackageController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * packageRepository
     *
     * @var \ARM\Armpackage\Domain\Repository\PackageRepository
     * @inject
     */
    protected $packageRepository = null;
    
    /**
     * branchRepository
     *
     * @var \ARM\Armpackage\Domain\Repository\BranchRepository
     * @inject
     */
    protected $branchRepository = null;
    
    /**
     * regRepository
     *
     * @var \ARM\Armpackage\Domain\Repository\RegistrationRepository
     * @inject
     */
    protected $regRepository = null;

    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $packages = $this->packageRepository->findAll();
        $this->view->assign('packages', $packages);
    }

    /**
     * action register
     *
     * @return void
     */
    public function registerAction()
    {
        if ($this->request->hasArgument('package')) {
            $pack = $this->request->getArgument('package');
            $qty = 0;
            if ($pack > 0) {
                $package = $this->packageRepository->findByUid($pack);
                $this->view->assign('package', $package);
            }
            if ($this->request->hasArgument('qty')) {
                $qty = intval($this->request->getArgument('qty'));
            }
            if ($qty == 0) {
                $qty = 1;
            }
            if ($this->request->hasArgument('total')) {
                $total = $this->request->getArgument('total');
            }
            if ($total == '') {
                if ($qty == 1) {
                    $total = $package->getRate() * $qty;
                } elseif($qty == 2) {
                    $total = ($package->getRate() - $package->getRate() * $package->getRebate2() /100) * $qty; 
                } elseif($qty > 2 && $qty < 11) {
                    $total = ($package->getRate() - $package->getRate() * $package->getRebate3to10() /100) * $qty; 
                } else {
                    $total = ($package->getRate() - $package->getRate() * $package->getRebatemt10() /100) * $qty; 
                }
            }
            $amount = $package->getRate() * $qty;
            $discount = $amount - $total;
            $this->view->assign('total', $total);
            $this->view->assign('qty', $qty);
            $this->view->assign('amount', $amount);
            $this->view->assign('discount', $discount);
            $this->view->assign('feuser', $GLOBALS['TSFE']->fe_user->user['uid']);
        } else {
            $this->addFlashMessage('Please select a package', 
               '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
            $this->redirect("list");
        }
    }

    /**
     * action confirm
     *
     * @return void
     */
    public function confirmAction()
    {
        if ($this->request->hasArgument('total')) {
            $total = $this->request->getArgument('total');
        }
        if ($this->request->hasArgument('qty')) {
            $qty = $this->request->getArgument('qty');
        }
        if ($this->request->hasArgument('feuser')) {
            $feuser = $this->request->getArgument('feuser');
        }
        if ($this->request->hasArgument('package')) {
            $packuid = $this->request->getArgument('package');
        }
        if ($this->request->hasArgument('discount')) {
            $discount = $this->request->getArgument('discount');
        }
        if ($this->request->hasArgument('amount')) {
            $amount = $this->request->getArgument('amount');
        }
        
        if ($packuid > 0 && $feuser > 0 && $total > 0 && $qty > 0) {
            
            $package = $this->packageRepository->findByUid($packuid);
            // Register the order
            $order = GeneralUtility::makeInstance('ARM\\Armpackage\\Domain\\Model\\Registration');
            $order->setFeuser($feuser);
            $order->setPtitle($package->getTitle());
            $order->setQty($qty);
            $order->setRate($package->getRate());
            $order->setCurrency($this->settings['currency']);
            $order->setDiscount($discount);
            $order->setAmount($amount);
            $order->setTotal($total);
            $order->setPackage($package);
            $order->setStatus(1);
            
            $this->regRepository->add($order);
            $persistenceManager = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
            $persistenceManager->persistAll();
            
            $invoiceFile = $this->createInvoice($order);
            $this->sendEmail($order, $invoiceFile);
            
            if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('armpayments')) {
            
                $payConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['armpayments']);
                //->uriFor('process', array('orderid' => $orderid,'amount' => $amount, 'vat' => $vat, 'currency' => $currency, 'tablename' => $tablename, 'method'=> 'paypal'), $this->controllerName, $this->extensionName, $this->pluginName);

                $link = $this->uriBuilder->setArgumentPrefix('tx_armpayments_pi1')
                    ->setCreateAbsoluteUri(TRUE)
                    ->setUseCacheHash(FALSE)
                    ->setTargetPageUid($this->settings['paymentUid'])
                    ->uriFor('stripeform', array(
                        'orderid' => $order->getUid(),
                        'amount' => $total, 
                        'amountcent' => $total * 100, 
                        'description' => urlencode($package->getTitle()), 
                        'vat' => 0, 
                        'currency' => $payConf['currency'], 
                        'tablename' => 'tx_armpackage_domain_model_registration', 
                        'method'=> 'stripe'),
                        'Payment',
                        'Armpayments',
                        'Pi1'
                    );

                    $this->redirectToUri($link);
                    //die('Should not come!');

            } else {
                $this->addFlashMessage('Payment module not loaded, please contact website administrator (office@marktmacher.com)', 
                        '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR, FALSE);
                //die('Pay!');
                $this->redirect('list');
            }
            
        } else {
             $this->addFlashMessage('Complete order information missing', 
                '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR, FALSE);
             //die('Order');
             $this->redirect('list');
        } 
    }
    
    /**
     * 
     * @param \ARM\Armpackage\Domain\Model\Registration $registration
     * @return string
     */
    protected function createInvoice(\ARM\Armpackage\Domain\Model\Registration $registration) {
        
        $furnplanLogo = PATH_site.'typo3conf/ext/armpackage/Resources/Public/Icons/furnplan-academy-logo350.jpg';
        $logo = PATH_site.'typo3conf/ext/armpackage/Resources/Public/Icons/logo400x400.jpg';
        
        $rate = floatval($registration->getRate());
        $rate = number_format($rate,2,",",".");
        $amount = floatval($registration->getAmount());
        $amount = number_format($amount,2,",",".");
        
        if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('armpdfkit')) {
            $pdf = $this->objectManager->get('ARM\\Armpdfkit\\Pdf\\Pdf');
            $pdf::init('P');
            $pdf::setFont('helvetica',16,'B');
            $pdf::writeCell(' ', 5, 30, 0, 0, 'L');
            $pdf::writeCell('Rechnung ', 65, 30, 0, 0, 'L');
            $pdf::image($furnplanLogo,null,20,50);
            $y = $pdf::$pdf->GetY();
            $pdf::$pdf->SetY($y-20);
            
            $pdf::image($logo,150,20,20);
            //$x = $pdf::$pdf->GetX();
            //$pdf::$pdf->SetX(120);
            $pdf::setFont('helvetica',8,'');
            $pdf::$pdf->SetY(45);
            $pdf::$pdf->SetX(17);
            $pdf::writeCell('Firma', 15, 5, 0, 0);
            $pdf::writeCell($GLOBALS['TSFE']->fe_user->user['company'], 48, 5, 0, 0);
            
            $pdf::writeCell('Datum', 20, 5, 0, 0);
            $pdf::writeCell(date("d.m.Y"), 50, 5, 0, 0);
            $pdf::writeCell('marktmacher', 30, 5, 0, 1);
            $pdf::writeLine('',TRUE,1);
            
            $y = $pdf::$pdf->GetY();
            $pdf::$pdf->SetY($y-5);
            $pdf::$pdf->SetX(17);
            $pdf::writeCell('Adresse', 15, 5, 0, 0);
            $pdf::writeCell($GLOBALS['TSFE']->fe_user->user['address'], 48, 5, 0, 0);
            
            $pdf::writeCell('Bestelldatum', 20, 5, 0, 0);
            $pdf::writeCell(date("d.m.Y"), 50, 5, 0, 0);
            $pdf::writeCell('Marcel Kuriger', 30, 5, 0, 1);
            $pdf::writeLine('',TRUE,1);
            
            $y = $pdf::$pdf->GetY();
            $pdf::$pdf->SetY($y-5);
            $pdf::$pdf->SetX(17);
            $pdf::writeCell('Ort', 15, 5, 0, 0);
            $pdf::writeCell($GLOBALS['TSFE']->fe_user->user['city'], 48, 5, 0, 0);
            
            $pdf::writeCell('Sachbearb.', 20, 5, 0, 0);
            $pdf::writeCell('Marcel Kuriger', 50, 5, 0, 0);
            $pdf::writeCell('Konradsweg 34', 30, 5, 0, 1);
            $pdf::writeLine('',TRUE,1);
            
            $y = $pdf::$pdf->GetY();
            $pdf::$pdf->SetY($y-5);
            $pdf::$pdf->SetX(17);
            $pdf::writeCell('PLZ', 15, 5, 0, 0);
            $pdf::writeCell($GLOBALS['TSFE']->fe_user->user['zip'], 48, 5, 0, 0);
            
            
            $pdf::writeCell('Auftrags-Nr.', 20, 5, 0, 0);
            $pdf::writeCell($registration->getUid(), 50, 5, 0, 0);
            $pdf::writeCell('8832 Wilen', 30, 5, 0, 1);
            $pdf::writeLine('',TRUE,1);
            
            $y = $pdf::$pdf->GetY();
            $pdf::$pdf->SetY($y-5);
            $pdf::$pdf->SetX(17);
            $pdf::writeCell('Land', 15, 5, 0, 0);
            $pdf::writeCell($GLOBALS['TSFE']->fe_user->user['country'], 48, 5, 0, 0);
            
            $pdf::writeCell('Kunden Tel.', 20, 5, 0, 0);
            $pdf::writeCell($GLOBALS['TSFE']->fe_user->user['telephone'], 50, 5, 0, 0);
            $pdf::writeCell($this->settings['senderEmailAdresse'], 30, 5, 0, 1);
            $pdf::writeLine('',TRUE,1);
            
            $y = $pdf::$pdf->GetY();
            $pdf::$pdf->SetY($y-5);
            $pdf::$pdf->SetX(80);
            $pdf::writeCell('Kunden Email', 20, 5, 0, 0);
            $pdf::writeCell($GLOBALS['TSFE']->fe_user->user['email'], 50, 5, 0, 0);
            $pdf::writeCell('MwSt. Nr.               CHE-349.510.002', 30, 10, 0, 1,'L',0,'',1);
            $pdf::writeLine('',TRUE,30);
            $y = $pdf::$pdf->GetY();
            $pdf::$pdf->SetY($y+15);
            
            $pdf::writeCell('Pos',10, 5, 1, 0);
            $pdf::writeCell('Stk.',10, 5, 1, 0);
            $pdf::writeCell('    ',20, 5, 1, 0);
            $pdf::writeCell('Artikelbeschrieb',60, 5, 1, 0);
            $pdf::writeCell('Betrag Euro',30, 5, 1, 0, 'R');
            $pdf::writeCell('Anzahl Filialen',20, 5, 1, 0);
            $pdf::writeCell('Total Euro',30, 5, 1, 1, 'R');
            
            $pdf::writeCell('1',10, 5, 1, 0);
            $pdf::writeCell('1',10, 5, 1, 0);
            $pdf::writeCell('    ',20, 5, 1, 0);
            $pdf::writeCell($registration->getPtitle(),60, 5, 1, 0);
            $pdf::writeCell($rate,30, 5, 1, 0, 'R');
            $pdf::writeCell($registration->getQty(),20, 5, 1, 0, 'C');
            $pdf::writeCell($amount,30, 5, 1, 1, 'R');
            
            $pdf::writeCell(' ',10, 5, 1, 0);
            $pdf::writeCell(' ',10, 5, 1, 0);
            $pdf::writeCell(' ',20, 5, 1, 0);
            $pdf::writeCell('unlimitierter Zugang zu allen',60, 5, 1, 0);
            $pdf::writeCell(' ',30, 5, 1, 0);
            $pdf::writeCell(' ',20, 5, 1, 0);
            $pdf::writeCell(' ',30, 5, 1, 1);
            
            $pdf::writeCell(' ',10, 5, 1, 0);
            $pdf::writeCell(' ',10, 5, 1, 0);
            $pdf::writeCell(' ',20, 5, 1, 0);
            $pdf::writeCell('furnplan Seminaren',60, 5, 1, 0);
            $pdf::writeCell(' ',30, 5, 1, 0);
            $pdf::writeCell(' ',20, 5, 1, 0);
            $pdf::writeCell(' ',30, 5, 1, 1);
            
            for($i=4;$i<6;) {
                $pdf::writeCell(' ',10, 5, 1, 0);
                $pdf::writeCell(' ',10, 5, 1, 0);
                $pdf::writeCell(' ',20, 5, 1, 0);
                $pdf::writeCell(' ',60, 5, 1, 0);
                $pdf::writeCell(' ',30, 5, 1, 0);
                $pdf::writeCell(' ',20, 5, 1, 0);
                $pdf::writeCell(' ',30, 5, 1, 1);
                $i++;
            }
            $pdf::writeCell(' ',10, 5, 1, 0);
            $pdf::writeCell(' ',10, 5, 1, 0);
            $pdf::writeCell(' ',20, 5, 1, 0);
            $pdf::writeCell('',60, 5, 1, 0);
            $pdf::writeCell(' ',30, 5, 1, 0);
            $pdf::writeCell(' ',20, 5, 1, 0);
            $pdf::writeCell(' ',30, 5, 1, 1);
            
            $pdf::writeCell(' ',10, 5, 1, 0);
            $pdf::writeCell(' ',10, 5, 1, 0);
            $pdf::writeCell(' ',20, 5, 1, 0);
            $pdf::writeCell('Besten Dank für den Auftrag!',60, 5, 1, 0);
            $pdf::writeCell(' ',30, 5, 1, 0);
            $pdf::writeCell(' ',20, 5, 1, 0);
            $pdf::writeCell(' ',30, 5, 1, 1);
            
            $pdf::writeCell(' ',10, 5, 0, 0);
            $pdf::writeCell(' ',10, 5, 0, 0);
            $pdf::writeCell(' ',20, 5, 0, 0);
            $pdf::writeCell(' ',60, 5, 0, 0);
            $pdf::writeCell('Total',30, 5, 1, 0);
            $pdf::writeCell(' ',20, 5, 1, 0);
            $pdf::writeCell($amount,30, 5, 1, 1, 'R');
            
            $pdf::writeCell(' ',10, 5, 0, 0);
            $pdf::writeCell(' ',10, 5, 0, 0);
            $pdf::writeCell(' ',20, 5, 0, 0);
            $pdf::writeCell(' ',60, 5, 0, 0);
            $pdf::writeCell('Rabatt',30, 5, 1, 0);
            $pdf::writeCell(' ',20, 5, 1, 0);
            $pdf::writeCell($registration->getDiscount(),30, 5, 1, 1, 'R');
            
            $pdf::setFont('helvetica',8,'B');
            $pdf::writeCell(' ',10, 5, 0, 0);
            $pdf::writeCell(' ',10, 5, 0, 0);
            $pdf::writeCell(' ',20, 5, 0, 0);
            $pdf::writeCell(' ',60, 5, 0, 0);
            $pdf::writeCell('Rechnungsbetrag',30, 5, 1, 0);
            $pdf::writeCell(' ',20, 5, 1, 0);
            $pdf::writeCell(number_format($registration->getTotal(),2,",","."),30, 5, 1, 1, 'R');
            $pdf::setFont('helvetica',8,'');
            $pdf::writeCell('      Bankverbindung: ',180, 5, 1, 1);
            $pdf::writeCell('      '.$this->settings['bankdata'],180, 5, 1, 1);
            
            $filename = 'Rechnung_'.$registration->getUid().'.pdf';
            $path = PATH_site.'uploads/tx_armpackage';
            
            $pdf::generatePDF($filename,FALSE,$path);
            
            return $path.'/'.$filename;
        }
    }
    
    /**
     * 
     * @param \ARM\Armpackage\Domain\Model\Registration $registration
     * @param string $file
     */
    protected function sendEmail(\ARM\Armpackage\Domain\Model\Registration $registration, $file='') {
        
        $emailView = $this->objectManager->get('TYPO3\\CMS\\Fluid\\View\\StandaloneView');
        $emailView->setFormat('html');

        $extbaseFrameworkConfiguration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
        $partialRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['templateRootPaths'][0]);
        $templatePathAndFilename = $partialRootPath.'Email/Stripe.html';

        $emailView->setTemplatePathAndFilename($templatePathAndFilename);
        $variables = [
                        'username'=>$GLOBALS['TSFE']->fe_user->user['username'],
                        'company'=>$GLOBALS['TSFE']->fe_user->user['company'],
                        'orderid'=>$registration->getUid(),
                        'currency'=>$this->settings['currency'],
                        'total'=>  number_format($registration->getTotal(),2,",","."),
                        'pdate'=>date("d.m.Y"),
                        'pstatus'=>'Pending',
                        'rate'=>  number_format($registration->getRate(),2,",","."),
                        'qty'=>  $registration->getQty(),
                        'discount'=>  $registration->getDiscount(),
                        'vat'=>  '0,00',
                        'package'=>  $registration->getPtitle()
                    ];
        $emailView->assignMultiple($variables);
        $extensionName = $this->request->getControllerExtensionName();
        $emailView->getRequest()->setControllerExtensionName($extensionName);

        $body = $emailView->render(); 

        // Mail senden
        $mail = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Mail\\MailMessage');

        if (file_exists($file) && $file != '') {
            $mail->attach(\Swift_Attachment::fromPath($file));
        }

        $subject = $this->settings['subject']; 
        $senderMail = $this->settings['senderEmailAdresse'];                       
        $senderName = $this->settings['senderName'];  
        $email = $GLOBALS['TSFE']->fe_user->user['email'];
        $name = $GLOBALS['TSFE']->fe_user->user['company'];
        
        if (\TYPO3\CMS\Core\Utility\GeneralUtility::validEmail($email)) {
            $mail->setFrom(array($senderMail => $senderName))
                 ->setTo(array($email => $name))
                 ->setCc(array($senderMail => $senderName))
                 ->setSubject($subject)
                 ->setBody($body, 'text/html')
                 ->send();
        }
        
        return;
    }

    /**
     * Create branch
     */
    public function branchAction() {
         if ($this->request->hasArgument('puser')) {
            $puser =  $this->request->getArgument('puser');
            $this->view->assign('puser', $puser);
        }
        if ($this->request->hasArgument('feuser')) {
           $feuser =  $this->request->getArgument('feuser');
           $this->view->assign('feuser', $feuser);
        }
        if ($this->request->hasArgument('company')) {
            $company =  $this->request->getArgument('company');
            $this->view->assign('company', $company);
        }
        if ($this->request->hasArgument('address')) {
           $address =  $this->request->getArgument('address');
            $this->view->assign('address', $address);
        }
        if ($this->request->hasArgument('city')) {
           $city =  $this->request->getArgument('city');
            $this->view->assign('city', $city);
        }
        if ($this->request->hasArgument('zip')) {
           $zip =  $this->request->getArgument('zip');
            $this->view->assign('zip', $zip);
        }
        $countries = ['CHF'=>'Schweiz','DEU'=>'Deutschland','AUT'=>'Österreich'];
        $this->view->assign('countries', $countries);
        
    }
    
    /**
     * Store branch
     */
    public function storebranchAction() {
        $sub = TRUE;
        
        if ($this->request->hasArgument('feuser')) {
           $feuser =  $this->request->getArgument('feuser');
           if ($feuser == '') {
               $this->addFlashMessage('Please fill username field', 
               '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
                $sub = FALSE;
            }
        }
        if ($this->request->hasArgument('company')) {
            $company =  $this->request->getArgument('company');
            if ($company == '') {
                 $this->addFlashMessage('Company field is empty, please enter valid username', 
               '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
                $sub = FALSE;
            }
        }
        if ($this->request->hasArgument('address')) {
           $address =  $this->request->getArgument('address');
           if ($address == '') {
                $this->addFlashMessage('Please fill address field', 
               '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
               $sub = FALSE;
           }
        } else {
            
        }
        if ($this->request->hasArgument('city')) {
           $city =  $this->request->getArgument('city');
           if ($city == '') {
               $this->addFlashMessage('Please fill city field', 
               '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
               $sub = FALSE;
           }
        }
        
        if ($this->request->hasArgument('zip')) {
           $zip =  $this->request->getArgument('zip');
           if ($zip == '') {
               $this->addFlashMessage('Please fill zip field', 
               '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
               $sub = FALSE;
           }
        }
        
        if ($this->request->hasArgument('country')) {
           $country =  $this->request->getArgument('country');
        }
        
        if (!$sub) {            
            $this->forward('branch');
        } else {
            $branch = GeneralUtility::makeInstance('ARM\\Armpackage\\Domain\\Model\\Branch');
            $branch->setFeuser($feuser);
            $branch->setCompany($company);
            $branch->setAddress($address);
            $branch->setCity($city);
            $branch->setZip($zip);
            $branch->setCountry($country);
            
            $this->branchRepository->add($branch);
            
            $this->redirectToUri($this->settings['furnplanRegUrl']);
        }
        die('This should not be visible');
    }
    
    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getCompanyAction( 
        \Psr\Http\Message\ServerRequestInterface $request,
        \Psr\Http\Message\ResponseInterface $response) {
        
        $params = $request->getParsedBody();
        $username = $params['arguments']['username'];
        
        if (isset($username)) {
            
            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('fe_users');
            $queryBuilder->getRestrictions()->removeAll();
            $rows = $queryBuilder->select('uid','company')
                ->from('fe_users')
                ->where(
                    $queryBuilder->expr()->eq('deleted', 0),
                    $queryBuilder->expr()->eq('disable', 0),
                    $queryBuilder->expr()->eq('username', $queryBuilder->createNamedParameter($username))
                )
                ->execute()
                ->fetchAll();
            
            if (count($rows) > 0) {
                
                $cdata = $rows[0];
                $arr['status'] = 'OK';
                $arr['company'] = $cdata['company'];
                $arr['uid'] = $cdata['uid'];
                $arr['text'] = 'Username name verified successfully.';
                      
            } else {
                $arr['status'] = 'ERR';
                $arr['error'] = 'Username "'. $username.'" is invalid!';
            }
            
        } else {
            $arr['status'] = 'ERR';
            $arr['error'] = 'No username provided!';
        }
        
        $json = $this->array2Json($arr);

        $response->getBody()->write($json);
        $response->withHeader('Content-Type', 'application/json;charset=utf-8');
        
        return $response;
    }
    
    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getPriceAction( 
        \Psr\Http\Message\ServerRequestInterface $request,
        \Psr\Http\Message\ResponseInterface $response) {
        
        $params = $request->getParsedBody();
        $puid = $params['arguments']['package'];
        $qty = $params['arguments']['qty'];
        
        if (isset($puid) && $qty > 0) {
            
            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_armpackage_domain_model_package');
            $queryBuilder->getRestrictions()->removeAll();
            $rows = $queryBuilder->select('rate','rebate2','rebate3to10','rebatemt10')
                ->from('tx_armpackage_domain_model_package')
                ->where(
                    $queryBuilder->expr()->eq('deleted', 0),
                    $queryBuilder->expr()->eq('hidden', 0),
                    $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($puid))
                )
                ->execute()
                ->fetchAll();
            
            if (count($rows) > 0) {
                
                $cdata = $rows[0];
                $total = $rate = $cdata['rate'];
                if ($qty == 2) {
                    $total = ($rate - $rate *  $cdata['rebate2'] / 100 ) * $qty;
                } else if ($qty > 2 && $qty < 11) {
                    $total = ($rate - $rate *  $cdata['rebate3to10'] / 100 ) * $qty;
                } else if ($qty > 10) {
                    $total = ($rate - $rate *  $cdata['rebatemt10'] / 100 ) * $qty;
                }
                $amount = $rate * $qty;
                $discount = number_format(($amount - $total), 2, ",", ".");
                
                $arr['status'] = 'OK';
                $arr['total'] = $total;
                $arr['discount'] = $discount;
                $arr['amount'] = $amount;
                      
            } else {
                $arr['status'] = 'ERR';
                $arr['error'] = 'No package information!';
            }
            
        } else {
            $arr['status'] = 'ERR';
            $arr['error'] = 'Please enter proper quantity!';
        }
        
        $json = $this->array2Json($arr);

        $response->getBody()->write($json);
        $response->withHeader('Content-Type', 'application/json;charset=utf-8');
        
        return $response;
    }
    
    /**
     * Student Login
     */
    public function loginAction() {
        
        $sub = TRUE;
        $msg = '';
        if ($this->request->hasArgument('sub')) {
            if ($this->request->hasArgument('feuser')) {
                $feuser =  $this->request->getArgument('feuser');
                if ($feuser == '') {
                    $msg .= 'Please fill username field!'."\n";
                     $this->addFlashMessage('Please fill username field.', 
                   '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
                    $sub = FALSE;
                }
            }
            if ($this->request->hasArgument('company')) {
                $company =  $this->request->getArgument('company');
                if ($company == '') {
                    $msg .= 'Company field is empty, enter valid username!';
                     $this->addFlashMessage('Company field is empty, enter valid username.', 
                   '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
                    $sub = FALSE;
                }
            }
            if ($sub) {
               $this->redirectToUri($this->settings['furnplanLoginUrl']);
            }
        }
    }
    
    /**
     * 
     * @param array $arr
     * @return string
     */
    protected function array2Json($arr)
    {
        return json_encode($arr);
    }
}
