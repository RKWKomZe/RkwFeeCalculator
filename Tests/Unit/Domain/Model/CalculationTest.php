<?php

namespace RKW\RkwFeecalculator\Tests\Unit\Domain\Model;

use RKW\RkwFeecalculator\Domain\Model\Calculation;
use RKW\RkwFeecalculator\Domain\Model\Calculator;
use RKW\RkwFeecalculator\Domain\Model\Program;
use RKW\RkwFeecalculator\Tests\Unit\TestCase;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

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

    /**
     * @var Calculator
     */
    protected $calculator;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new Calculation();
        $this->calculator = new Calculator();

        $objectStorageHoldingAssignedPrograms = $this->assignPrograms();

        $this->calculator->setAssignedPrograms($objectStorageHoldingAssignedPrograms);
        $this->subject->setCalculator($this->calculator);
    }

    /**
     * @test
     */
    public function getDaysReturnsInitialValueForInt()
    {
        self::assertSame(
            0,
            $this->subject->getDays()
        );
    }

    /**
     * @test
     */
    public function setDaysForIntSetsDays()
    {
        $this->subject->setDays(10);

        self::assertAttributeEquals(
            10,
            'days',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getConsultantFeePerDayReturnsInitialValueForDouble()
    {
        self::assertSame(
            0.00,
            $this->subject->getConsultantFeePerDay()
        );
    }

    /**
     * @test
     */
    public function setConsultantFeePerDayForDoubleSetsConsultantFeePerDay()
    {
        $this->subject->setConsultantFeePerDay(1000.78);

        self::assertAttributeEquals(
            1000.78,
            'consultantFeePerDay',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getSelectedProgramReturnsInitialValueForProgram()
    {
        self::assertEquals(
            null,
            $this->subject->getSelectedProgram()
        );

    }

    /**
     * @test
     */
    public function setSelectedProgramForProgramSetsSelectedProgram()
    {
        $selectedProgramFixture = $this->getFirstAssignedProgram($this->calculator);
        $this->subject->setSelectedProgram($selectedProgramFixture);

        self::assertAttributeEquals(
            $selectedProgramFixture,
            'selectedProgram',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getFundingPercentageReturnsInitialValueForFundingPercentage()
    {
        self::assertEquals(
            null,
            $this->subject->getFundingPercentage()
        );

    }

    /**
     * @test
     */
    public function setFundingPercentageSetsFundingPercentage()
    {
        $fixture = 57;

        $this->subject->setFundingPercentage($fixture);

        self::assertEquals(
            $fixture,
            $this->subject->getFundingPercentage()
        );
    }

    /**
     * @test
     */
    public function givenCommaSeparatedConsultantFeePerDayGetterReturnsFloatValue()
    {
        $this->subject->setConsultantFeePerDay('100,78');

        self::assertEquals(
            100.78,
            $this->subject->getConsultantFeePerDay()
        );
    }

    /**
     * @test
     */
    public function givenCommaSeparatedConsultantFeePerDayWithThousandsSeparatorGetterReturnsFloatValue()
    {
        $this->subject->setConsultantFeePerDay('1.000,78');

        self::assertEquals(
            1000.78,
            $this->subject->getConsultantFeePerDay()
        );
    }

    /**
     * @test
     */
    public function givenPossibleDaysMinAndMaxPossibleDaysAreCalculated()
    {

        $calculator = new Calculator();

        $assignableProgram = new Program();
        $assignableProgram->setPossibleDaysMin(5);
        $assignableProgram->setPossibleDaysMax(10);

        $objectStorage = new ObjectStorage();
        $objectStorage->attach($assignableProgram);

        $calculator->setAssignedPrograms($objectStorage);

        $this->subject->setCalculator($calculator);
        $this->subject->setSelectedProgram($assignableProgram);

        $expectedPossibleDays = [
            '5'  => 5,
            '6'  => 6,
            '7'  => 7,
            '8'  => 8,
            '9'  => 9,
            '10' => 10,
        ];

        $result = $this->subject->getSelectedProgram()->getPossibleDays();

        self::assertEquals(
            $expectedPossibleDays,
            $result
        );

    }

    /**
     * @test
     */
    public function givenPossibleDaysMinAndMaxAreZeroPossibleDaysAreCalculated()
    {

        $calculator = new Calculator();

        $assignableProgram = new Program();
        $assignableProgram->setPossibleDaysMin(0);
        $assignableProgram->setPossibleDaysMax(0);

        $objectStorage = new ObjectStorage();
        $objectStorage->attach($assignableProgram);

        $calculator->setAssignedPrograms($objectStorage);

        $this->subject->setCalculator($calculator);
        $this->subject->setSelectedProgram($assignableProgram);

        $expectedPossibleDays = [];

        $result = $this->subject->getSelectedProgram()->getPossibleDays();

        self::assertEquals(
            $expectedPossibleDays,
            $result
        );

    }

    /**
     * @test
     */
    public function givenPossibleDaysMinAndMaxAreNotZeroButSamePossibleDaysAreCalculated()
    {

        $calculator = new Calculator();

        $assignableProgram = new Program();
        $assignableProgram->setPossibleDaysMin(5);
        $assignableProgram->setPossibleDaysMax(5);

        $objectStorage = new ObjectStorage();
        $objectStorage->attach($assignableProgram);

        $calculator->setAssignedPrograms($objectStorage);

        $this->subject->setCalculator($calculator);
        $this->subject->setSelectedProgram($assignableProgram);

        $expectedPossibleDays = [
            '5' => 5,
        ];

        $result = $this->subject->getSelectedProgram()->getPossibleDays();

        self::assertEquals(
            $expectedPossibleDays,
            $result
        );

    }

}
