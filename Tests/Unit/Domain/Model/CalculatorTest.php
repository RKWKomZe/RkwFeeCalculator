<?php
namespace Rkw\RkwFeecalculator\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 */
class CalculatorTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
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

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getDaysReturnsInitialValueForInt()
    {
    }

    /**
     * @test
     */
    public function setDaysForIntSetsDays()
    {
    }

    /**
     * @test
     */
    public function getConsultantFeePerDayReturnsInitialValueForInt()
    {
    }

    /**
     * @test
     */
    public function setConsultantFeePerDayForIntSetsConsultantFeePerDay()
    {
    }

    /**
     * @test
     */
    public function getAssignedProgramsReturnsInitialValueForProgram()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getAssignedPrograms()
        );

    }

    /**
     * @test
     */
    public function setAssignedProgramsForObjectStorageContainingProgramSetsAssignedPrograms()
    {
        $assignedProgram = new \Rkw\RkwFeecalculator\Domain\Model\Program();
        $objectStorageHoldingExactlyOneAssignedPrograms = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneAssignedPrograms->attach($assignedProgram);
        $this->subject->setAssignedPrograms($objectStorageHoldingExactlyOneAssignedPrograms);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneAssignedPrograms,
            'assignedPrograms',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function addAssignedProgramToObjectStorageHoldingAssignedPrograms()
    {
        $assignedProgram = new \Rkw\RkwFeecalculator\Domain\Model\Program();
        $assignedProgramsObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $assignedProgramsObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($assignedProgram));
        $this->inject($this->subject, 'assignedPrograms', $assignedProgramsObjectStorageMock);

        $this->subject->addAssignedProgram($assignedProgram);
    }

    /**
     * @test
     */
    public function removeAssignedProgramFromObjectStorageHoldingAssignedPrograms()
    {
        $assignedProgram = new \Rkw\RkwFeecalculator\Domain\Model\Program();
        $assignedProgramsObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $assignedProgramsObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($assignedProgram));
        $this->inject($this->subject, 'assignedPrograms', $assignedProgramsObjectStorageMock);

        $this->subject->removeAssignedProgram($assignedProgram);

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

}
