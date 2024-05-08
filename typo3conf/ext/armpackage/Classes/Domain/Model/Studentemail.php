<?php
namespace ARM\Armpackage\Domain\Model;

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

/**
 * Studentemail
 */
class Studentemail extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * feuser
     *
     * @var int
     */
    protected $feuser = 0;
    
    /**
     *
     * @var string
     */
    protected $email = '';
    
    /**
     * Returns the feuser
     *
     * @return int $feuser
     */
    public function getFeuser()
    {
        return $this->feuser;
    }

    /**
     * Sets the feuser
     *
     * @param int $feuser
     * @return void
     */
    public function setFeuser($feuser)
    {
        $this->feuser = $feuser;
    }
    
    /**
     * Returns the email
     *
     * @return string $email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Sets the email
     *
     * @param string $email
     * @return void
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
}
