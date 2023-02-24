<?php
namespace RKW\RkwFeecalculator\Tests\Unit\Domain\Model;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use RKW\RkwFeecalculator\Domain\Model\Calculator;
use RKW\RkwFeecalculator\Domain\Model\Program;
use RKW\RkwFeecalculator\Tests\Unit\TestCase;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Class CalculatorTest
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwFeecalculator
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @todo there are no scenarios defined. See coding guidelines!
 */
class CalculatorTest extends TestCase
{
    /**
     * @var \RKW\RkwFeecalculator\Domain\Model\Calculator|null
     */
    protected ?Calculator $subject = null;


    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @var \RKW\RkwFeecalculator\Domain\Model\Calculator $calculator */
        $this->subject = GeneralUtility::makeInstance(Calculator::class);
    }

    #==========================================================================

    /**
     * @test
     */
    public function getAssignedProgramsReturnsInitialValueForProgram()
    {
        /** @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage $objectStorage */
        $objectStorage = GeneralUtility::makeInstance(ObjectStorage::class);

        self::assertEquals($objectStorage, $this->subject->getAssignedPrograms());

    }


    /**
     * @test
     */
    public function setAssignedProgramsForObjectStorageContainingProgramSetsAssignedPrograms()
    {
        /** @var \RKW\RkwFeecalculator\Domain\Model\Program $assignedProgram */
        $assignedProgram = GeneralUtility::makeInstance(Program::class);

        /** @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage $objectStorageHoldingExactlyOneAssignedPrograms */
        $objectStorageHoldingExactlyOneAssignedPrograms = GeneralUtility::makeInstance(ObjectStorage::class);
        $objectStorageHoldingExactlyOneAssignedPrograms->attach($assignedProgram);
        $this->subject->setAssignedPrograms($objectStorageHoldingExactlyOneAssignedPrograms);

        self::assertEquals($objectStorageHoldingExactlyOneAssignedPrograms, $this->subject->getAssignedPrograms());

    }


    /**
     * @test
     */
    public function addAssignedProgramToObjectStorageHoldingAssignedPrograms()
    {

        /** @var \RKW\RkwFeecalculator\Domain\Model\Program $assignedProgram */
        $assignedProgram = GeneralUtility::makeInstance(Program::class);

        /** @var \PHPUnit\Framework\MockObject\MockObject $assignedProgramsObjectStorageMock */
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
        /** @var \RKW\RkwFeecalculator\Domain\Model\Program $assignedProgram */
        $assignedProgram = GeneralUtility::makeInstance(Program::class);

        /** @var \PHPUnit\Framework\MockObject\MockObject $assignedProgramsObjectStorageMock */
        $assignedProgramsObjectStorageMock = $this->getMockBuilder(ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $assignedProgramsObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($assignedProgram));
        $this->inject($this->subject, 'assignedPrograms', $assignedProgramsObjectStorageMock);

        $this->subject->removeAssignedProgram($assignedProgram);

    }

    #==========================================================================

    /**
     * @test
     */
    public function getNameReturnsInitialValueForName()
    {
        self::assertEquals('', $this->subject->getName());
    }


    /**
     * @test
     */
    public function setNameForStringSetsName()
    {
        $this->subject->setName('name');

        self::assertEquals('name', $this->subject->getName());
    }

    #==========================================================================

    /**
     * @return void
     */
    protected function tearDown(): void
    {
        parent::tearDown();
    }

}
