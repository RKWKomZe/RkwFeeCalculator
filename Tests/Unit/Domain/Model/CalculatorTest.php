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
    public function getSelectedProgramReturnsInitialValueForInt()
    {
    }

    /**
     * @test
     */
    public function setSelectedProgramForIntSetsSelectedProgram()
    {
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
    public function getFeePerDayReturnsInitialValueForInt()
    {
    }

    /**
     * @test
     */
    public function setFeePerDayForIntSetsFeePerDay()
    {
    }

    /**
     * @test
     */
    public function getProgramsReturnsInitialValueForProgram()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getPrograms()
        );

    }

    /**
     * @test
     */
    public function setProgramsForObjectStorageContainingProgramSetsPrograms()
    {
        $program = new \Rkw\RkwFeecalculator\Domain\Model\Program();
        $objectStorageHoldingExactlyOnePrograms = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOnePrograms->attach($program);
        $this->subject->setPrograms($objectStorageHoldingExactlyOnePrograms);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOnePrograms,
            'programs',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function addProgramToObjectStorageHoldingPrograms()
    {
        $program = new \Rkw\RkwFeecalculator\Domain\Model\Program();
        $programsObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $programsObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($program));
        $this->inject($this->subject, 'programs', $programsObjectStorageMock);

        $this->subject->addProgram($program);
    }

    /**
     * @test
     */
    public function removeProgramFromObjectStorageHoldingPrograms()
    {
        $program = new \Rkw\RkwFeecalculator\Domain\Model\Program();
        $programsObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $programsObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($program));
        $this->inject($this->subject, 'programs', $programsObjectStorageMock);

        $this->subject->removeProgram($program);

    }
}
