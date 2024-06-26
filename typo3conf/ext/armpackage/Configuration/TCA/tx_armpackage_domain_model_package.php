<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:armpackage/Resources/Private/Language/locallang_db.xlf:tx_armpackage_domain_model_package',
        'label' => 'title',
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
        'searchFields' => 'title,subtitle,brief,mnth,dsprate,rate,rebate2,rebate3to10,rebatemt10,dacost',
        'iconfile' => 'EXT:armpackage/Resources/Public/Icons/tx_armpackage_domain_model_package.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, privatepkg, title, subtitle, brief, mnth, dsprate, rate, dacost, rebate2, rebate3to10, rebatemt10, additionalcost, note',
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, privatepkg, title, subtitle, brief, mnth, dsprate, rate, dacost, rebate2, rebate3to10, rebatemt10, additionalcost, note, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
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
                'foreign_table' => 'tx_armpackage_domain_model_package',
                'foreign_table_where' => 'AND tx_armpackage_domain_model_package.pid=###CURRENT_PID### AND tx_armpackage_domain_model_package.sys_language_uid IN (-1,0)',
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
        'privatepkg' => [
            'exclude' => true,
            'label' => 'LLL:EXT:armpackage/Resources/Private/Language/locallang_db.xlf:tx_armpackage_domain_model_package.privatepkg',
            'config' => [
                'type' => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:lang/Resources/Private/Language/locallang_core.xlf:labels.enabled'
                    ]
                ],
            ],
        ],
        'title' => [
            'exclude' => true,
            'label' => 'LLL:EXT:armpackage/Resources/Private/Language/locallang_db.xlf:tx_armpackage_domain_model_package.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'subtitle' => [
            'exclude' => true,
            'label' => 'LLL:EXT:armpackage/Resources/Private/Language/locallang_db.xlf:tx_armpackage_domain_model_package.subtitle',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'brief' => [
            'exclude' => true,
            'label' => 'LLL:EXT:armpackage/Resources/Private/Language/locallang_db.xlf:tx_armpackage_domain_model_package.brief',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
                'enableRichtext' => true,
                'richtextConfiguration' => 'default'
            ]
        ],
        'note' => [
            'exclude' => true,
            'label' => 'Foot note',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 5,
                'eval' => 'trim',
                'enableRichtext' => true,
                'richtextConfiguration' => 'default'
            ]
        ],
        'mnth' => [
            'exclude' => true,
            'label' => 'LLL:EXT:armpackage/Resources/Private/Language/locallang_db.xlf:tx_armpackage_domain_model_package.mnth',
            'config' => [
                'type' => 'input',
                'size' => 5,
                'eval' => 'int'
            ]
        ],
        'dsprate' => [
            'exclude' => true,
            'label' => 'LLL:EXT:armpackage/Resources/Private/Language/locallang_db.xlf:tx_armpackage_domain_model_package.dsprate',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'double2'
            ]
        ],
        'rate' => [
            'exclude' => true,
            'label' => 'LLL:EXT:armpackage/Resources/Private/Language/locallang_db.xlf:tx_armpackage_domain_model_package.rate',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'double2'
            ]
        ],
        'rebate2' => [
            'exclude' => true,
            'label' => 'LLL:EXT:armpackage/Resources/Private/Language/locallang_db.xlf:tx_armpackage_domain_model_package.rebate2',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'double2'
            ]
        ],
        'rebate3to10' => [
            'exclude' => true,
            'label' => 'LLL:EXT:armpackage/Resources/Private/Language/locallang_db.xlf:tx_armpackage_domain_model_package.rebate3to10',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'double2'
            ]
        ],
        'rebatemt10' => [
            'exclude' => true,
            'label' => 'LLL:EXT:armpackage/Resources/Private/Language/locallang_db.xlf:tx_armpackage_domain_model_package.rebatemt10',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'double2'
            ]
        ],
        'additionalcost' => [
            'exclude' => true,
            'label' => 'Additional Cost (Text display)',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'dacost' => [
            'exclude' => true,
            'label' => 'Additional Cost (Numberic for calculation)',
            'config' => [
                'type' => 'input',
                'size' => 10,
                'eval' => 'double2'
            ]
        ],
    ],
];
