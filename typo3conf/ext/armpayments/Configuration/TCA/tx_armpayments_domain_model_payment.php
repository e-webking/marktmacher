<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$GLOBALS['TCA']['tx_armpayments_domain_model_payment'] = array(
	'ctrl' => array(
            'title'	=> 'LLL:EXT:armpayments/Resources/Private/Language/locallang_db.xml:tx_armpayments_domain_model_payment',
            'label' => 'amount',
            'label_alt' => 'crdate,gateway',
            'label_alt_force' => TRUE,
            'tstamp' => 'tstamp',
            'crdate' => 'crdate',
            'cruser_id' => 'cruser_id',
            'dividers2tabs' => TRUE,
            'versioningWS' => FALSE,
            'languageField' => 'sys_language_uid',
            'transOrigPointerField' => 'l10n_parent',
            'transOrigDiffSourceField' => 'l10n_diffsource',
            'delete' => 'deleted',
            'default_sortby' => 'uid DESC',
            'enablecolumns' => array(
                    'disabled' => 'hidden',
                    'crdate' => 'crdate',
                    'starttime' => 'starttime',
                    'endtime' => 'endtime',
            ),
            'iconfile' => 'EXT:armpayments/Resources/Public/Icons/arm_payment.png',
        ),
        'interface' => array(
            'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, crdate, gateway, transactionid, amount, subtotal, tax, currency, orderid, tablename, token, payer, status',
        ),
        'types' => array(
            '1' => array('showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, crdate, orderid, tablename, gateway, transactionid, amount, subtotal, tax, currency, token, payer, status,--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,starttime, endtime'),
        ),
        'palettes' => array(
            '1' => array('showitem' => ''),
        ),
	'columns' => array(
        'sys_language_uid' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xml:LGL.language',
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'sys_language',
                'foreign_table_where' => 'ORDER BY sys_language.title',
                'items' => array(
                    array('LLL:EXT:lang/Resources/Private/Language/locallang_general.xml:LGL.allLanguages', -1),
                    array('LLL:EXT:lang/Resources/Private/Language/locallang_general.xml:LGL.default_value', 0)
                ),
            ),
        ),
        'l10n_parent' => array(
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xml:LGL.l18n_parent',
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => array(
                     array('', 0),
                ),
                'foreign_table' => 'tx_armpayments_domain_model_payment',
                'foreign_table_where' => 'AND tx_armpayments_domain_model_payment.pid=###CURRENT_PID### AND tx_armpayments_domain_model_payment.sys_language_uid IN (-1,0)',
            ),
        ),
        'l10n_diffsource' => array(
            'config' => array(
                'type' => 'passthrough',
            ),
        ),
        'hidden' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xml:LGL.hidden',
            'config' => array(
                'type' => 'check',
            ),
        ),
        'crdate' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xml:LGL.crdate',
            'config' => array(
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 13,
                'eval' => 'datetime',
                'readOnly' => TRUE,
            ),
        ),
        'starttime' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xml:LGL.starttime',
            'config' => array(
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 13,
                'eval' => 'datetime',
                'checkbox' => 0,
                'default' => 0,
                'range' => array(
                    'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
                ),
            ),
        ),
        'endtime' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xml:LGL.endtime',
            'config' => array(
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 13,
                'eval' => 'datetime',
                'checkbox' => 0,
                'default' => 0,
                'range' => array(
                    'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
                ),
            ),
        ),
        'gateway' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:armpayments/Resources/Private/Language/locallang_db.xml:tx_armpayments_domain_model_payment.gateway',
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => array(
                        array('Stripe', 'Stripe')
                ),
                'readOnly' => TRUE,
            ),

        ),
        'amount' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:armpayments/Resources/Private/Language/locallang_db.xml:tx_armpayments_domain_model_payment.amount',
            'config' => array(
                'type' => 'input',
                'size' => 20,
                'eval' => 'double2,required',
                'readOnly' => TRUE,
            ),
        ),
        'subtotal' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:armpayments/Resources/Private/Language/locallang_db.xml:tx_armpayments_domain_model_payment.subtotal',
            'config' => array(
                'type' => 'input',
                'size' => 20,
                'eval' => 'double2',
                'readOnly' => TRUE,
            ),
        ),
        'tax' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:armpayments/Resources/Private/Language/locallang_db.xml:tx_armpayments_domain_model_payment.tax',
            'config' => array(
                'type' => 'input',
                'size' => 20,
                'eval' => 'double2',
                'readOnly' => TRUE,
            ),
        ),
        'orderid' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:armpayments/Resources/Private/Language/locallang_db.xml:tx_armpayments_domain_model_payment.orderid',
            'config' => array(
                'type' => 'input',
                'size' => 20,
                'eval' => 'int',
                'readOnly' => TRUE,
            ),
        ),
        'currency' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:armpayments/Resources/Private/Language/locallang_db.xml:tx_armpayments_domain_model_payment.currency',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'readOnly' => TRUE,
            ),
        ),
        'tablename' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:armpayments/Resources/Private/Language/locallang_db.xml:tx_armpayments_domain_model_payment.tablename',
            'config' => array(
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim',
                'readOnly' => TRUE,
            ),
        ),
        'token' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:armpayments/Resources/Private/Language/locallang_db.xml:tx_armpayments_domain_model_payment.token',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'readOnly' => TRUE,
            ),
        ),
        'transactionid' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:armpayments/Resources/Private/Language/locallang_db.xml:tx_armpayments_domain_model_payment.transactionid',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'readOnly' => TRUE,
            ),
        ),
        'payer' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:armpayments/Resources/Private/Language/locallang_db.xml:tx_armpayments_domain_model_payment.payer',
            'config' => array(
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim',
                'readOnly' => TRUE,
            ),
        ),
        'status' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:armpayments/Resources/Private/Language/locallang_db.xml:tx_armpayments_domain_model_payment.status',
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => array(
                    array('Error', -1),
                    array('Pending', 0),
                    array('Successful', 1)
                ),
                'readOnly' => TRUE,
            ),
        ),
    ),
);
