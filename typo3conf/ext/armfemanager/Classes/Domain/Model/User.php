<?php
declare(strict_types=1);
namespace In2code\Armfemanager\Domain\Model;

use In2code\Femanager\Utility\UserUtility;
use TYPO3\CMS\Extbase\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Class User
 */
class User extends \In2code\Femanager\Domain\Model\User
{
    const TABLE_NAME = 'fe_users';
    
    /**
     * @var integer
     */
    protected $branch;

    /**
     * Returns the gender
     *
     * @return integer $branch
     */
    public function getBranch()
    {
        return $this->branch;
    }

    /**
     * Sets the gender
     *
     * @param integer $branch
     * @return User
     */
    public function setBranch($branch)
    {
        $this->branch = $branch;
        return $this;
    }
}
