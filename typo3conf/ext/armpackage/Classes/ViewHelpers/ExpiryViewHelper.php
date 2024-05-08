<?php
namespace ARM\Armpackage\ViewHelpers;

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * 
 */
class ExpiryViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {
    
    /**
     * registrationRepository
     *
     * @var \ARM\Armpackage\Domain\Repository\RegistrationRepository
     * @inject
     */
    protected $registrationRepository;

    /**
     * @param int $discount
     * @return mixed
     */
    public function render($uid) {
        
        if (intval($uid) > 0) {
            
           $reg = $this->registrationRepository->findByUid($uid);
           
           if ($reg instanceof \ARM\Armpackage\Domain\Model\Registration) {
               
               $tdate = $reg->getCrdate();
               $packmonth = $reg->getPackage()->getMnth();
      
               $expiryDate = $tdate->add(new \DateInterval('P'.$packmonth.'M'));
               
               return $expiryDate;
            }
        }
        
        return;
    }
}
