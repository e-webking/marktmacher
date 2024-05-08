<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:' . $_EXTKEY . '/Configuration/TypoScript/PageTs/TsConfig.txt">');

$extbaseObjectContainer = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Object\Container\Container::class);
$extbaseObjectContainer->registerImplementation(
    \In2code\Femanager\Controller\NewController::class,
    \In2code\Armfemanager\Controller\NewController::class
);
$extbaseObjectContainer->registerImplementation(
    \In2code\Femanager\Controller\EditController::class,
    \In2code\Armfemanager\Controller\EditController::class
);

$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\\CMS\\Extbase\\Mvc\\Controller\\Argument'] = array('className' => 'In2code\\Armfemanager\\Xclass\\Extbase\\Mvc\\Controller\\Argument');

$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['In2code\\Femanager\\ViewHelpers\\Form\\GetCountriesViewHelper'] = array('className' => 'In2code\\Armfemanager\\ViewHelpers\\Form\\GetCountriesViewHelper');