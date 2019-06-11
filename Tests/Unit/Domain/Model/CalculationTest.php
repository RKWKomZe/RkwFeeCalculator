<?php
namespace Rkw\RkwFeecalculator\Tests\Unit\Domain\Model;

use Nimut\TestingFramework\TestCase\UnitTestCase;

/**
 * Test case.
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 */
class CalculationTest extends UnitTestCase
{
    /**
     * @var \Rkw\RkwFeecalculator\Domain\Model\Calculation
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Rkw\RkwFeecalculator\Domain\Model\Calculation();
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
        $selectedProgramFixture = new \Rkw\RkwFeecalculator\Domain\Model\Program();
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

    protected function tearDown()
    {
        parent::tearDown();
    }

}
