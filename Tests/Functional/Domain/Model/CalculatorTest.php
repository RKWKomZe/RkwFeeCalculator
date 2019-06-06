<?php
namespace Rkw\RkwFeecalculator\Tests\Functional\Domain\Model;

use Nimut\TestingFramework\TestCase\FunctionalTestCase;

/**
 * Test case.
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 */
class CalculatorTest extends FunctionalTestCase
{
    /**
     * @var \Rkw\RkwFeecalculator\Domain\Model\Calculator
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Rkw\RkwFeecalculator\Domain\Model\Calculator();
    }

    /**
     * @test
     */
    public function givenSelectedProgramItCalculatesSubventionOfConsultantFeeCorrectly()
    {
        $selectedProgramFixture = new \Rkw\RkwFeecalculator\Domain\Model\Program();
        $selectedProgramFixture->setConsultantFeePerDayLimit(800);

        $this->subject->setSelectedProgram($selectedProgramFixture);

        $this->subject->setDays(10);
        $this->subject->setConsultantFeePerDay(1000);

        $this->subject->calculate();

        self::assertAttributeEquals(
            8000,
            'consultantFeeSubvention',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function givenSelectedProgramItCalculatesSubventionOfRkwFeeCorrectly()
    {
        $selectedProgramFixture = new \Rkw\RkwFeecalculator\Domain\Model\Program();
        $selectedProgramFixture->setRkwFeePerDay(100);

        $this->subject->setSelectedProgram($selectedProgramFixture);

        $this->subject->setDays(10);
        $this->subject->setConsultantFeePerDay(1000);

        $this->subject->calculate();

        self::assertAttributeEquals(
            1000,
            'rkwFeeSubvention',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function givenSelectedProgramHasConsultantFeePerDayLimitOfNullItCalculatesSubventionOfConsultantFeeWithoutAnyLimit()
    {
        $selectedProgramFixture = new \Rkw\RkwFeecalculator\Domain\Model\Program();
        $selectedProgramFixture->setRkwFeePerDay(100);

        $this->subject->setSelectedProgram($selectedProgramFixture);

        $this->subject->setDays(10);
        $this->subject->setConsultantFeePerDay(1000);

        $this->subject->calculate();

        self::assertAttributeEquals(
            10000,
            'consultantFeeSubvention',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function givenSelectedProgramItCalculatesRkwFeeCorrectly()
    {
        $selectedProgramFixture = new \Rkw\RkwFeecalculator\Domain\Model\Program();
        $selectedProgramFixture->setRkwFeePerDay(100);
        $selectedProgramFixture->setConsultantFeePerDayLimit(800);

        $this->subject->setSelectedProgram($selectedProgramFixture);

        $this->subject->setDays(10);
        $this->subject->setConsultantFeePerDay(1000);

        $this->subject->calculate();

        self::assertAttributeEquals(
            1000,
            'rkwFee',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function givenSelectedProgramItCalculatesConsultantFeeCorrectly()
    {
        $selectedProgramFixture = new \Rkw\RkwFeecalculator\Domain\Model\Program();
        $selectedProgramFixture->setRkwFeePerDay(100);
        $selectedProgramFixture->setConsultantFeePerDayLimit(800);

        $this->subject->setSelectedProgram($selectedProgramFixture);

        $this->subject->setDays(10);
        $this->subject->setConsultantFeePerDay(1000);

        $this->subject->calculate();

        self::assertAttributeEquals(
            10000,
            'consultantFee',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function givenSelectedProgramItCalculatesSubtotalCorrectly()
    {
        $selectedProgramFixture = new \Rkw\RkwFeecalculator\Domain\Model\Program();
        $selectedProgramFixture->setRkwFeePerDay(100);
        $selectedProgramFixture->setConsultantFeePerDayLimit(800);

        $this->subject->setSelectedProgram($selectedProgramFixture);

        $this->subject->setDays(10);
        $this->subject->setConsultantFeePerDay(1000);

        $this->subject->calculate();

        self::assertAttributeEquals(
            11000,
            'subtotal',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function givenSelectedProgramWithDecimalConsultantFeePerDayLimitItCalculatesSubtotalCorrectly()
    {
        $selectedProgramFixture = new \Rkw\RkwFeecalculator\Domain\Model\Program();
        $selectedProgramFixture->setRkwFeePerDay(100);
        $selectedProgramFixture->setConsultantFeePerDayLimit(714.2857142857);

        $this->subject->setSelectedProgram($selectedProgramFixture);

        $this->subject->setDays(10);
        $this->subject->setConsultantFeePerDay(1000);

        $this->subject->calculate();

        $expect = $this->subject->getDays() * $selectedProgramFixture->getConsultantFeePerDayLimit();

        self::assertAttributeEquals(
            $expect,
            'consultantFeeSubvention',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function givenSelectedProgramItCalculatesSubtotalPerDayCorrectly()
    {
        $selectedProgramFixture = new \Rkw\RkwFeecalculator\Domain\Model\Program();
        $selectedProgramFixture->setRkwFeePerDay(100);
        $selectedProgramFixture->setConsultantFeePerDayLimit(800);

        $this->subject->setSelectedProgram($selectedProgramFixture);

        $this->subject->setDays(10);
        $this->subject->setConsultantFeePerDay(1000);

        $this->subject->calculate();

        self::assertAttributeEquals(
            1100,
            'subtotalPerDay',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function givenSelectedProgramItCalculatesTaxCorrectly()
    {
        $selectedProgramFixture = new \Rkw\RkwFeecalculator\Domain\Model\Program();
        $selectedProgramFixture->setRkwFeePerDay(100);
        $selectedProgramFixture->setConsultantFeePerDayLimit(800);

        $this->subject->setSelectedProgram($selectedProgramFixture);

        $this->subject->setDays(10);
        $this->subject->setConsultantFeePerDay(1000);

        $this->subject->calculate();

        self::assertAttributeEquals(
            2090,
            'tax',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function givenSelectedProgramItCalculatesTotalCorrectly()
    {
        $selectedProgramFixture = new \Rkw\RkwFeecalculator\Domain\Model\Program();
        $selectedProgramFixture->setRkwFeePerDay(100);
        $selectedProgramFixture->setConsultantFeePerDayLimit(800);

        $this->subject->setSelectedProgram($selectedProgramFixture);

        $this->subject->setDays(10);
        $this->subject->setConsultantFeePerDay(1000);

        $this->subject->calculate();

        self::assertAttributeEquals(
            13090,
            'total',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function givenSelectedProgramItCalculatesSubventionTotalCorrectly()
    {
        $selectedProgramFixture = new \Rkw\RkwFeecalculator\Domain\Model\Program();
        $selectedProgramFixture->setRkwFeePerDay(100);
        $selectedProgramFixture->setConsultantFeePerDayLimit(800);

        $this->subject->setSelectedProgram($selectedProgramFixture);

        $this->subject->setDays(10);
        $this->subject->setConsultantFeePerDay(1000);

        $this->subject->calculate();

        self::assertAttributeEquals(
            9000,
            'subventionTotal',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function givenSelectedProgramItCalculatesSubtotalOfSubventionCorrectly()
    {
        $selectedProgramFixture = new \Rkw\RkwFeecalculator\Domain\Model\Program();
        $selectedProgramFixture->setRkwFeePerDay(100);
        $selectedProgramFixture->setConsultantFeePerDayLimit(800);

        $this->subject->setSelectedProgram($selectedProgramFixture);

        $this->subject->setDays(10);
        $this->subject->setConsultantFeePerDay(1000);

        $this->subject->calculate();

        self::assertAttributeEquals(
            9000,
            'subventionSubtotal',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function givenSelectedProgramItCalculatesFundingCorrectly()
    {
        $selectedProgramFixture = new \Rkw\RkwFeecalculator\Domain\Model\Program();
        $selectedProgramFixture->setRkwFeePerDay(100);
        $selectedProgramFixture->setConsultantFeePerDayLimit(800);
        $selectedProgramFixture->setFundingFactor(0.5);

        $this->subject->setSelectedProgram($selectedProgramFixture);

        $this->subject->setDays(10);
        $this->subject->setConsultantFeePerDay(1000);

        $this->subject->calculate();

        self::assertAttributeEquals(
            4500,
            'funding',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function givenSelectedProgramItCalculatesOwnFundingNetCorrectly()
    {
        $selectedProgramFixture = new \Rkw\RkwFeecalculator\Domain\Model\Program();
        $selectedProgramFixture->setRkwFeePerDay(100);
        $selectedProgramFixture->setConsultantFeePerDayLimit(800);
        $selectedProgramFixture->setFundingFactor(0.5);

        $this->subject->setSelectedProgram($selectedProgramFixture);

        $this->subject->setDays(10);
        $this->subject->setConsultantFeePerDay(1000);

        $this->subject->calculate();

        self::assertAttributeEquals(
            6500,
            'ownFundingNet',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function givenSelectedProgramItCalculatesOwnFundingGrossCorrectly()
    {
        $selectedProgramFixture = new \Rkw\RkwFeecalculator\Domain\Model\Program();
        $selectedProgramFixture->setRkwFeePerDay(100);
        $selectedProgramFixture->setConsultantFeePerDayLimit(800);
        $selectedProgramFixture->setFundingFactor(0.5);

        $this->subject->setSelectedProgram($selectedProgramFixture);

        $this->subject->setDays(10);
        $this->subject->setConsultantFeePerDay(1000);

        $this->subject->calculate();

        self::assertAttributeEquals(
            8590,
            'ownFundingGross',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function givenSelectedProgramItCalculatesFundingPercentageCorrectly()
    {
        $selectedProgramFixture = new \Rkw\RkwFeecalculator\Domain\Model\Program();
        $selectedProgramFixture->setRkwFeePerDay(100);
        $selectedProgramFixture->setConsultantFeePerDayLimit(800);
        $selectedProgramFixture->setFundingFactor(0.5);

        $this->subject->setSelectedProgram($selectedProgramFixture);

        $this->subject->setDays(10);
        $this->subject->setConsultantFeePerDay(1000);

        $this->subject->calculate();

        self::assertAttributeEquals(
            40.909090909090907,
            'fundingPercentage',
            $this->subject
        );

    }

    /**
     * @todo
     */
    public function givenSelectedProgramHasPossibleDaysMinOnlyEqualOrMoreDaysCanBeSelected()
    {
        $selectedProgram = new \RKW\RkwFeecalculator\Domain\Model\Program();
        $selectedProgram->setPossibleDaysMin(5);

        $this->subject->setDays(2);

        $this->assertNotEquals(2, $this->subject->getDays());
        $this->assertEquals(5, $this->subject->getDays());
        $this->assertTrue($this->subject->getDays() >= 5);
    }

    /**
     * @todo
     */
    public function givenSelectedProgramHasPossibleDaysMaxOnlyEqualOrLessDaysCanBeSelected()
    {
        $selectedProgram = new \RKW\RkwFeecalculator\Domain\Model\Program();
        $selectedProgram->setPossibleDaysMax(20);

        $this->subject->setDays(22);

        $this->assertNotEquals(22, $this->subject->getDays());
        $this->assertEquals(20, $this->subject->getDays());
        $this->assertTrue($this->subject->getDays() <= 20);
    }


    /**
     * @test
     */
    public function aSelectedProgramContainedInAssignedProgramsCanBeSelected()
    {

        $assignedProgram1 = new \Rkw\RkwFeecalculator\Domain\Model\Program();
        $assignedProgram1->setName('Program 1');
        $assignedProgram2 = new \Rkw\RkwFeecalculator\Domain\Model\Program();
        $assignedProgram2->setName('Program 2');

        $objectStorageHoldingAssignedPrograms = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingAssignedPrograms->attach($assignedProgram1);
        $objectStorageHoldingAssignedPrograms->attach($assignedProgram2);

        $this->subject->setAssignedPrograms($objectStorageHoldingAssignedPrograms);

        $selectedProgram = $assignedProgram1;

        //  @todo: Muss hier eine Validierung das Setzen eines Programms außerhalb der AssignedPrograms verhindern?!!

        $this->subject->setSelectedProgram($selectedProgram);

        self::assertTrue($this->subject->getAssignedPrograms()->contains($this->subject->getSelectedProgram()));
        self::assertEquals($selectedProgram, $this->subject->getSelectedProgram());

    }

    /**
     * @todo
     */
    public function aSelectedProgramNotContainedInAssignedProgramsMustNotBeSelected()
    {

        $assignedProgram1 = new \Rkw\RkwFeecalculator\Domain\Model\Program();
        $assignedProgram1->setName('Program 1');
        $assignedProgram2 = new \Rkw\RkwFeecalculator\Domain\Model\Program();
        $assignedProgram2->setName('Program 2');

        $objectStorageHoldingAssignedPrograms = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingAssignedPrograms->attach($assignedProgram1);
        $objectStorageHoldingAssignedPrograms->attach($assignedProgram2);

        $this->subject->setAssignedPrograms($objectStorageHoldingAssignedPrograms);

        $selectedProgram = new \Rkw\RkwFeecalculator\Domain\Model\Program();

        //  @todo: Muss hier eine Validierung das Setzen eines Programms außerhalb der AssignedPrograms verhindern?!!

        $this->subject->setSelectedProgram($selectedProgram);

        self::assertFalse($this->subject->getAssignedPrograms()->contains($this->subject->getSelectedProgram()));
        self::assertNull($this->subject->getSelectedProgram());

    }

    protected function tearDown()
    {
        parent::tearDown();
    }

}
