<?php
namespace RKW\RkwFeecalculator\Tests\Functional\Domain\Model;

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

use RKW\RkwFeecalculator\Domain\Model\Calculation;
use RKW\RkwFeecalculator\Domain\Model\Calculator;
use RKW\RkwFeecalculator\Domain\Model\Program;
use RKW\RkwFeecalculator\Tests\Functional\TestCase;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class CalculationTest
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwFeecalculator
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @todo there are no scenarios defined. See coding guidelines!
 */
class CalculationTest extends TestCase
{
    /**
     * @var \RKW\RkwFeecalculator\Domain\Model\Calculation|null
     */
    protected ?Calculation $subject = null;


    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @var \RKW\RkwFeecalculator\Domain\Model\Calculation subject */
        $this->subject = GeneralUtility::makeInstance(Calculation::class);
    }

    #==========================================================================

    /**
     * @test
     */
    public function aSelectedProgramContainedInAssignedProgramsCanBeSelected()
    {

        /** @var \RKW\RkwFeecalculator\Domain\Model\Calculator $calculator */
        $calculator = GeneralUtility::makeInstance(Calculator::class);
        $objectStorageHoldingAssignedPrograms = $this->assignPrograms();

        $calculator->setAssignedPrograms($objectStorageHoldingAssignedPrograms);
        $this->subject->setCalculator($calculator);

        /** @var \RKW\RkwFeecalculator\Domain\Model\Program $selectedProgram */
        $selectedProgram = $this->getFirstAssignedProgram($calculator);

        $this->subject->setSelectedProgram($selectedProgram);

        self::assertTrue($this->subject->getCalculator()->getAssignedPrograms()->contains($this->subject->getSelectedProgram()));
        self::assertEquals($selectedProgram, $this->subject->getSelectedProgram());

    }


    /**
     * @test
     */
    public function aSelectedProgramNotContainedInAssignedProgramsMustNotBeSelected()
    {

        $objectStorageHoldingAssignedPrograms = $this->assignPrograms();

        /** @var \RKW\RkwFeecalculator\Domain\Model\Calculator $calculator */
        $calculator = GeneralUtility::makeInstance(Calculator::class);
        $calculator->setAssignedPrograms($objectStorageHoldingAssignedPrograms);

        $this->subject->setCalculator($calculator);

        /** @var \RKW\RkwFeecalculator\Domain\Model\Program $selectedProgram */
        $selectedProgram = GeneralUtility::makeInstance(Program::class);

        $this->subject->setSelectedProgram($selectedProgram);

        self::assertFalse($this->subject->getCalculator()->getAssignedPrograms()->contains($this->subject->getSelectedProgram()));
        self::assertNull($this->subject->getSelectedProgram());

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
