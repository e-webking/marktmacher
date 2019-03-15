<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

$_EXTCONF = unserialize($_EXTCONF);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'ARM.'.$_EXTKEY,
	'Pi1',
	array(
		'Payment' => 'process,stripeform',
	),
	// non-cacheable actions
	array(
		'Payment' => 'process,stripeform',
	)
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'ARM.'.$_EXTKEY,
	'Pi2',
	array(
		'Payment' => 'stripereturn',
	),
	// non-cacheable actions
	array(
		'Payment' => 'stripereturn',
	)
);


if (!is_array($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY])) {
    $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY] = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY]);
}

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['armpayments']['tx_armpayments_pi1']['paymentProcess'][] = \ARM\Armpayments\Hooks\Handler::class;

if (is_array($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY])) {
    $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY] = serialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY]);
}
