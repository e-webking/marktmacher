<?php
namespace ARM\Armpackage\ViewHelpers;

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * 
 */
class DiscountViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {
    
    /**
     * @param float $discount
     * @param float $rate
     * @return float
     */
    public function render($discount, $rate) {
        
        if ($discount > 0) {
           return $discount/100 * $rate;
        }
    }
}
