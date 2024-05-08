<?php
namespace ARM\Armpackage\Domain\Repository;

/***
 *
 * This file is part of the "Courses" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2019 Anisur Rahaman Mullick <anisur.mullick@gmail.com>, ARM Technologies
 *
 ***/

/**
 * The repository for Packages
 */
class PackageRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    /**
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function getNonPrivate() {
        
        $query = $this->createQuery();
        $constraints = array();
        $constraints[] = $query->equals('hidden',0);
        $constraints[] = $query->equals('privatepkg', 0);
        
        $query->matching(
                $query->logicalAnd($constraints)
        );

        return $query->execute();
    }
    
    /**
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function getPrivate() {
        
        $query = $this->createQuery();
        $constraints = array();
        $constraints[] = $query->equals('hidden',0);
        $constraints[] = $query->equals('privatepkg', 1);
        
        $query->matching(
                $query->logicalAnd($constraints)
        );

        return $query->execute();
    }
}
