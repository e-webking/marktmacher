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
class FormViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

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
	 * @param integer $orderid
	 * @param float $amount
	 */
	public function render($orderid, $amount) {

		$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');

		// Get the configuration manager
		$configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
		$configurationManager->injectObjectManager($objectManager);
		$settings = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManager::CONFIGURATION_TYPE_FRAMEWORK, $this->extensionName, $this->pluginName);

		$formView = $objectManager->get('TYPO3\\CMS\\Fluid\\View\\StandaloneView');
		$templateRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($settings['view']['templateRootPath']);
		$templatePathAndFilename = $templateRootPath . 'Payment/Form.html';
		$formView->setTemplatePathAndFilename($templatePathAndFilename);
		$formView->assign('orderid', $orderid);
		$formView->assign('amount', $amount);
		$formView->assign('processUid', $settings['settings']['processUid']);

		return $formView->render();
	}
}