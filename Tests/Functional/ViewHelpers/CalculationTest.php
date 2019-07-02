<?php

namespace RKW\RkwFeecalculator\Tests\Functional\ViewHelpers;

use RKW\RkwFeecalculator\Domain\Model\Calculation;
use RKW\RkwFeecalculator\Domain\Model\Calculator;
use RKW\RkwFeecalculator\Tests\Functional\TestCase;
use RKW\RkwFeecalculator\ViewHelpers\CalculationViewHelper;

/**
 * Test case.
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 */
class CalculationTest extends TestCase
{
    /**
     * @var CalculationViewHelper
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

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new CalculationViewHelper();
        $this->calculation = new Calculation();
        $this->calculator = new Calculator();

        $objectStorageHoldingAssignedPrograms = $this->assignPrograms();

        $this->calculator->setAssignedPrograms($objectStorageHoldingAssignedPrograms);
        $this->calculation->setCalculator($this->calculator);
    }

    /**
     * @test
     */
    public function givenSelectedProgramItCalculatesSubventionOfConsultantFeeCorrectly()
    {
        $selectedProgramFixture = $this->getFirstAssignedProgram($this->calculator);
        $selectedProgramFixture->setConsultantFeePerDayLimit(800);

        $this->calculation->setSelectedProgram($selectedProgramFixture);

        $this->calculation->setDays(10);
        $this->calculation->setConsultantFeePerDay(1000);

        $result = $this->subject->calculate($this->calculation);

        self::assertEquals(
            8000,
            $result['consultantFeeSubvention']
        );
    }

    /**
     * @test
     */
    public function givenSelectedProgramItCalculatesSubventionOfRkwFeeCorrectly()
    {
        $selectedProgramFixture = $this->getFirstAssignedProgram($this->calculator);
        $selectedProgramFixture->setRkwFeePerDay(100);

        $this->calculation->setSelectedProgram($selectedProgramFixture);

        $this->calculation->setDays(10);
        $this->calculation->setConsultantFeePerDay(1000);

        $result = $this->subject->calculate($this->calculation);

        self::assertEquals(
            1000,
            $result['rkwFeeSubvention']
        );

    }

    /**
     * @test
     */
    public function givenSelectedProgramHasConsultantFeePerDayLimitOfNullItCalculatesSubventionOfConsultantFeeWithoutAnyLimit()
    {
        $selectedProgramFixture = $this->getFirstAssignedProgram($this->calculator);
        $selectedProgramFixture->setRkwFeePerDay(100);

        $this->calculation->setSelectedProgram($selectedProgramFixture);

        $this->calculation->setDays(10);
        $this->calculation->setConsultantFeePerDay(1000);

        $result = $this->subject->calculate($this->calculation);

        self::assertEquals(
            10000,
            $result['consultantFeeSubvention']
        );
    }

    /**
     * @test
     */
    public function givenSelectedProgramItCalculatesRkwFeeCorrectly()
    {
        $selectedProgramFixture = $this->getFirstAssignedProgram($this->calculator);
        $selectedProgramFixture->setRkwFeePerDay(100);
        $selectedProgramFixture->setConsultantFeePerDayLimit(800);

        $this->calculation->setSelectedProgram($selectedProgramFixture);

        $this->calculation->setDays(10);
        $this->calculation->setConsultantFeePerDay(1000);

        $result = $this->subject->calculate($this->calculation);

        self::assertEquals(
            1000,
            $result['rkwFee']
        );

    }

    /**
     * @test
     */
    public function givenSelectedProgramItCalculatesConsultantFeeCorrectly()
    {
        $selectedProgramFixture = $this->getFirstAssignedProgram($this->calculator);
        $selectedProgramFixture->setRkwFeePerDay(100);
        $selectedProgramFixture->setConsultantFeePerDayLimit(800);

        $this->calculation->setSelectedProgram($selectedProgramFixture);

        $this->calculation->setDays(10);
        $this->calculation->setConsultantFeePerDay(1000);

        $result = $this->subject->calculate($this->calculation);

        self::assertEquals(
            10000,
            $result['consultantFee']
        );

    }

