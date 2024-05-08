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
     *
     * @var int
     */
    protected $active;
    
    /**
     * 
     * @var string
     */
    protected $responsible;
    
    /**
     * 
     * @var \int
     */
    protected $students;
    
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
    
    /**
     * Returns the active
     *
     * @return integer $active
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Sets the active
     *
     * @param integer $active
     * @return User
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    /**
     * Returns the responsible
     *
     * @return string $responsible
     */
    public function getResponsible()
    {
        return $this->responsible;
    }

    /**
     * Sets the responsible
     *
     * @param string $responsible
     * @return User
     */
    public function setResponsible($responsible)
    {
        $this->responsible = $responsible;
        return $this;
    }
    
    /**
     * 
     * @return \int
     */
    public function getStudents() {
        return $this->students;
    }
    
    /**
     * Sets the $students
     *
     * @param \int $students
     * @return void
     */
    public function setStudents($students) {
        $this->students = $students;
    }
}
