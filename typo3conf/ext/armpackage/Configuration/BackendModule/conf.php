<?php
/**
 * Dummy Konfiguration fürs Haupt Backend Modul
 */
define('TYPO3_MOD_PATH', '../typo3conf/ext/armpackage/Configuration/BackendModule/');
$MCONF['name'] = 'txarmpackageM1';
$MCONF['script'] = '_DISPATCH';

$MCONF['access'] = 'user,group';

$MLANG['default']['tabs_images']['tab'] = 'ext_icon.gif';
$MLANG['default']['ll_ref'] = 'LLL:EXT:armpackage/Resources/Private/Language/locallang_mod_main.xlf'; 