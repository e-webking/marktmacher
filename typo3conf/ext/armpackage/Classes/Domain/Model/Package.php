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
 * Package
 */
class Package extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * title
     *
     * @var string
     */
    protected $title = '';

    /**
     * subtitle
     *
     * @var string
     */
    protected $subtitle = '';

    /**
     * brief
     *
     * @var string
     */
    protected $brief = '';
    
    /**
     *
     * @var int
     */
    public $privatepkg = 0;


    /**
     *
     * @var int
     */
    protected $mnth = 0;

    /**
     * rate
     *
     * @var float
     */
    protected $rate = 0.0;
    
    /**
     * 
     * @var float
     */
    protected $dacost = 0.0;


    /**
     *
     * @var float
     */
    protected $dsprate = 0.0;

    /**
     * rebate2
     *
     * @var float
     */
    protected $rebate2 = 0.0;

    /**
     * rebate3to10
     *
     * @var float
     */
    protected $rebate3to10 = 0.0;

    /**
     * rebatemt10
     *
     * @var float
     */
    protected $rebatemt10 = 0.0;
    
    /**
     * 
     * @var string
     */
    protected $additionalcost = '';
    
    /**
     * 
     * @var string
     */
    protected $note = '';

    /**
     * Returns the title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title
     *
     * @param string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Returns the subtitle
     *
     * @return string $subtitle
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * Sets the subtitle
     *
     * @param string $subtitle
     * @return void
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;
    }

    /**
     * Returns the brief
     *
     * @return string $brief
     */
    public function getBrief()
    {
        return $this->brief;
    }

    /**
     * Sets the brief
     *
     * @param string $brief
     * @return void
     */
    public function setBrief($brief)
    {
        $this->brief = $brief;
    }
    
    /**
     * Returns the privatepkg
     *
     * @return int $privatepkg
     */
    public function getPrivatepkg()
    {
        return $this->privatepkg;
    }

    /**
     * Sets the privatepkg
     *
     * @param int $privatepkg
     * @return void
     */
    public function setPrivatepkg($privatepkg)
    {
        $this->privatepkg = $privatepkg;
    }
    
    /**
     * Returns the mnth
     *
     * @return int $mnth
     */
    public function getMnth()
    {
        return $this->mnth;
    }

    /**
     * Sets the mnth
     *
     * @param int $mnth
     * @return void
     */
    public function setMnth($mnth)
    {
        $this->mnth = $mnth;
    }

    /**
     * Returns the rate
     *
     * @return float $rate
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * Sets the rate
     *
     * @param float $rate
     * @return void
     */
    public function setRate($rate)
    {
        $this->rate = $rate;
    }
    
    /**
     * Returns the dsprate
     *
     * @return float $dsprate
     */
    public function getDsprate()
    {
        return $this->dsprate;
    }

    /**
     * Sets the dsprate
     *
     * @param float $dsprate
     * @return void
     */
    public function setDsprate($dsprate)
    {
        $this->dsprate = $dsprate;
    }

    /**
     * Returns the rebate2
     *
     * @return float $rebate2
     */
    public function getRebate2()
    {
        return $this->rebate2;
    }

    /**
     * Sets the rebate2
     *
     * @param float $rebate2
     * @return void
     */
    public function setRebate2($rebate2)
    {
        $this->rebate2 = $rebate2;
    }

    /**
     * Returns the rebate3to10
     *
     * @return float $rebate3to10
     */
    public function getRebate3to10()
    {
        return $this->rebate3to10;
    }

    /**
     * Sets the rebate3to10
     *
     * @param float $rebate3to10
     * @return void
     */
    public function setRebate3to10($rebate3to10)
    {
        $this->rebate3to10 = $rebate3to10;
    }

    /**
     * Returns the rebatemt10
     *
     * @return float $rebatemt10
     */
    public function getRebatemt10()
    {
        return $this->rebatemt10;
    }

    /**
     * Sets the rebatemt10
     *
     * @param float $rebatemt10
     * @return void
     */
    public function setRebatemt10($rebatemt10)
    {
        $this->rebatemt10 = $rebatemt10;
    }
    
    /**
     * Returns the additionalcost
     *
     * @return string $additionalcost
     */
    public function getAdditionalcost()
    {
        return $this->additionalcost;
    }

    /**
     * Sets the additionalcost
     *
     * @param string $additionalcost
     * @return void
     */
    public function setAdditionalcost($additionalcost)
    {
        $this->additionalcost = $additionalcost;
    }
    
    /**
     * Returns the note
     *
     * @return string $note
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Sets the note
     *
     * @param string $note
     * @return void
     */
    public function setNote($note)
    {
        $this->note = $note;
    }
    
    /**
     * Returns the dacost
     *
     * @return float $dacost
     */
    public function getDacost()
    {
        return $this->dacost;
    }

    /**
     * Sets the dacost
     *
     * @param float $dacost
     * @return void
     */
    public function setDacost($dacost)
    {
        $this->dacost = $dacost;
    }
}
