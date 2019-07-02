<?php

namespace RKW\RkwFeecalculator\Tests\Unit\Domain\Model;

use RKW\RkwFeecalculator\Domain\Model\Calculator;
use RKW\RkwFeecalculator\Domain\Model\Program;
use RKW\RkwFeecalculator\Tests\Unit\TestCase;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Test case.
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 */
class CalculatorTest extends TestCase
{
    /**
     * @var Calculator
     */
    protected $subject;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new Calculator();
    }

    /**
     * @test
     */
    public function getAssignedProgramsReturnsInitialValueForProgram()
    {
        $newObjectStorage = new ObjectStorage();
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
        $assignedProgram = new Program();
        $objectStorageHoldingExactlyOneAssignedPrograms = new ObjectStorage();
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
        $assignedProgram = new Program();
        $assignedProgramsObjectStorageMock = $this->getMockBuilder(ObjectStorage::class)
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
        $assignedProgram = new Program();
        $assignedProgramsObjectStorageMock = $this->getMockBuilder(ObjectStorage::class)
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

}