    /**
     * @test
     */
    public function givenSelectedProgramItCalculatesSubtotalCorrectly()
    {
        $selectedProgramFixture = $this->getFirstAssignedProgram($this->calculator);
        $selectedProgramFixture->setRkwFeePerDay(100);
        $selectedProgramFixture->setConsultantFeePerDayLimit(800);

        $this->calculation->setSelectedProgram($selectedProgramFixture);

        $this->calculation->setDays(10);
        $this->calculation->setConsultantFeePerDay(1000);

        $result = $this->subject->calculate($this->calculation);

        self::assertEquals(
            11000,
            $result['subtotal']
        );

    }

    /**
     * @test
     */
    public function givenSelectedProgramWithDecimalConsultantFeePerDayLimitItCalculatesSubtotalCorrectly()
    {
        $selectedProgramFixture = $this->getFirstAssignedProgram($this->calculator);
        $selectedProgramFixture->setRkwFeePerDay(100);
        $selectedProgramFixture->setConsultantFeePerDayLimit(714.2857142857);

        $this->calculation->setSelectedProgram($selectedProgramFixture);

        $this->calculation->setDays(10);
        $this->calculation->setConsultantFeePerDay(1000);

        $result = $this->subject->calculate($this->calculation);

        $expect = $this->calculation->getDays() * $selectedProgramFixture->getConsultantFeePerDayLimit();

        self::assertEquals(
            $expect,
            $result['consultantFeeSubvention']
        );

    }

    /**
     * @test
     */
    public function givenSelectedProgramItCalculatesSubtotalPerDayCorrectly()
    {
        $selectedProgramFixture = $this->getFirstAssignedProgram($this->calculator);
        $selectedProgramFixture->setRkwFeePerDay(100);
        $selectedProgramFixture->setConsultantFeePerDayLimit(800);

        $this->calculation->setSelectedProgram($selectedProgramFixture);

        $this->calculation->setDays(10);
        $this->calculation->setConsultantFeePerDay(1000);

        $result = $this->subject->calculate($this->calculation);

        self::assertEquals(
            1100,
            $result['subtotalPerDay']
        );

    }

    /**
     * @test
     */
    public function givenSelectedProgramItCalculatesTaxCorrectly()
    {
        $selectedProgramFixture = $this->getFirstAssignedProgram($this->calculator);
        $selectedProgramFixture->setRkwFeePerDay(100);
        $selectedProgramFixture->setConsultantFeePerDayLimit(800);

        $this->calculation->setSelectedProgram($selectedProgramFixture);

        $this->calculation->setDays(10);
        $this->calculation->setConsultantFeePerDay(1000);

        $result = $this->subject->calculate($this->calculation);

        self::assertEquals(
            2090,
            $result['tax']
        );

    }

    /**
     * @test
     */
    public function givenSelectedProgramItCalculatesTotalCorrectly()
    {
        $selectedProgramFixture = $this->getFirstAssignedProgram($this->calculator);
        $selectedProgramFixture->setRkwFeePerDay(100);
        $selectedProgramFixture->setConsultantFeePerDayLimit(800);

        $this->calculation->setSelectedProgram($selectedProgramFixture);

        $this->calculation->setDays(10);
        $this->calculation->setConsultantFeePerDay(1000);

        $result = $this->subject->calculate($this->calculation);

        self::assertEquals(
            13090,
            $result['total']
        );

    }

    /**
     * @test
     */
    public function givenSelectedProgramItCalculatesSubventionTotalCorrectly()
    {
        $selectedProgramFixture = $this->getFirstAssignedProgram($this->calculator);
        $selectedProgramFixture->setRkwFeePerDay(100);
        $selectedProgramFixture->setConsultantFeePerDayLimit(800);

        $this->calculation->setSelectedProgram($selectedProgramFixture);

        $this->calculation->setDays(10);
        $this->calculation->setConsultantFeePerDay(1000);

        $result = $this->subject->calculate($this->calculation);

        self::assertEquals(
            9000,
            $result['subventionTotal']
        );

    }

    /**
     * @test
     */
    public function givenSelectedProgramItCalculatesSubtotalOfSubventionCorrectly()
    {
        $selectedProgramFixture = $this->getFirstAssignedProgram($this->calculator);
        $selectedProgramFixture->setRkwFeePerDay(100);
        $selectedProgramFixture->setConsultantFeePerDayLimit(800);

        $this->calculation->setSelectedProgram($selectedProgramFixture);

        $this->calculation->setDays(10);
        $this->calculation->setConsultantFeePerDay(1000);

        $result = $this->subject->calculate($this->calculation);

        self::assertEquals(
            9000,
            $result['subventionSubtotal']
        );

    }

