<?php
if (!is_array($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY])) {
    $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY] = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY]);
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'ARM Template');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:armtemplate/Configuration/TypoScript/TsConfig/pageTSConfig.txt">');

$fields = array(
        'tx_armlinkclass' => array(
            'label' => 'LLL:EXT:armtemplate/Resources/Private/Language/locallang_db.xlf:field.armlinkclass',
            'exclude' => 0,
            'config' => [
                'type' => 'input',
                'size' => 20,
            ],
        )
    );


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('pages', $fields);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('pages', 
        'tx_armlinkclass', '' ,'after:nav_title');

$GLOBALS['TCA']['pages']['palettes']['tx_armlinkclass'] = array(
    'showitem' => 'tx_armlinkclass'
);