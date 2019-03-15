<?php
//ARM\Armpayments\Libraries\Stripe
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Autoloader {
    static public function loader($className) {
        $filename = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('armpayments')."Classes/Libraries/Stripe/lib/" . str_replace('\\', '/', $className) . ".php";
        if (file_exists($filename)) {

            include($filename);
            if (class_exists($className)) {
                return TRUE;
            }
        }
        return FALSE;
    }
}

spl_autoload_register('Autoloader::loader');