<?php

namespace RKW\RkwFeecalculator\Tests\Unit;

use Nimut\TestingFramework\TestCase\UnitTestCase;
use RKW\RkwFeecalculator\Domain\Model\Calculator;
use RKW\RkwFeecalculator\Domain\Model\Program;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Test case.
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 */
class TestCase extends UnitTestCase {

    /**
     * @return ObjectStorage
     */
    public function assignPrograms()
    {
        $assignedProgram1 = new Program();
        $assignedProgram1->setName('Program 1');
        $assignedProgram2 = new Program();
        $assignedProgram2->setName('Program 2');

        $objectStorageHoldingAssignedPrograms = new ObjectStorage();
        $objectStorageHoldingAssignedPrograms->attach($assignedProgram1);
        $objectStorageHoldingAssignedPrograms->attach($assignedProgram2);

        return $objectStorageHoldingAssignedPrograms;
    }

    /**-
     * @param Calculator $calculator
     * @return object
     */
    public function getFirstAssignedProgram(Calculator $calculator)
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