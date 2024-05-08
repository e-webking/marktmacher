<?php
namespace ARM\Armpackage\ViewHelpers;

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * 
 */
class SendReminderViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {
    
    /**
     * registrationRepository
     *
     * @var \ARM\Armpackage\Domain\Repository\RegistrationRepository
     * @inject
     */
    protected $registrationRepository;
    
    /**
     *
     * @var int 
     */
    protected $intday = 10;


    /**
     * @param int $discount
     * @return bool
     */
    public function render($uid) {
        
        if (intval($uid) > 0) {
            
           $reg = $this->registrationRepository->findByUid($uid);
           
           if ($reg instanceof \ARM\Armpackage\Domain\Model\Registration) {
               
               $status = $reg->getStatus();
               $tdate = $reg->getCrdate();
               $ndate = new \DateTime("now");
               $packmonth = $reg->getPackage()->getMnth();
      
               $expiryDate = $tdate->add(new \DateInterval('P'.$packmonth.'M'));
               if ($status == 2) {
                    if ($expiryDate > $ndate) {
                        $intReg = $expiryDate->diff($ndate)->format("%a");
                        if ($intReg < $this->intday) {
                            return TRUE;
                        }
                    } else {
                        return TRUE;
                    }
               }
           }
        }
        
        return FALSE;
    }
}
