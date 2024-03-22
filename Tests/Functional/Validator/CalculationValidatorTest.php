<?php
namespace RKW\RkwFeecalculator\Tests\Functional\Domain\Validator;

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

use Nimut\TestingFramework\TestCase\FunctionalTestCase;
use RKW\RkwFeecalculator\Domain\Model\Calculation;
use RKW\RkwFeecalculator\Domain\Model\Calculator;
use RKW\RkwFeecalculator\Validation\CalculationValidator;
use RKW\RkwFeecalculator\Tests\TestCaseUtility;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class CalculationValidatorTest
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwFeecalculator
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @todo there are no scenarios defined. See coding guidelines!
 */
class CalculationValidatorTest extends FunctionalTestCase
{

    /**
     * @var string[]
     */
    protected $testExtensionsToLoad = [
        'typo3conf/ext/rkw_basics',
    ];


    /**
     * @var \RKW\RkwFeecalculator\Validation\CalculationValidator|null
     */
    protected ?CalculationValidator $subject = null;


    /**
     * @var \RKW\RkwFeecalculator\Domain\Model\Calculation|null
     */
    protected ?Calculation $calculation = null;


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

        /** @var \RKW\RkwFeecalculator\Validation\CalculationValidator subject */
        $this->subject = GeneralUtility::makeInstance(CalculationValidator::class);

        /** @var \RKW\RkwFeecalculator\Domain\Model\Calculation calculation */
        $this->calculation = GeneralUtility::makeInstance(Calculation::class);
        $this->calculator = new Calculator();

        /** @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage $objectStorageHoldingAssignedPrograms */
        $objectStorageHoldingAssignedPrograms = TestCaseUtility::assignPrograms();

        $this->calculator->setAssignedPrograms($objectStorageHoldingAssignedPrograms);
        $this->calculation->setCalculator($this->calculator);

