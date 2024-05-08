<?php

/**
 * Table configuration fe_users
 */
$feUsersColumns = [
    'tx_femanager_branch' => [
        'label' => 'LLL:EXT:armfemanager/Resources/Private/Language/locallang_db.xlf:' .
            'tx_femanager_domain_model_user.tx_femanager_branch',
            'exclude' => true,
            'config' => [
                'type' => 'input',
                'size' => 10,
                'eval' => 'int',
            ]
    ],
    'tx_femanager_activepack' => [
        'label' => 'LLL:EXT:armfemanager/Resources/Private/Language/locallang_db.xlf:' .
            'tx_femanager_domain_model_user.tx_femanager_activepack',
            'exclude' => true,
            'config' => [
                'type' => 'check'
            ]
    ],
    'tx_femanager_responsible' => [
        'label' => 'LLL:EXT:armfemanager/Resources/Private/Language/locallang_db.xlf:' .
            'tx_femanager_domain_model_user.tx_femanager_responsible',
            'exclude' => true,
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
            ]
    ],
    'tx_armpackage_students'=> [
        'label' => 'LLL:EXT:armfemanager/Resources/Private/Language/locallang_db.xlf:' .
            'tx_femanager_domain_model_user.tx_armpackage_students',
            'exclude' => true,
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_armpackage_domain_model_studentemail',
                'foreign_field' => 'feuser',
                'maxitems'      => 9999,
            ]
    ],
];
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'fe_users',
    'tx_armpackage_students',
    '',
    'after:lastlogin'
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'fe_users',
    'tx_femanager_branch,tx_femanager_activepack,tx_femanager_responsible',
    '',
    'after:company'
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('fe_users', $feUsersColumns);