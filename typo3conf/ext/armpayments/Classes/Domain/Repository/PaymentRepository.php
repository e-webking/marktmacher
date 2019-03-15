<?php
namespace ARM\Armpayments\Domain\Repository;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Anisur R. Mullick <anisur@armtechnologies.com>, ARM Technologies
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 *
 * @package TYPO3
 * @subpackage armpayments
 * @author Anisur R. Mullick <anisur@armtechnologies.com>
 * @version 1.1.0
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 *
 */
class PaymentRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {
	
    /**
     * Set the ordering
     *
     * @var array
     */
    protected $defaultOrderings = array('crdate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING);

    /**
     * Initializes the repository.
     *
     * @return void
     */
    public function initializeObject() {
        /** @var $querySettings \TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings */
        $querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
        $querySettings->setRespectStoragePage(FALSE);
        $this->setDefaultQuerySettings($querySettings);
    }

    /**
     * @param string $token
     * @return \ARM\Armpayments\Domain\Model\Payment
     */
    public function getByToken($token) {
        $query = $this->createQuery();
        $constraints = array();
        $constraints[] = $query->equals('hidden',0);
        $constraints[] = $query->equals('token', $token);
        $query->matching(
                $query->logicalAnd($constraints)
        );
        return $query->execute()->getFirst();
    }
	
}