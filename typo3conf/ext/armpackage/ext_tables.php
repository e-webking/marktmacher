<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'ARM.Armpackage',
            'List',
            'List'
        );
        
         \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'ARM.Armpackage',
            'Purchase',
            'My Purchases'
        );
        
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'ARM.Armpackage',
            'Registration',
            'Registration'
        );
         
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'ARM.Armpackage',
            'Company',
            'Company'
        );
        
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'ARM.Armpackage',
            'Login',
            'Student Login'
        );
        

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('armpackage', 'Configuration/TypoScript', 'Courses');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_armpackage_domain_model_package', 'EXT:armpackage/Resources/Private/Language/locallang_csh_tx_armpackage_domain_model_package.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_armpackage_domain_model_package');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_armpackage_domain_model_registration', 'EXT:armpackage/Resources/Private/Language/locallang_csh_tx_armpackage_domain_model_registration.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_armpackage_domain_model_registration');
        
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_armpackage_domain_model_branch', 'EXT:armpackage/Resources/Private/Language/locallang_csh_tx_armpackage_domain_model_branch.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_armpackage_domain_model_branch');

        
        if (TYPO3_MODE === 'BE') {

            /**
             * Registers a Backend Module
             */
            $mainModuleName = str_replace('_', '', 'armpackage') . 'M1';
            if (!isset($TBE_MODULES[$mainModuleName])) {
                $temp_TBE_MODULES = array();
                foreach($TBE_MODULES as $key => $val) {
                    if($key == 'web') {
                        $temp_TBE_MODULES[$key] = $val;
                        $temp_TBE_MODULES[$mainModuleName] = '';
                    } else {
                        $temp_TBE_MODULES[$key] = $val;
                    }
                }
                $TBE_MODULES = $temp_TBE_MODULES;
            }

            // Hauptmodul erstellen
            \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addModule($mainModuleName, '', '', \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('armpackage').'Configuration/BackendModule/');
            $GLOBALS['TBE_MODULES']['_configuration'][$mainModuleName] = [
                'labels' => [
                    'll_ref' => 'LLL:EXT:armpackage/Resources/Private/Language/locallang_mod_main.xlf'
                ],
                'name' => $mainModuleName,
                'iconIdentifier' => 'module-tools'
            ];
            \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
                    'ARM.Armpackage',
                    $mainModuleName,	 // Make module a submodule of 'web'
                    'list',	// Submodule key
                    '',     // Position
                    array(
                        'Package' => 'listall,search',
                    ),
                    array(
                        'access' => 'user,group',
                        'icon'   => 'EXT:armpackage/ext_icon.gif',
                        'labels' => 'LLL:EXT:armpackage/Resources/Private/Language/locallang_list.xlf',
                    )
            );
        }
    }
);
