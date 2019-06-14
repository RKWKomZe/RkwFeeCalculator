<?php
namespace RKW\RkwFeecalculator\Tests\Functional\ViewHelpers;

use Nimut\TestingFramework\TestCase\FunctionalTestCase;

/**
 * Test case.
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 */
class CalculationTest extends FunctionalTestCase
{
    /**
     * @var \RKW\RkwFeecalculator\ViewHelpers\CalculationViewHelper
     */
    protected $subject = null;

    /**
     * @var \RKW\RkwFeecalculator\Domain\Model\Calculation
     */
    protected $calculation = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \RKW\RkwFeecalculator\ViewHelpers\CalculationViewHelper();
        $this->calculation = new \RKW\RkwFeecalculator\Domain\Model\Calculation();
    }

    /**
     * @test
     */
    public function givenSelectedProgramItCalculatesSubventionOfConsultantFeeCorrectly()
    {
        $selectedProgramFixture = new \RKW\RkwFeecalculator\Domain\Model\Program();
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
        $selectedProgramFixture = new \RKW\RkwFeecalculator\Domain\Model\Program();
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
        $selectedProgramFixture = new \RKW\RkwFeecalculator\Domain\Model\Program();
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
        $selectedProgramFixture = new \RKW\RkwFeecalculator\Domain\Model\Program();
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
        $selectedProgramFixture = new \RKW\RkwFeecalculator\Domain\Model\Program();
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
        $selectedProgramFixture = new \RKW\RkwFeecalculator\Domain\Model\Program();
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
        $selectedProgramFixture = new \RKW\RkwFeecalculator\Domain\Model\Program();
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
        $selectedProgramFixture = new \RKW\RkwFeecalculator\Domain\Model\Program();
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
        $selectedProgramFixture = new \RKW\RkwFeecalculator\Domain\Model\Program();
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
        $selectedProgramFixture = new \RKW\RkwFeecalculator\Domain\Model\Program();
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
        $selectedProgramFixture = new \RKW\RkwFeecalculator\Domain\Model\Program();
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
        $selectedProgramFixture = new \RKW\RkwFeecalculator\Domain\Model\Program();
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
        $selectedProgramFixture = new \RKW\RkwFeecalculator\Domain\Model\Program();
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
        $selectedProgramFixture = new \RKW\RkwFeecalculator\Domain\Model\Program();
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
        $selectedProgramFixture = new \RKW\RkwFeecalculator\Domain\Model\Program();
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
        $selectedProgramFixture = new \RKW\RkwFeecalculator\Domain\Model\Program();
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

    protected function tearDown()
    {
        parent::tearDown();
    }

}
