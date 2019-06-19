<?php

namespace RKW\RkwFeecalculator\Tests\Functional\Domain\Model;

use RKW\RkwFeecalculator\Domain\Model\Calculation;
use RKW\RkwFeecalculator\Domain\Model\Calculator;
use RKW\RkwFeecalculator\Domain\Model\Program;
use RKW\RkwFeecalculator\Tests\Functional\TestCase;

/**
 * Test case.
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 */
class CalculationTest extends TestCase
{
    /**
     * @var Calculation
     */
    protected $subject;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new Calculation();
    }

    /**
     * @test
     */
    public function aSelectedProgramContainedInAssignedProgramsCanBeSelected()
    {

        $calculator = new Calculator();

        $objectStorageHoldingAssignedPrograms = $this->assignPrograms();

        $calculator->setAssignedPrograms($objectStorageHoldingAssignedPrograms);
        $this->subject->setCalculator($calculator);

        $selectedProgram = $this->getFirstAssignedProgram($calculator);

        $this->subject->setSelectedProgram($selectedProgram);

        self::assertTrue($this->subject->getCalculator()->getAssignedPrograms()->contains($this->subject->getSelectedProgram()));
        self::assertEquals($selectedProgram, $this->subject->getSelectedProgram());

    }

    /**
     * @test
     */
    public function aSelectedProgramNotContainedInAssignedProgramsMustNotBeSelected()
    {

        $objectStorageHoldingAssignedPrograms = $this->assignPrograms();

        $calculator = new Calculator();
        $calculator->setAssignedPrograms($objectStorageHoldingAssignedPrograms);

        $this->subject->setCalculator($calculator);

        $selectedProgram = new Program();

        $this->subject->setSelectedProgram($selectedProgram);

        self::assertFalse($this->subject->getCalculator()->getAssignedPrograms()->contains($this->subject->getSelectedProgram()));
        self::assertNull($this->subject->getSelectedProgram());

    }

}
