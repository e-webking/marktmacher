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
     * userRepository
     *
     * @var \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository
     * @inject
     */
    protected $userRepository;
    
    /**
     * studentRepository
     *
     * @var \ARM\Armpackage\Domain\Repository\StudentemailRepository
     * @inject
     */
    protected $studentRepository;
    

    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        if ($GLOBALS['TSFE']->fe_user->user['uid'] > 0) {
             $this->view->assign('login', 1);
        }
        $packages = $this->packageRepository->getNonPrivate();
        $this->view->assign('packages', $packages);
    }
    
    /**
     * action mlist
     *
     * @return void
     */
    public function mlistAction()
    {
        if($GLOBALS['TSFE']->fe_user->user['uid'] > 0) {
             $this->view->assign('login', 1);
        }
        $packages = $this->packageRepository->getNonPrivate();
        $this->view->assign('packages', $packages);
    }
    
    /**
     * List all the private packages
     */
    public function listPrivateAction()
    {
        $packages = $this->packageRepository->getPrivate();
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
            $noofpart = 0;
            
            if ($pack > 0) {
                $package = $this->packageRepository->findByUid($pack);
                $mnth = $package->getMnth();
                $this->view->assign('package', $package);
            }
            if ($this->request->hasArgument('qty')) {
                $qty = intval($this->request->getArgument('qty'));
            }
            if ($qty == 0) {
                $qty = 1;
            }
            if ($this->request->hasArgument('noofpart')) {
                $noofpart = intval($this->request->getArgument('noofpart'));
            }
            if ($noofpart == 0) {
                $noofpart = 1;
            }
            if ($this->request->hasArgument('total')) {
                $total = $this->request->getArgument('total');
            }
            if ($total == '') {
                if ($qty == 1) {
                    $total = ($package->getRate() * $qty * $mnth) + ($package->getDacost() * $noofpart);
                } elseif($qty == 2) {
                    $total = (($package->getRate() - $package->getRate() * $package->getRebate2() /100) * $qty * $mnth) + ($package->getDacost() * $noofpart); 
                } elseif($qty > 2 && $qty < 11) {
                    $total = (($package->getRate() - $package->getRate() * $package->getRebate3to10() /100) * $qty * $mnth) + ($package->getDacost() * $noofpart); 
                } else {
                    $total = (($package->getRate() - $package->getRate() * $package->getRebatemt10() /100) * $qty * $mnth) + ($package->getDacost() * $noofpart); 
                }
            }
            $amount = ($package->getRate() * $qty * $mnth) + ($package->getDacost() * $noofpart);
            $discount = $amount - $total;
            
            $this->view->assign('pack', $package->getTitle());
            $this->view->assign('total', number_format($total,2,",","."));
            $this->view->assign('qty', $qty);
            $this->view->assign('noofpart', $noofpart);
            $this->view->assign('amount', number_format($amount,2,",","."));
            $this->view->assign('discount', number_format($discount,2,",","."));
            $this->view->assign('feuser', $GLOBALS['TSFE']->fe_user->user['uid']);
            
        } else {
            $this->addFlashMessage('Please select a package', 
               '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
            $this->redirect("mlist");
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
            $total = str_replace('.', '', $total);
            $total = str_replace(',', '.', $total);
        }
        if ($this->request->hasArgument('qty')) {
            $qty = $this->request->getArgument('qty');
        }
        if ($this->request->hasArgument('noofpart')) {
            $noofpart = intval($this->request->getArgument('noofpart'));
        }
        if ($this->request->hasArgument('feuser')) {
            $feuser = $this->request->getArgument('feuser');
        }
        if ($this->request->hasArgument('package')) {
            $packuid = $this->request->getArgument('package');
        }
        if ($this->request->hasArgument('discount')) {
            $discount = $this->request->getArgument('discount');
            $discount = str_replace(',', '.', $discount);
        }
        if ($this->request->hasArgument('amount')) {
            $amount = $this->request->getArgument('amount');
            $amount = str_replace('.', '', $amount);
            $amount = str_replace(',', '.', $amount);
        }

        if ($packuid > 0 && $feuser > 0 && $total > 0 && $qty > 0 && $noofpart > 0) {
            
            $package = $this->packageRepository->findByUid($packuid);
            // Register the order
            $order = GeneralUtility::makeInstance('ARM\\Armpackage\\Domain\\Model\\Registration');
            $order->setFeuser($feuser);
            $order->setPtitle($package->getTitle());
            $order->setQty($qty);
            $order->setNoofpart($noofpart);
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
                        'email' => $GLOBALS['TSFE']->fe_user->user['email'], 
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
                $this->redirect('mlist');
            }
            
        } else {
             $this->addFlashMessage('Complete order information missing', 
                '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR, FALSE);
             //die('Order');
             $this->redirect('mlist');
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
        $discount = floatval($registration->getDiscount());
        $discount = number_format($discount,2,",",".");
        
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
            
            $country = 'Österreich';
            switch ($GLOBALS['TSFE']->fe_user->user['country']) {
                case 'CHF':
                    $country = 'Schweiz';
                    break;
                 case 'DEU':
                    $country = 'Deutschland';
                    break;
            }
            $y = $pdf::$pdf->GetY();
            $pdf::$pdf->SetY($y-5);
            $pdf::$pdf->SetX(17);
            $pdf::writeCell('Land', 15, 5, 0, 0);
            $pdf::writeCell($country, 48, 5, 0, 0);
            
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
            $pdf::writeCell($discount,30, 5, 1, 1, 'R');
            
            $pdf::setFont('helvetica',8,'B');
            $pdf::writeCell(' ',10, 5, 0, 0);
            $pdf::writeCell(' ',10, 5, 0, 0);
            $pdf::writeCell(' ',20, 5, 0, 0);
            $pdf::writeCell(' ',60, 5, 0, 0);
            $pdf::writeCell('Rechnungsbetrag',30, 5, 1, 0);
            $pdf::writeCell(' ',20, 5, 1, 0);
            $pdf::writeCell(number_format($registration->getTotal(),2,",","."),30, 5, 1, 1, 'R');
            $pdf::setFont('helvetica',8,'');
            $pdf::writeCell('       Bankverbindung: Begünstigter: Marcel Kuriger Marktmacher.com',180, 5, 1, 1);
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
        $templatePathAndFilename = $partialRootPath.'Email/PreStripe.html';

        $emailView->setTemplatePathAndFilename($templatePathAndFilename);
        $variables = [
                        'username'=>$GLOBALS['TSFE']->fe_user->user['username'],
                        'fname'=>$GLOBALS['TSFE']->fe_user->user['first_name'],
                        'lname'=>$GLOBALS['TSFE']->fe_user->user['last_name'],
                        'orderid'=>$registration->getUid(),
                        'currency'=>$this->settings['currency'],
                        'total'=>  number_format($registration->getTotal(),2,",","."),
                        'pdate'=>date("d.m.Y"),
                        'pstatus'=>'Pending',
                        'rate'=>  number_format($registration->getRate(),2,",","."),
                        'qty'=>  $registration->getQty(),
                        'noofpart'=>  $registration->getNoofpart(),
                        'discount'=>  number_format($registration->getDiscount(),2,",","."),
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
        
    
        if ($GLOBALS['TSFE']->fe_user->user['tx_femanager_activepack'] == 0 && $GLOBALS['TSFE']->fe_user->user['uid'] > 0) {
            $link = $this->uriBuilder->setTargetPageUid($this->settings['dashboardPid'])->build();
            $this->redirectToUri($link);
            die();
        }
        
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
               $this->addFlashMessage('Bitte geben Sie einen Benutzernamen ein', 
               '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
                $sub = FALSE;
            }
        }
        if ($this->request->hasArgument('company')) {
            $company =  $this->request->getArgument('company');
            if ($company == '') {
                 $this->addFlashMessage('Das Feld Unternehmen / Firma ist noch leer. Bitte geben Sie einen gültigen Benutzernamen ein.', 
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
            $rows = $queryBuilder->select('uid','company','tx_femanager_activepack')
                ->from('fe_users')
                ->where(
                    $queryBuilder->expr()->eq('deleted', 0),
                    $queryBuilder->expr()->eq('disable', 0),
                    $queryBuilder->expr()->eq('username', $queryBuilder->createNamedParameter($username))
                )
                ->execute()
                ->fetchAll();
            
            if (count($rows) > 0 && $rows[0]['tx_femanager_activepack']==1) {
                
                $cdata = $rows[0];
                $arr['status'] = 'OK';
                $arr['company'] = $cdata['company'];
                $arr['uid'] = $cdata['uid'];
                $arr['text'] = 'Der Benutzername wurde erfolgreich bestätigt.';
                      
            } else {
                
                $arr['status'] = 'ERR';
                
                if ($rows[0]['tx_femanager_activepack']==0) {
                    $arr['error'] = 'Das Seminar ist noch nicht abonniert. Sie können sich darum als Student nicht registrieren.';
                } else {
                    $arr['error'] = 'Benutzername "'. $username.'" ist ungültig. Bitte geben Sie den gültigen Benutzernamen ein. Sollen Sie diesen nicht kennen, fragen Sie bei Ihrem Unternehmen an.';
                }
            }
            
        } else {
            $arr['status'] = 'ERR';
            $arr['error'] = 'Nein Benutzername!';
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
        $noofpart = $params['arguments']['noofpart'];
        
        if (isset($puid) && $qty > 0 && $noofpart > 0) {
            
            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_armpackage_domain_model_package');
            $queryBuilder->getRestrictions()->removeAll();
            $rows = $queryBuilder->select('rate','dacost','rebate2','rebate3to10','rebatemt10','mnth')
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
                $rate = $cdata['rate'];
                $acost = $cdata['dacost'];
                $total = ($rate * $cdata['mnth'] * $qty) + ($acost * $noofpart);
                
                if ($qty == 2) {
                    $total = (($rate - ($rate *  $cdata['rebate2'] / 100 )) * $qty * $cdata['mnth']) + ($acost * $noofpart);
                } else if ($qty > 2 && $qty < 11) {
                    $total = (($rate - ($rate *  $cdata['rebate3to10'] / 100 )) * $qty * $cdata['mnth']) + ($acost * $noofpart);
                } else if ($qty > 10) {
                    $total = (($rate - ($rate *  $cdata['rebatemt10'] / 100 )) * $qty * $cdata['mnth']) + ($acost * $noofpart);
                }
                //$total = ceil($total);
                $amount = ($rate  * $qty * $cdata['mnth']) + ($acost * $noofpart);
                $discount = number_format(($amount - $total), 2, ",", ".");
                
                $arr['status'] = 'OK';
                $arr['total'] = number_format($total,2,",",".");
                $arr['discount'] = number_format($discount,2,",",".");
                $arr['amount'] = number_format($amount,2,",",".");
                      
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
                     $this->addFlashMessage('Bitte geben Sie den Benutzernamen ein, den Sie von Ihrem Unternehmen bekommen haben.', 
                   '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
                    $sub = FALSE;
                }
            }
            if ($this->request->hasArgument('company')) {
                $company =  $this->request->getArgument('company');
                if ($company == '') {
                     $this->addFlashMessage('Das Feld Unternehmen / Firma ist noch leer. Bitte geben Sie einen gültigen Benutzernamen ein.', 
                   '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
                    $sub = FALSE;
                }
            }
            if ($this->request->hasArgument('studentemail')) {
                
                $email =  $this->request->getArgument('studentemail');
                if ($email == '') {
                     $this->addFlashMessage('Bitte prüfen Sie Ihre Email Adresse.', 
                   '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
                    $sub = FALSE;
                }    
            }
            
            if ($sub) {
                
                $rec = $this->studentRepository->findByEmail($email);
                
                if ($rec->count() == 0) {
                    
                    $userObj = $this->userRepository->findByUid($feuser);

                    if ($userObj instanceof \TYPO3\CMS\Extbase\Domain\Model\FrontendUser) {

                        $studentRec = GeneralUtility::makeInstance(\ARM\Armpackage\Domain\Model\Studentemail::class);
                        $studentRec->setEmail($email);
                        $studentRec->setFeuser($feuser);
                        $studentRec->setPid($userObj->getPid());
                        $this->studentRepository->add($studentRec);
                        $persistenceManager = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
                        $persistenceManager->persistAll();
                        
                        $qb = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('fe_users');
                        $qb->getRestrictions()->removeAll();
                        $rows = $qb->select('tx_armpackage_students')
                                ->from('fe_users')
                                ->where(
                                    $qb->expr()->eq('uid', $qb->createNamedParameter($feuser))
                                )
                                ->execute()
                                ->fetch();
                        $currentStudentCnt = $rows['tx_armpackage_students'];
                        $qb->update('fe_users')
                        ->where(
                            $qb->expr()->eq('uid', $qb->createNamedParameter($feuser))
                        )
                        ->set('tx_armpackage_students', ++$currentStudentCnt)
                        ->execute();
                    }
                }
               $this->redirectToUri($this->settings['furnplanLoginUrl']);
            }
        }
    }
    
    /**
     * BE list all registrations
     */
    public function listallAction() 
    {
        $users = $this->userRepository->findAll();
        $regs = $this->regRepository->findAll();
        
        $this->view->assign('users', $users);
        $this->view->assign('registrations', $regs);
    }
    
    /**
     * BE search registrations
     */
    public function searchAction() 
    {
        if ($this->request->hasArgument('username')) {
            $userid = $this->request->getArgument('username');
            if ($userid > 0) {
                $regs = $this->regRepository->findByFeuser($userid);
                $this->view->assign('registrations', $regs);
            } else {
                $this->addFlashMessage('Please select username', 
                   '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
                $this->redirect('listall');
            }
        } else {
             $this->addFlashMessage('Please select username', 
                   '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
            $this->redirect('listall');
        }      
    }
    
    /**
     * My purchases
     * 
     */
    public function mypurchaseAction() 
    {
        $userid = $GLOBALS['TSFE']->fe_user->user['uid'];
        $regs = $this->regRepository->findByFeuser($userid);
        $this->view->assign('registrations', $regs);
    }
    
    /**
     * 
     * @param \ARM\Armpackage\Domain\Model\Registration $registration
     */
    public function reminderAction(\ARM\Armpackage\Domain\Model\Registration $registration) {
        
        if($registration != null) {
            //get the username and email
            $feuser = $registration->getFeuser();
            
            if ($feuser > 0) {
                
                $user = $this->userRepository->findByUid($feuser);
                $name = $user->getCompany();
                $email = $user->getEmail();
                
                $dtNow = new \DateTime("now");
                $packageMonth = $registration->getPackage()->getMnth();
                $regDate = $registration->getCrdate();
                $expDate = $regDate->add(new \DateInterval('P'.$packageMonth.'M'));
                
                $registration->setRdate($dtNow);
                
                $this->regRepository->update($registration);
                

                $this->addFlashMessage('Reminder successfuly sent', 
                   '', \TYPO3\CMS\Core\Messaging\AbstractMessage::INFO);
                if ($dtNow > $expDate) { //1st reminders
                    $this->sendBeEmail($email, $name, $expDate, 2);
                } else {
                    $this->sendBeEmail($email, $name, $expDate);
                }
                
                $this->redirect('listall');
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
    
    /**
     * 
     * @param string $email
     * @param string $name
     * @param \DateTime $edate
     * @param int $reminder
     */
    protected function sendBeEmail($email, $name, $edate, $reminder=1) {
        
        $emailView = $this->objectManager->get('TYPO3\\CMS\\Fluid\\View\\StandaloneView');
        $emailView->setFormat('html');

        $extbaseFrameworkConfiguration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
        $partialRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['templateRootPaths'][0]);
        $templatePathAndFilename = $partialRootPath.'Email/ReminderOne.html';
        $subject = 'Ihr Abo für das Seminar läuft am '.$edate->format("d-m-Y"); 
        
        if ($reminder == 2) {
            $subject = 'Ihr Abo für die Seminare der furnplan academy ist ausgelaufen';
            $templatePathAndFilename = $partialRootPath.'Email/ReminderTwo.html';
        }

        $emailView->setTemplatePathAndFilename($templatePathAndFilename);
        $emailView->assign('date', $edate->format("d-m-Y"));
        $extensionName = $this->request->getControllerExtensionName();
        $emailView->getRequest()->setControllerExtensionName($extensionName);
        
        $body = $emailView->render(); 

        // Mail senden
        $mail = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Mail\\MailMessage');

        
        $senderMail = 'admin@marktmacher.com';                       
        $senderName = 'Marktmacher.com';  
        
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
}
