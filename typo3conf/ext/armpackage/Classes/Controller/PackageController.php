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

    }

    /**
     * action confirm
     *
     * @return void
     */
    public function confirmAction()
    {

    }
    
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
