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
    ]
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'fe_users',
    'tx_femanager_branch,tx_femanager_activepack',
    '',
    'after:company'
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('fe_users', $feUsersColumns);