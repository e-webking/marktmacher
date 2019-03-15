<?php
namespace ARM\Armpayments\ViewHelpers;
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
class LinkViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * @var string Name of the extension this view helper belongs to
	 */
	protected $extensionName = 'Armpayments';

	/**
	 * @var string Name of the extension this view helper belongs to
	 */
	protected $extensionKey = 'armpayments';

	/**
	 * @var string Name of the plugin this view helper belongs to
	 */
	protected $pluginName = 'tx_armpayments';

	/**
	 *
	 * @var string
	 */
	protected $controllerName = 'Payment';

	/**
	 * @var \TYPO3\CMS\Extbase\MVC\Web\Routing\UriBuilder
	 */
	protected $uriBuilder;


	public function injectUriBuilder(\TYPO3\CMS\Extbase\MVC\Web\Routing\UriBuilder $uriBuilder) {
		$this->uriBuilder = $uriBuilder;
	}

	/**
	 * @param integer $orderid
	 * @param float $amount Target action
	 * @param float $vat
	 * @param string $currency
	 * @param string $tablename
	 * @return string Rendered link
	 */
	public function render($orderid, $amount, $vat, $currency, $tablename) {
		
		$conf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['armpayments']);
		$payMethods = array();

		$controllerContext = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\MVC\\Controller\\ControllerContext');
		$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');

		// Get the configuration manager
		$configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
		$settings = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManager::CONFIGURATION_TYPE_FRAMEWORK, $this->extensionName, $this->pluginName);
		$this->uriBuilder->setArgumentPrefix('tx_armpayments_pi1');
		if ($settings['settings']['paypal'] == 1) {
			$uriPal = $this->uriBuilder
			->setTargetPageUid($settings['settings']['processPid'])
			->setTargetPageType(0)
			->setNoCache(TRUE)
			->setUseCacheHash(FALSE)
			->setSection('')
			->setFormat('')
			->setLinkAccessRestrictedPages(FALSE)
			->setCreateAbsoluteUri(FALSE)
			->uriFor('process', array('orderid' => $orderid,'amount' => $amount, 'vat' => $vat, 'currency' => $currency, 'tablename' => $tablename, 'method'=> 'paypal'), $this->controllerName, $this->extensionName, $this->pluginName);
			$payMethods['paypal'] = array('name' => 'paypal', 'link' => $uriPal);
		}
		
		if ($settings['settings']['paymill'] == 1) {
			$totalAmount = ($amount + $vat);
			$totalAmountDeci = $totalAmount * 100;
			$uriPaymill = $this->uriBuilder
			->setTargetPageUid($settings['settings']['processPid'])
			->setTargetPageType(0)
			->setNoCache(TRUE)
			->setUseCacheHash(FALSE)
			->setSection('')
			->setFormat('')
			->setLinkAccessRestrictedPages(FALSE)
			->setCreateAbsoluteUri(FALSE)
			->uriFor('process', array('orderid' => $orderid,'amount' => $amount, 'vat' => $vat, 'currency' => $currency, 'tablename' => $tablename, 'method'=> 'paymill'), $this->controllerName, $this->extensionName, $this->pluginName);
			$payMethods['paymill'] = array('name' => 'paymill', 'link' => $uriPaymill, 'orderid' => $orderid, 'amount' => $amount, 'vat' => $vat, 'currency' => $currency, 'totalAmount' => $totalAmount, 'totalAmountCent' => $totalAmountDeci, 'paymillKey' => $conf['paymillPubKey']);
		}
		return $payMethods;
	}

}