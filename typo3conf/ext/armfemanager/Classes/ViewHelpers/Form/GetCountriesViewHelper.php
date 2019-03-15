<?php
declare(strict_types=1);
namespace In2code\Armfemanager\ViewHelpers\Form;

use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Class GetCountriesViewHelper
 */
class GetCountriesViewHelper extends AbstractViewHelper
{

    /**
     * @var array
     */
    protected $countries = [
        'CHF' => 'Schweiz',
        'DEU' => 'Deutschland',
        'AUT' => 'Österreich',
    ];

    /**
     * Build an country array
     *
     * @return array
     */
    public function render()
    {
        return $this->countries;
    }
}
