<?php
namespace Rkw\RkwFeecalculator\Tests\Unit\Domain\Model;

use Nimut\TestingFramework\TestCase\UnitTestCase;

/**
 * Test case.
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 */
class CalculatorTest extends UnitTestCase
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
    public function getNameReturnsInitialValueForName()
    {
        self::assertEquals(
            '',
            $this->subject->getName()
        );

    }

    /**
     * @test
     */
    public function setNameForStringSetsName()
    {
        $this->subject->setName('name');

        self::assertEquals(
            'name',
            $this->subject->getName()
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

    protected function tearDown()
    {
        parent::tearDown();
    }

}
