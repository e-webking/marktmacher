<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

/***************
 * Register fields
 */
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
        '--palette--;Link;tx_armlinkclass', '1' ,'after:nav_title');

$GLOBALS['TCA']['pages']['palettes']['tx_armlinkclass'] = array(
    'showitem' => 'tx_armlinkclass'
);