    /**
     * @test
     */
    public function givenSelectedProgramItCalculatesFundingCorrectly()
    {
        $selectedProgramFixture = $this->getFirstAssignedProgram($this->calculator);
        $selectedProgramFixture->setRkwFeePerDay(100);
        $selectedProgramFixture->setConsultantFeePerDayLimit(800);
        $selectedProgramFixture->setFundingFactor(0.5);

        $this->calculation->setSelectedProgram($selectedProgramFixture);

        $this->calculation->setDays(10);
        $this->calculation->setConsultantFeePerDay(1000);

        $result = $this->subject->calculate($this->calculation);

        self::assertEquals(
            4500,
            $result['funding']
        );

    }

    /**
     * @test
     */
    public function givenSelectedProgramItCalculatesOwnFundingNetCorrectly()
    {
        $selectedProgramFixture = $this->getFirstAssignedProgram($this->calculator);
        $selectedProgramFixture->setRkwFeePerDay(100);
        $selectedProgramFixture->setConsultantFeePerDayLimit(800);
        $selectedProgramFixture->setFundingFactor(0.5);

        $this->calculation->setSelectedProgram($selectedProgramFixture);

        $this->calculation->setDays(10);
        $this->calculation->setConsultantFeePerDay(1000);

        $result = $this->subject->calculate($this->calculation);

        self::assertEquals(
            6500,
            $result['ownFundingNet']
        );

    }

    /**
     * @test
     */
    public function givenSelectedProgramItCalculatesOwnFundingGrossCorrectly()
    {
        $selectedProgramFixture = $this->getFirstAssignedProgram($this->calculator);
        $selectedProgramFixture->setRkwFeePerDay(100);
        $selectedProgramFixture->setConsultantFeePerDayLimit(800);
        $selectedProgramFixture->setFundingFactor(0.5);

        $this->calculation->setSelectedProgram($selectedProgramFixture);

        $this->calculation->setDays(10);
        $this->calculation->setConsultantFeePerDay(1000);

        $result = $this->subject->calculate($this->calculation);

        self::assertEquals(
            8590,
            $result['ownFundingGross']
        );
    }

    /**
     * @test
     */
    public function givenSelectedProgramItCalculatesFundingPercentageCorrectly()
    {
        $selectedProgramFixture = $this->getFirstAssignedProgram($this->calculator);
        $selectedProgramFixture->setRkwFeePerDay(100);
        $selectedProgramFixture->setConsultantFeePerDayLimit(800);
        $selectedProgramFixture->setFundingFactor(0.5);

        $this->calculation->setSelectedProgram($selectedProgramFixture);

        $this->calculation->setDays(10);
        $this->calculation->setConsultantFeePerDay(1000);

        $result = $this->subject->calculate($this->calculation);

        self::assertEquals(
            40.909090909090907,
            $result['fundingPercentage']
        );
    }

    /**
     * @test
     */
    public function givenSelectedProgramContainsConsultantSubventionLimitItCalculatesSubventionOfConsultantFeeCorrectly()
    {
        $selectedProgramFixture = $this->getFirstAssignedProgram($this->calculator);
        $selectedProgramFixture->setRkwFeePerDay(450);
        $selectedProgramFixture->setConsultantSubventionLimit(3550);

        $this->calculation->setSelectedProgram($selectedProgramFixture);

        $this->calculation->setDays(8);
        $this->calculation->setConsultantFeePerDay(1000);

        $result = $this->subject->calculate($this->calculation);

        self::assertSame(
            '3550',
            $result['consultantFeeSubvention']
        );
    }

    /**
     * @test
     */
    public function givenSelectedProgramContainsRkwFeePerDayAsLimitItCalculatesSubventionOfRkwFeeCorrectly()
    {
        $selectedProgramFixture = $this->getFirstAssignedProgram($this->calculator);
        $selectedProgramFixture->setRkwFeePerDay(450);
        $selectedProgramFixture->setConsultantSubventionLimit(3550);
        $selectedProgramFixture->setRkwFeePerDayAsLimit(true);

        $this->calculation->setSelectedProgram($selectedProgramFixture);

        $this->calculation->setDays(8);
        $this->calculation->setConsultantFeePerDay(1000);

        $result = $this->subject->calculate($this->calculation);

        self::assertEquals(
            450,
            $result['rkwFeeSubvention']
        );
    }

}
