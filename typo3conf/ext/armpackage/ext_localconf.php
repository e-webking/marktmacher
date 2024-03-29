<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'ARM.Armpackage',
            'List',
            [
                'Package' => 'list, register, confirm, getPrice'
            ],
            // non-cacheable actions
            [
                'Package' => 'list, register, confirm, getPrice'
            ]
        );
        
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'ARM.Armpackage',
            'Mlist',
            [
                'Package' => 'mlist, register, confirm, getPrice'
            ],
            // non-cacheable actions
            [
                'Package' => 'mlist, register, confirm, getPrice'
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
        
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'ARM.Armpackage',
            'Purchase',
            [
                'Package' => 'mypurchase'
            ],
            // non-cacheable actions
            [
                'Package' => 'mypurchase'
            ]
        );
        
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'ARM.Armpackage',
            'Plist',
            [
                'Package' => 'listPrivate, register, confirm, getPrice'
            ],
            // non-cacheable actions
            [
                'Package' => 'listPrivate, register, confirm, getPrice'
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
$GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['armpackageprice'] = \ARM\Armpackage\Controller\PackageController::class . '::getPriceAction';
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['armpayments']['tx_armpayments_pi1']['paymentProcess'][] = \ARM\Armpackage\Hook\ArmpaymentsHook::class;
//$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['felogin']['beforeRedirect'][] = \ARM\Armpackage\Hook\FeloginHook::class .'::checkUser';