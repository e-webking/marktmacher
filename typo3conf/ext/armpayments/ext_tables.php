<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

//$extensionName = \TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($_EXTKEY);
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['armpayments']['setup'] = unserialize($_EXTCONF);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'Pi1',
	'Payment Form'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'Pi2',
	'Payment Confirmation'
);

//Add Typoscript
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'ARM Payments');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_armpayments_domain_model_payment', 'EXT:armpayments/Resources/Private/Language/locallang_csh_tx_armpayments_domain_model_payment.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_armpayments_domain_model_payment');
