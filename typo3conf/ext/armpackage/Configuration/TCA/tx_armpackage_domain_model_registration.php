<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:armpackage/Resources/Private/Language/locallang_db.xlf:tx_armpackage_domain_model_registration',
        'label' => 'feuser',
        'label_alt' => 'ptitle',
        'label_alt_force'=>TRUE,
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'default_sortby' => 'uid DESC',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'feuser,ptitle,qty,rate,amount,discount,vat,total,package,status,rdate,',
        'iconfile' => 'EXT:armpackage/Resources/Public/Icons/tx_armpackage_domain_model_registration.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, feuser, ptitle, status, qty, rate, currency, amount, discount, vat, total, package, rdate',
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, feuser, ptitle, status, rate, currency, qty, amount, discount, vat, total, package, rdate, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
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
                'foreign_table' => 'tx_armpackage_domain_model_registration',
                'foreign_table_where' => 'AND tx_armpackage_domain_model_registration.pid=###CURRENT_PID### AND tx_armpackage_domain_model_registration.sys_language_uid IN (-1,0)',
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
            'label' => 'LLL:EXT:armpackage/Resources/Private/Language/locallang_db.xlf:tx_armpackage_domain_model_registration.feuser',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'fe_users',
                'minitems' => 0,
                'maxitems' => 1,
            ]
        ],
        'ptitle' => [
            'exclude' => true,
            'label' => 'LLL:EXT:armpackage/Resources/Private/Language/locallang_db.xlf:tx_armpackage_domain_model_registration.ptitle',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ]
        ],
        'status' => [
            'exclude' => true,
            'label' => 'LLL:EXT:armpackage/Resources/Private/Language/locallang_db.xlf:tx_armpackage_domain_model_registration.status',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['Pending', 0],
                    ['Payment initiated', 1],
                    ['Success', 2],
                    ['Rejected', 3],
                ],
                'default' => 0,
            ]
        ],
        'currency' => [
            'exclude' => true,
            'label' => 'LLL:EXT:armpackage/Resources/Private/Language/locallang_db.xlf:tx_armpackage_domain_model_registration.currency',
            'config' => [
                'type' => 'input',
                'size' => 4,
                'eval' => 'trim'
            ]
        ],
        'qty' => [
            'exclude' => true,
            'label' => 'LLL:EXT:armpackage/Resources/Private/Language/locallang_db.xlf:tx_armpackage_domain_model_registration.qty',
            'config' => [
                'type' => 'input',
                'size' => 4,
                'eval' => 'int'
            ]
        ],
        'rate' => [
            'exclude' => true,
            'label' => 'LLL:EXT:armpackage/Resources/Private/Language/locallang_db.xlf:tx_armpackage_domain_model_registration.rate',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'double2'
            ]
        ],
        'amount' => [
            'exclude' => true,
            'label' => 'LLL:EXT:armpackage/Resources/Private/Language/locallang_db.xlf:tx_armpackage_domain_model_registration.amount',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'double2'
            ]
        ],
        'discount' => [
            'exclude' => true,
            'label' => 'LLL:EXT:armpackage/Resources/Private/Language/locallang_db.xlf:tx_armpackage_domain_model_registration.discount',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'double2'
            ]
        ],
        'vat' => [
            'exclude' => true,
            'label' => 'LLL:EXT:armpackage/Resources/Private/Language/locallang_db.xlf:tx_armpackage_domain_model_registration.vat',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'double2'
            ]
        ],
        'total' => [
            'exclude' => true,
            'label' => 'LLL:EXT:armpackage/Resources/Private/Language/locallang_db.xlf:tx_armpackage_domain_model_registration.total',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'double2'
            ]
        ],
        'rdate' => [
            'exclude' => true,
            'label' => 'LLL:EXT:armpackage/Resources/Private/Language/locallang_db.xlf:tx_armpackage_domain_model_registration.rdate',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 13,
                'eval' => 'date',
                'default' => 0,
            ],
        ],
        'package' => [
            'exclude' => true,
            'label' => 'LLL:EXT:armpackage/Resources/Private/Language/locallang_db.xlf:tx_armpackage_domain_model_registration.package',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_armpackage_domain_model_package',
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],
    
    ],
];
