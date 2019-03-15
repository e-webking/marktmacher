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

    }
);
