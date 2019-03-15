<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'ARM.Armpackage',
            'List',
            [
                'Package' => 'list, register, confirm'
            ],
            // non-cacheable actions
            [
                'Package' => 'list, register, confirm'
            ]
        );
        
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'ARM.Armpackage',
            'Registration',
            [
                'Package' => 'branch, storebranch'
            ],
            // non-cacheable actions
            [
                'Package' => 'branch, storebranch'
            ]
        );
        
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'ARM.Armpackage',
            'Company',
            [
                'Package' => 'getCompany'
            ],
            // non-cacheable actions
            [
                'Package' => 'getCompany'
            ]
        );
        
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'ARM.Armpackage',
            'Login',
            [
                'Package' => 'login'
            ],
            // non-cacheable actions
            [
                'Package' => 'login'
            ]
        );

    // wizards
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        'mod {
            wizards.newContentElement.wizardItems.plugins {
                elements {
                    list {
                        iconIdentifier = armpackage-plugin-list
                        title = LLL:EXT:armpackage/Resources/Private/Language/locallang_db.xlf:tx_armpackage_list.name
                        description = LLL:EXT:armpackage/Resources/Private/Language/locallang_db.xlf:tx_armpackage_list.description
                        tt_content_defValues {
                            CType = list
                            list_type = armpackage_list
                        }
                    }
                }
                show = *
            }
       }'
    );
    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);

            $iconRegistry->registerIcon(
                    'armpackage-plugin-list',
                    \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
                    ['source' => 'EXT:armpackage/Resources/Public/Icons/ext_icon.gif']
            );
		
    }
);

$GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['armpackage'] = \ARM\Armpackage\Controller\PackageController::class . '::getCompanyAction';
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['armpayments']['tx_armpayments_pi1']['paymentProcess'][] = \ARM\Armpackage\Hook\ArmpaymentsHook::class;