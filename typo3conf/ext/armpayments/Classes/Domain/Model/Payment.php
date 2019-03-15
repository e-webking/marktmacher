<?php
namespace ARM\Armpayments\Domain\Model;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Anisur R. Mullick <anisur@armtechnologies.com>, ARM Technologies
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 *
 * @package TYPO3
 * @subpackage armpayments
 * @author Anisur R. Mullick <anisur@armtechnologies.com>
 * @version 1.1.0
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 *
 */
class Payment extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * gateway
	 *
	 * @var string
	 */
	protected $gateway;

	/**
	 * amount
	 *
	 * @var float
	 * @validate NotEmpty
	 */
	protected $amount;

	/**
	 * sub-total
	 *
	 * @var float
	 */
	protected $subtotal;
	
	
	/**
	 * tax
	 *
	 * @var float
	 */
	protected $tax;
	
	
	/**
	 * @var string
	 */
	protected $tablename;
	
	/**
	 * @var string
	 */
	protected $currency;

	/**
	 *
	 * @var string
	 */
	protected $transactionid;

	/**
	 * crdate
	 *
	 * @var DateTime
	 */
	protected $crdate;

	/**
	 * orderid
	 *
	 * @var integer
	 */
	protected $orderid;

	/**
	 *
	 * @var string
	 */
	protected $token;

	/**
	 *
	 * @var string
	 */
	protected $payer;


	/**
	 *
	 * @var integer
	 */
	protected $status;

	/**
	 * Returns the gateway
	 *
	 * @return string $gateway
	 */
	public function getGateway() {
		return $this->gateway;
	}

	/**
	 * Sets the gateway
	 *
	 * @param string $gateway
	 * @return void
	 */
	public function setGateway($gateway) {
		$this->gateway = $gateway;
	}
	
	/**
	 * Returns the currency
	 *
	 * @return string $currency
	 */
	public function getCurrency() {
		return $this->currency;
	}
	
	/**
	 * Sets the currency
	 *
	 * @param string $currency
	 * @return void
	 */
	public function setCurrency($currency) {
		$this->currency = $currency;
	}

	/**
	 * Returns the amount
	 *
	 * @return float $amount
	 */
	public function getAmount() {
		return $this->amount;
	}

	/**
	 * Sets the amount
	 *
	 * @param float $amount
	 * @return void
	 */
	public function setAmount($amount) {
		$this->amount = $amount;
	}

	/**
	 * Returns the transactionid
	 *
	 * @return string $transactionid
	 */
	public function getTransactionid() {
		return $this->transactionid;
	}

	/**
	 * Sets the transactionid
	 *
	 * @param string $transactionid
	 * @return void
	 */
	public function setTransactionid($transactionid) {
		$this->transactionid = $transactionid;
	}

	/**
	 * Returns the crdate
	 *
	 * @return DateTime $crdate
	 */
	public function getCrdate() {
		return $this->crdate;
	}

	/**
	 * Sets the crdate
	 *
	 * @param DateTime $crdate
	 * @return void
	 */
	public function setCrdate($crdate) {
		$this->crdate = $crdate;
	}

	/**
	 * Returns the oorderid
	 *
	 * @return integer $oorderid
	 */
	public function getOrderid() {
		return $this->orderid;
	}

	/**
	 * Sets the orderid
	 *
	 * @param integer $orderid
	 * @return void
	 */
	public function setOrderid($orderid) {
		$this->orderid = $orderid;
	}

	/**
	 * Returns the tablename
	 *
	 * @return string $tablename
	 */
	public function getTablename() {
		return $this->tablename;
	}

	/**
	 * Sets the tablename
	 *
	 * @param string $tablename
	 * @return void
	 */
	public function setTablename($tablename) {
		$this->tablename = $tablename;
	}

	/**
	 * Returns the token
	 *
	 * @return string $token
	 */
	public function getToken() {
		return $this->token;
	}

	/**
	 * Sets the token
	 *
	 * @param string $token
	 * @return void
	 */
	public function setToken($token) {
		$this->token = $token;
	}

	/**
	 * Returns the payer
	 *
	 * @return string $payer
	 */
	public function getPayer() {
		return $this->payer;
	}

	/**
	 * Sets the payer
	 *
	 * @param string $payer
	 * @return void
	 */
	public function setPayer($payer) {
		$this->payer = $payer;
	}

	/**
	 * Returns the status
	 *
	 * @return integer $status
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * Sets the status
	 *
	 * @param integer $status
	 * @return void
	 */
	public function setStatus($status) {
		$this->status = $status;
	}
	
	/**
	 * Returns the tax
	 *
	 * @return float $tax
	 */
	public function getTax() {
		return $this->tax;
	}
	
	/**
	 * Sets the tax
	 *
	 * @param float $tax
	 * @return void
	 */
	public function setTax($tax) {
		$this->tax = $tax;
	}
	
	/**
	 * Returns the subtotal
	 *
	 * @return float $subtotal
	 */
	public function getSubtotal() {
		return $this->subtotal;
	}
	
	/**
	 * Sets the subtotal
	 *
	 * @param float $subtotal
	 * @return void
	 */
	public function setSubtotal($subtotal) {
		$this->subtotal = $subtotal;
	}
}
