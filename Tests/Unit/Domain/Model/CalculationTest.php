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

use RKW\RkwFeecalculator\Domain\Model\Calculation;
use RKW\RkwFeecalculator\Domain\Model\Calculator;
use RKW\RkwFeecalculator\Domain\Model\Program;
use RKW\RkwFeecalculator\Tests\Unit\TestCase;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

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
     * @var \RKW\RkwFeecalculator\Domain\Model\Calculator|null
     */
    protected ?Calculator $calculator = null;


    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @var \RKW\RkwFeecalculator\Domain\Model\Calculation subject */
        $this->subject = GeneralUtility::makeInstance(Calculation::class);

        /** @var  \RKW\RkwFeecalculator\Domain\Model\Calculator calculator */
        $this->calculator = GeneralUtility::makeInstance(Calculator::class);

        /** @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage $objectStorageHoldingAssignedPrograms */
        $objectStorageHoldingAssignedPrograms = $this->assignPrograms();

        $this->calculator->setAssignedPrograms($objectStorageHoldingAssignedPrograms);
        $this->subject->setCalculator($this->calculator);
    }

    #==========================================================================

    /**
     * @test
     */
    public function getDaysReturnsInitialValueForInt()
    {
        self::assertSame(0, $this->subject->getDays());
    }


    /**
     * @test
     */
    public function setDaysForIntSetsDays()
    {
        $this->subject->setDays(10);
        self::assertEquals(10, $this->subject->getDays());
    }

    #==========================================================================

    /**
     * @test
     */
    public function getConsultantFeePerDayReturnsInitialValueForDouble()
    {
        self::assertSame(0.00, $this->subject->getConsultantFeePerDay());
    }


    /**
     * @test
     */
    public function setConsultantFeePerDayForDoubleSetsConsultantFeePerDay()
    {
        $this->subject->setConsultantFeePerDay(1000.78);

        self::assertEquals(1000.78, $this->subject->getConsultantFeePerDay());
    }

    #==========================================================================

    /**
     * @test
     */
    public function getSelectedProgramReturnsInitialValueForProgram()
    {
        self::assertEquals(null, $this->subject->getSelectedProgram());

    }

    /**
     * @test
     */
    public function setSelectedProgramForProgramSetsSelectedProgram()
    {
        $selectedProgramFixture = $this->getFirstAssignedProgram($this->calculator);
        $this->subject->setSelectedProgram($selectedProgramFixture);

        self::assertEquals($selectedProgramFixture, $this->subject->getSelectedProgram());

    }

    #==========================================================================

    /**
     * @test
     */
    public function getFundingPercentageReturnsInitialValueForFundingPercentage()
    {
        self::assertEquals(null, $this->subject->getFundingPercentage());
    }


    /**
     * @test
     */
    public function setFundingPercentageSetsFundingPercentage()
    {
        $fixture = 57;
        $this->subject->setFundingPercentage($fixture);
        self::assertEquals($fixture,$this->subject->getFundingPercentage());
    }

    #==========================================================================

    /**
     * @test
     */
    public function givenCommaSeparatedConsultantFeePerDayGetterReturnsFloatValue()
    {
        $this->subject->setConsultantFeePerDay('100,78');
        self::assertEquals(100.78, $this->subject->getConsultantFeePerDay());
    }


    /**
     * @test
     */
    public function givenCommaSeparatedConsultantFeePerDayWithThousandsSeparatorGetterReturnsFloatValue()
    {
        $this->subject->setConsultantFeePerDay('1.000,78');
        self::assertEquals(1000.78,$this->subject->getConsultantFeePerDay());
    }

    #==========================================================================

    /**
     * @test
     */
    public function givenPossibleDaysMinAndMaxPossibleDaysAreCalculated()
    {

        /** @var \RKW\RkwFeecalculator\Domain\Model\Calculator $calculator */
        $calculator = GeneralUtility::makeInstance(Calculator::class);

        /** @var \RKW\RkwFeecalculator\Domain\Model\Program $assignableProgram */
        $assignableProgram = GeneralUtility::makeInstance(Program::class);
        $assignableProgram->setPossibleDaysMin(5);
        $assignableProgram->setPossibleDaysMax(10);

        /** @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage $objectStorage */
        $objectStorage = GeneralUtility::makeInstance(ObjectStorage::class);
        $objectStorage->attach($assignableProgram);

        $calculator->setAssignedPrograms($objectStorage);

        $this->subject->setCalculator($calculator);
        $this->subject->setSelectedProgram($assignableProgram);

        $expectedPossibleDays = [
            '5'  => 5,
            '6'  => 6,
            '7'  => 7,
            '8'  => 8,
            '9'  => 9,
            '10' => 10,
        ];

        $result = $this->subject->getSelectedProgram()->getPossibleDays();

        self::assertEquals($expectedPossibleDays, $result);

    }


    /**
     * @test
     */
    public function givenPossibleDaysMinAndMaxAreZeroPossibleDaysAreCalculated()
    {

        /** @var \RKW\RkwFeecalculator\Domain\Model\Calculator $calculator */
        $calculator = GeneralUtility::makeInstance(Calculator::class);

        /** @var \RKW\RkwFeecalculator\Domain\Model\Program $assignableProgram */
        $assignableProgram = GeneralUtility::makeInstance(Program::class);
        $assignableProgram->setPossibleDaysMin(0);
        $assignableProgram->setPossibleDaysMax(0);

        /** @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage $objectStorage */
        $objectStorage = GeneralUtility::makeInstance(ObjectStorage::class);
        $objectStorage->attach($assignableProgram);

        $calculator->setAssignedPrograms($objectStorage);

        $this->subject->setCalculator($calculator);
        $this->subject->setSelectedProgram($assignableProgram);

        $expectedPossibleDays = [];

        $result = $this->subject->getSelectedProgram()->getPossibleDays();

        self::assertEquals($expectedPossibleDays, $result);

    }


    /**
     * @test
     */
    public function givenPossibleDaysMinAndMaxAreNotZeroButSamePossibleDaysAreCalculated()
    {

        /** @var \RKW\RkwFeecalculator\Domain\Model\Calculator $calculator */
        $calculator = GeneralUtility::makeInstance(Calculator::class);

        /** @var \RKW\RkwFeecalculator\Domain\Model\Program $assignableProgram */
        $assignableProgram = GeneralUtility::makeInstance(Program::class);
        $assignableProgram->setPossibleDaysMin(5);
        $assignableProgram->setPossibleDaysMax(5);

        /** @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage $objectStorage */
        $objectStorage = GeneralUtility::makeInstance(ObjectStorage::class);
        $objectStorage->attach($assignableProgram);

        $calculator->setAssignedPrograms($objectStorage);

        $this->subject->setCalculator($calculator);
        $this->subject->setSelectedProgram($assignableProgram);

        $expectedPossibleDays = [
            '5' => 5,
        ];

        $result = $this->subject->getSelectedProgram()->getPossibleDays();

        self::assertEquals($expectedPossibleDays, $result);

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
