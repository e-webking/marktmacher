<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:armpackage/Resources/Private/Language/locallang_db.xlf:tx_armpackage_domain_model_studentemail',
        'label' => 'email',
        'label_alt' => 'feuser',
        'label_alt_force' => true,
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'versioningWS' => false,
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'feuser,email,',
        'iconfile' => 'EXT:armpackage/Resources/Public/Icons/tx_armpackage_domain_model_registration.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'hidden, feuser, email',
    ],
    'types' => [
        '1' => ['showitem' => 'hidden, feuser, email, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
    ],
    'columns' => [
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:lang/Resources/Private/Language/locallang_core.xlf:labels.enabled'
                    ]
                ],
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'behaviour' => [
                'allowLanguageSynchronization' => true
            ],
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 13,
                'eval' => 'datetime',
                'default' => 0,
            ],
        ],
        'endtime' => [
            'exclude' => true,
            'behaviour' => [
                'allowLanguageSynchronization' => true
            ],
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 13,
                'eval' => 'datetime',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038)
                ],
            ],
        ],
        'feuser' => [
            'exclude' => true,
            'label' => 'LLL:EXT:armpackage/Resources/Private/Language/locallang_db.xlf:tx_armpackage_domain_model_studentemail.feuser',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 0,
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'fe_users',
            ]
        ],
        'email' => [
            'exclude' => true,
            'label' => 'LLL:EXT:armpackage/Resources/Private/Language/locallang_db.xlf:tx_armpackage_domain_model_studentemail.email',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim'
            ]
        ], 
    ],
];
