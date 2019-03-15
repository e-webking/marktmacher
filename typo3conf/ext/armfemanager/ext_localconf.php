<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:' . $_EXTKEY . '/Configuration/TypoScript/PageTs/TsConfig.txt">');

$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['In2code\\Femanager\\ViewHelpers\\Form\\GetCountriesViewHelper'] = array('className' => 'In2code\\Armfemanager\\ViewHelpers\\Form\\GetCountriesViewHelper');