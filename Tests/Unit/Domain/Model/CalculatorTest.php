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

}