        /** @var \TYPO3\CMS\Core\Localization\LanguageService $languageService */
        $languageService = GeneralUtility::makeInstance(LanguageService::class);
        $GLOBALS['LANG'] = $languageService;

    }

    #==========================================================================

    /**
     * @test
     */
    public function givenSelectedProgramHasPossibleDaysMinLessDaysAreNotValid()
    {

        /** @var \RKW\RkwFeecalculator\Domain\Model\Program $selectedProgram */
        $selectedProgram = TestCaseUtility::getFirstAssignedProgram($this->calculator);
        $selectedProgram->setPossibleDaysMin(5);
        $selectedProgram->setPossibleDaysMax(10);

        $this->calculation->setSelectedProgram($selectedProgram);
        $this->calculation->setDays(2);

        $this->assertFalse($this->subject->isValid($this->calculation));
    }


    /**
     * @test
     */
    public function givenSelectedProgramHasPossibleDaysMinEqualDaysAreValid()
    {
        /** @var \RKW\RkwFeecalculator\Domain\Model\Program $selectedProgram */
        $selectedProgram = TestCaseUtility::getFirstAssignedProgram($this->calculator);

        $selectedProgram->setPossibleDaysMin(5);
        $selectedProgram->setPossibleDaysMax(10);

        $this->calculation->setSelectedProgram($selectedProgram);
        $this->calculation->setConsultantFeePerDay(1000);

        $this->calculation->setDays(5);

        $this->assertTrue($this->subject->isValid($this->calculation));
    }


    /**
     * @test
     */
    public function givenSelectedProgramHasPossibleDaysMinMoreDaysAreValid()
    {
        /** @var \RKW\RkwFeecalculator\Domain\Model\Program $selectedProgram */
        $selectedProgram = TestCaseUtility::getFirstAssignedProgram($this->calculator);

        $selectedProgram->setPossibleDaysMin(5);
        $selectedProgram->setPossibleDaysMax(10);

        $this->calculation->setSelectedProgram($selectedProgram);
        $this->calculation->setConsultantFeePerDay(1000);

        $this->calculation->setDays(10);

        $this->assertTrue($this->subject->isValid($this->calculation));
    }


    /**
     * @test
     */
    public function givenSelectedProgramHasPossibleDaysMaxMoreDaysAreNotValid()
    {
        /** @var \RKW\RkwFeecalculator\Domain\Model\Program $selectedProgram */
        $selectedProgram = TestCaseUtility::getFirstAssignedProgram($this->calculator);

        $selectedProgram->setPossibleDaysMin(5);
        $selectedProgram->setPossibleDaysMax(10);

        $this->calculation->setSelectedProgram($selectedProgram);
        $this->calculation->setConsultantFeePerDay(1000);

        $this->calculation->setDays(12);

        $this->assertFalse($this->subject->isValid($this->calculation));
    }


    /**
     * @test
     */
    public function givenSelectedProgramHasPossibleDaysMaxEqualDaysAreValid()
    {
        /** @var \RKW\RkwFeecalculator\Domain\Model\Program $selectedProgram */
        $selectedProgram = TestCaseUtility::getFirstAssignedProgram($this->calculator);

        $selectedProgram->setPossibleDaysMin(5);
        $selectedProgram->setPossibleDaysMax(10);

        $this->calculation->setSelectedProgram($selectedProgram);
        $this->calculation->setConsultantFeePerDay(1000);

        $this->calculation->setDays(10);

        $this->assertTrue($this->subject->isValid($this->calculation));
    }


    /**
     * @test
     */
    public function givenSelectedProgramHasPossibleDaysMaxLessDaysAreValid()
    {
        /** @var \RKW\RkwFeecalculator\Domain\Model\Program $selectedProgram */
        $selectedProgram = TestCaseUtility::getFirstAssignedProgram($this->calculator);

        $selectedProgram->setPossibleDaysMin(5);
        $selectedProgram->setPossibleDaysMax(10);

        $this->calculation->setSelectedProgram($selectedProgram);
        $this->calculation->setConsultantFeePerDay(1000);

        $this->calculation->setDays(5);

        $this->assertTrue($this->subject->isValid($this->calculation));
    }


    /**
     * @test
     */
    public function givenSelectedProgramHasPossibleDaysSetToZeroAnyDaysValueGreaterZeroIsValid()
    {
        /** @var \RKW\RkwFeecalculator\Domain\Model\Program $selectedProgram */
        $selectedProgram = TestCaseUtility::getFirstAssignedProgram($this->calculator);

        $selectedProgram->setPossibleDaysMin(0);
        $selectedProgram->setPossibleDaysMax(0);

        $this->calculation->setSelectedProgram($selectedProgram);
        $this->calculation->setConsultantFeePerDay(1000);

        $this->calculation->setDays(5);

        $this->assertTrue($this->subject->isValid($this->calculation));
    }


    /**
     * @test
     */
    public function givenSelectedProgramDaysIsRequired()
    {
        /** @var \RKW\RkwFeecalculator\Domain\Model\Program $selectedProgram */
        $selectedProgram = TestCaseUtility::getFirstAssignedProgram($this->calculator);

        $this->calculation->setSelectedProgram($selectedProgram);
        $this->calculation->setPreviousSelectedProgram($selectedProgram);

        $this->calculation->setConsultantFeePerDay(1000);

        $this->assertFalse($this->subject->isValid($this->calculation));
    }


    /**
     * @test
     */
    public function givenSelectedProgramConsultantFeePerDayIsRequired()
    {
        /** @var \RKW\RkwFeecalculator\Domain\Model\Program $selectedProgram */
        $selectedProgram = TestCaseUtility::getFirstAssignedProgram($this->calculator);

        $this->calculation->setSelectedProgram($selectedProgram);
        $this->calculation->setPreviousSelectedProgram($selectedProgram);

        $this->calculation->setDays(10);

        $this->assertFalse($this->subject->isValid($this->calculation));
    }


    /**
     * @test
     */
    public function submittingAMoneyValueWithLettersIsNotValid()
    {
        /** @var \RKW\RkwFeecalculator\Domain\Model\Program $selectedProgram */
        $selectedProgram = TestCaseUtility::getFirstAssignedProgram($this->calculator);

        $this->calculation->setSelectedProgram($selectedProgram);
        $this->calculation->setPreviousSelectedProgram($selectedProgram);

        $this->calculation->setDays(10);
        $this->calculation->setConsultantFeePerDay('A7236483,234');

        $this->assertFalse($this->subject->isValid($this->calculation));
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
