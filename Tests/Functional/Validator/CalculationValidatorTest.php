<?php

namespace RKW\RkwFeecalculator\Tests\Functional\Domain\Validator;

use RKW\RkwFeecalculator\Domain\Model\Calculation;
use RKW\RkwFeecalculator\Domain\Model\Calculator;
use RKW\RkwFeecalculator\Tests\Functional\TestCase;
use RKW\RkwFeecalculator\Validation\CalculationValidator;

/**
 * Test case.
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 */
class CalculationValidatorTest extends TestCase
{

    /**
     * @var string[]
     */
    protected $testExtensionsToLoad = [
        'typo3conf/ext/rkw_basics',
    ];

    /**
     * @var CalculationValidator
     */
    protected $subject;

    /**
     * @var Calculation
     */
    protected $calculation;

    /**
     * @var Calculator
     */
    protected $calculator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = new CalculationValidator();
        $this->calculation = new Calculation();
        $this->calculator = new Calculator();

        $objectStorageHoldingAssignedPrograms = $this->assignPrograms();

        $this->calculator->setAssignedPrograms($objectStorageHoldingAssignedPrograms);
        $this->calculation->setCalculator($this->calculator);

    }

    /**
     * @test
     */
    public function givenSelectedProgramHasPossibleDaysMinLessDaysAreNotValid()
    {

        $selectedProgram = $this->getFirstAssignedProgram($this->calculator);
        $selectedProgram->setPossibleDaysMin(5);
        $selectedProgram->setPossibleDaysMax(10);

        $this->calculation->setSelectedProgram($selectedProgram);
        $this->calculation->setDays(2);

        $this->assertFalse($this->subject->isValid($this->calculation));
    }

    /**
     * @test
     */
    public function givenSelectedProgramHasPossibleDaysMinEqualDaysAreValid()
    {
        $selectedProgram = $this->getFirstAssignedProgram($this->calculator);

        $selectedProgram->setPossibleDaysMin(5);
        $selectedProgram->setPossibleDaysMax(10);

        $this->calculation->setSelectedProgram($selectedProgram);
        $this->calculation->setConsultantFeePerDay(1000);

        $this->calculation->setDays(5);

        $this->assertTrue($this->subject->isValid($this->calculation));
    }

    /**
     * @test
     */
    public function givenSelectedProgramHasPossibleDaysMinMoreDaysAreValid()
    {
        $selectedProgram = $this->getFirstAssignedProgram($this->calculator);

        $selectedProgram->setPossibleDaysMin(5);
        $selectedProgram->setPossibleDaysMax(10);

        $this->calculation->setSelectedProgram($selectedProgram);
        $this->calculation->setConsultantFeePerDay(1000);

        $this->calculation->setDays(10);

        $this->assertTrue($this->subject->isValid($this->calculation));
    }

    /**
     * @test
     */
    public function givenSelectedProgramHasPossibleDaysMaxMoreDaysAreNotValid()
    {
        $selectedProgram = $this->getFirstAssignedProgram($this->calculator);

        $selectedProgram->setPossibleDaysMin(5);
        $selectedProgram->setPossibleDaysMax(10);

        $this->calculation->setSelectedProgram($selectedProgram);
        $this->calculation->setConsultantFeePerDay(1000);

        $this->calculation->setDays(12);

        $this->assertFalse($this->subject->isValid($this->calculation));
    }

    /**
     * @test
     */
    public function givenSelectedProgramHasPossibleDaysMaxEqualDaysAreValid()
    {
        $selectedProgram = $this->getFirstAssignedProgram($this->calculator);

        $selectedProgram->setPossibleDaysMin(5);
        $selectedProgram->setPossibleDaysMax(10);

        $this->calculation->setSelectedProgram($selectedProgram);
        $this->calculation->setConsultantFeePerDay(1000);

        $this->calculation->setDays(10);

        $this->assertTrue($this->subject->isValid($this->calculation));
    }

    /**
     * @test
     */
    public function givenSelectedProgramHasPossibleDaysMaxLessDaysAreValid()
    {
        $selectedProgram = $this->getFirstAssignedProgram($this->calculator);

        $selectedProgram->setPossibleDaysMin(5);
        $selectedProgram->setPossibleDaysMax(10);

        $this->calculation->setSelectedProgram($selectedProgram);
        $this->calculation->setConsultantFeePerDay(1000);

        $this->calculation->setDays(5);

        $this->assertTrue($this->subject->isValid($this->calculation));
    }

    /**
     * @test
     */
    public function givenSelectedProgramHasPossibleDaysSetToZeroAnyDaysValueGreaterZeroIsValid()
    {
        $selectedProgram = $this->getFirstAssignedProgram($this->calculator);

        $selectedProgram->setPossibleDaysMin(0);
        $selectedProgram->setPossibleDaysMax(0);

        $this->calculation->setSelectedProgram($selectedProgram);
        $this->calculation->setConsultantFeePerDay(1000);

        $this->calculation->setDays(5);

        $this->assertTrue($this->subject->isValid($this->calculation));
    }

    /**
     * @test
     */
    public function givenSelectedProgramDaysIsRequired()
    {
        $selectedProgram = $this->getFirstAssignedProgram($this->calculator);

        $this->calculation->setSelectedProgram($selectedProgram);
        $this->calculation->setPreviousSelectedProgram($selectedProgram);

        $this->calculation->setConsultantFeePerDay(1000);

        $this->assertFalse($this->subject->isValid($this->calculation));
    }

    /**
     * @test
     */
    public function givenSelectedProgramConsultantFeePerDayIsRequired()
    {
        $selectedProgram = $this->getFirstAssignedProgram($this->calculator);

        $this->calculation->setSelectedProgram($selectedProgram);
        $this->calculation->setPreviousSelectedProgram($selectedProgram);

        $this->calculation->setDays(10);

        $this->assertFalse($this->subject->isValid($this->calculation));
    }

    /**
     * @test
     */
    public function submittingAMoneyValueWithLettersIsNotValid()
    {
        $selectedProgram = $this->getFirstAssignedProgram($this->calculator);

        $this->calculation->setSelectedProgram($selectedProgram);
        $this->calculation->setPreviousSelectedProgram($selectedProgram);

        $this->calculation->setDays(10);
        $this->calculation->setConsultantFeePerDay('A7236483,234');

        $this->assertFalse($this->subject->isValid($this->calculation));
    }

}
