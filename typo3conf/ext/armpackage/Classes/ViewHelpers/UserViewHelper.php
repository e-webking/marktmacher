<?php
namespace ARM\Armpackage\ViewHelpers;

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * 
 */
class UserViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {
    
    /**
     * userRepository
     *
     * @var \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository
     * @inject
     */
    protected $userRepository;
    
    /**
     * @param int $discount
     * @return string
     */
    public function render($userid) {
        
        $user = $this->userRepository->findByUid($userid);
        if ($user instanceof \TYPO3\CMS\Extbase\Domain\Model\FrontendUser) {
           return $user->getUsername();
        } else {
            return 'N/A';
        }
    }
}
