<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:armpackage/Resources/Private/Language/locallang_db.xlf:tx_armpackage_domain_model_branch',
        'label' => 'company',
        'label_alt' => 'address',
        'label_alt_force' => true,
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'feuser,qty,rate,amount,discount,vat,total,package',
        'iconfile' => 'EXT:armpackage/Resources/Public/Icons/tx_armpackage_domain_model_branch.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, feuser, company, address, city, zip, country',
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, feuser, company, address, city, zip, country, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'special' => 'languages',
                'items' => [
                    [
                        'LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages',
                        -1,
                        'flags-multiple'
                    ]
                ],
                'default' => 0,
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 0,
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_armpackage_domain_model_branch',
                'foreign_table_where' => 'AND tx_armpackage_domain_model_branch.pid=###CURRENT_PID### AND tx_armpackage_domain_model_branch.sys_language_uid IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        't3ver_label' => [
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            ],
        ],
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
            'label' => 'LLL:EXT:armpackage/Resources/Private/Language/locallang_db.xlf:tx_armpackage_domain_model_branch.feuser',
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
        'company' => [
            'exclude' => true,
            'label' => 'LLL:EXT:armpackage/Resources/Private/Language/locallang_db.xlf:tx_armpackage_domain_model_branch.company',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim'
            ]
        ],
        'address' => [
            'exclude' => true,
            'label' => 'LLL:EXT:armpackage/Resources/Private/Language/locallang_db.xlf:tx_armpackage_domain_model_branch.address',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ]
        ],
        'city' => [
            'exclude' => true,
            'label' => 'LLL:EXT:armpackage/Resources/Private/Language/locallang_db.xlf:tx_armpackage_domain_model_branch.city',
            'config' => [
                'type' => 'input',
                'size' => 15,
                'eval' => 'trim'
            ]
        ],
        'zip' => [
            'exclude' => true,
            'label' => 'LLL:EXT:armpackage/Resources/Private/Language/locallang_db.xlf:tx_armpackage_domain_model_branch.zip',
            'config' => [
                'type' => 'input',
                'size' => 10,
                'eval' => 'trim'
            ]
        ],
        'country' => [
            'exclude' => true,
            'label' => 'LLL:EXT:armpackage/Resources/Private/Language/locallang_db.xlf:tx_armpackage_domain_model_branch.country',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['-- select --', ''],
                    ['Deutschland','DEU'],
                    ['Schweiz','CHF'],
                    ['Österreich','AUT']
                ],
            ]
        ],    
    ],
];
