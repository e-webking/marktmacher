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
 * Registration
 */
class Registration extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * feuser
     *
     * @var int
     */
    protected $feuser = 0;
    
    /**
     *
     * @var \DateTime
     */
    protected $crdate;
    
    /**
     *
     * @var string
     */
    protected $ptitle = '';

    /**
     * qty
     *
     * @var int
     */
    protected $qty = 0;
    
    /**
     * status
     *
     * @var int
     */
    protected $status = 0;

    /**
     * rate
     *
     * @var float
     */
    protected $rate = 0.0;
    
    /**
     * currency
     *
     * @var string
     */
    protected $currency = '';

    /**
     * amount
     *
     * @var float
     */
    protected $amount = 0.0;

    /**
     * discount
     *
     * @var float
     */
    protected $discount = 0.0;

    /**
     * vat
     *
     * @var float
     */
    protected $vat = 0.0;

    /**
     * total
     *
     * @var float
     */
    protected $total = 0.0;
    
    /**
     *
     * @var DateTime 
     */
    protected $rdate;

    /**
     * package
     *
     * @var \ARM\Armpackage\Domain\Model\Package
     */
    protected $package = null;

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
     * Returns the qty
     *
     * @return int $qty
     */
    public function getQty()
    {
        return $this->qty;
    }

    /**
     * Sets the qty
     *
     * @param int $qty
     * @return void
     */
    public function setQty($qty)
    {
        $this->qty = $qty;
    }
    
    /**
     * Returns the status
     *
     * @return int $status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Sets the status
     *
     * @param int $status
     * @return void
     */
    public function setStatus($status)
    {
        $this->status = $status;
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
     * Returns the amount
     *
     * @return float $amount
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Sets the amount
     *
     * @param float $amount
     * @return void
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * Returns the discount
     *
     * @return float $discount
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * Sets the discount
     *
     * @param float $discount
     * @return void
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;
    }

    /**
     * Returns the vat
     *
     * @return float $vat
     */
    public function getVat()
    {
        return $this->vat;
    }

    /**
     * Sets the vat
     *
     * @param float $vat
     * @return void
     */
    public function setVat($vat)
    {
        $this->vat = $vat;
    }

    /**
     * Returns the total
     *
     * @return float $total
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Sets the total
     *
     * @param float $total
     * @return void
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }

    /**
     * Returns the package
     *
     * @return \ARM\Armpackage\Domain\Model\Package $package
     */
    public function getPackage()
    {
        return $this->package;
    }

    /**
     * Sets the package
     *
     * @param \ARM\Armpackage\Domain\Model\Package $package
     * @return void
     */
    public function setPackage(\ARM\Armpackage\Domain\Model\Package $package)
    {
        $this->package = $package;
    }
    
    /**
     * Returns the currency
     *
     * @return string $currency
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Sets the currency
     *
     * @param string $currency
     * @return void
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }
    
    /**
     * Returns the ptitle
     *
     * @return string $ptitle
     */
    public function getPtitle()
    {
        return $this->ptitle;
    }

    /**
     * Sets the ptitle
     *
     * @param string $ptitle
     * @return void
     */
    public function setPtitle($ptitle)
    {
        $this->ptitle = $ptitle;
    }
    
    /**
     * Returns the crdate
     *
     * @return \DateTime $crdate
     */
    public function getCrdate() {
        return $this->crdate;
    }

    /**
     * Sets the crdate
     *
     * @param \DateTime $crdate
     * 
     */
    public function setCrdate($crdate) {
        $this->crdate = $crdate;
    }
    
    /**
     * Returns the rdate
     *
     * @return DateTime $rdate
     */
    public function getRdate() {
        return $this->rdate;
    }

   /**
    * Sets the rdate
    *
    * @param DateTime $rdate
    * @return void
    */
   public function setRdate($rdate) {
        $this->rdate = $rdate;
   }
}
