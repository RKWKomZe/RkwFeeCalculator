<?php
namespace RKW\RkwFeecalculator\Tests;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use Nimut\TestingFramework\TestCase\FunctionalTestCase;
use RKW\RkwFeecalculator\Domain\Model\Calculator;
use RKW\RkwFeecalculator\Domain\Model\Program;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Class TestCaseUtility
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwFeecalculator
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class TestCaseUtility  {



    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public static function assignPrograms(): ObjectStorage
    {
        /** @var \RKW\RkwFeecalculator\Domain\Model\Program $assignedProgram1 */
        $assignedProgram1 = GeneralUtility::makeInstance(Program::class);
        $assignedProgram1->setName('Program 1');

        /** @var \RKW\RkwFeecalculator\Domain\Model\Program $assignedProgram2 */
        $assignedProgram2 = GeneralUtility::makeInstance(Program::class);
        $assignedProgram2->setName('Program 2');

        /** @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage $objectStorageHoldingAssignedPrograms */
        $objectStorageHoldingAssignedPrograms = GeneralUtility::makeInstance(ObjectStorage::class);
        $objectStorageHoldingAssignedPrograms->attach($assignedProgram1);
        $objectStorageHoldingAssignedPrograms->attach($assignedProgram2);

        return $objectStorageHoldingAssignedPrograms;
    }


    /**
     * @param \RKW\RkwFeecalculator\Domain\Model\Calculator $calculator
     * @return \RKW\RkwFeecalculator\Domain\Model\Program
     */
    public static function getFirstAssignedProgram(Calculator $calculator):? Program
    {
        $selectedProgram = null;
        $counter = 0;

        foreach ($calculator->getAssignedPrograms() as $assignedProgram) {
            if ($counter === 0) {
                $selectedProgram = $assignedProgram;
            }
            $counter++;
        }

        return $selectedProgram;
    }

}
