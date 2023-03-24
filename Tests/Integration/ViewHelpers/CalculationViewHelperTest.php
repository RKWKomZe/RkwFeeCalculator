<?php
namespace RKW\RkwFeecalculator\Tests\Integration\ViewHelpers;

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

use TYPO3\CMS\Fluid\View\StandaloneView;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use Nimut\TestingFramework\TestCase\FunctionalTestCase;
use RKW\RkwFeecalculator\Domain\Model\Calculation;
use RKW\RkwFeecalculator\ViewHelpers\CalculationViewHelper;
use RKW\RkwFeecalculator\Domain\Repository\ProgramRepository;
use RKW\RkwFeecalculator\Domain\Repository\CalculatorRepository;

/**
 * Class CalculationViewHelperTest
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwFeecalculator
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class CalculationViewHelperTest extends FunctionalTestCase
{

    /**
     * @const
     */
    const FIXTURE_PATH = __DIR__ . '/CalculationViewHelperTest/Fixtures';


    /**
     * @var string[]
     */
    protected $testExtensionsToLoad = [
        'typo3conf/ext/rkw_feecalculator'
    ];


    /**
     * @var string[]
     */
    protected $coreExtensionsToLoad = [];


    /**
     * @var \RKW\RkwFeecalculator\Domain\Repository\CalculatorRepository|null
     */
    private ?CalculatorRepository $calculatorRepository = null;


    /**
     * @var \RKW\RkwFeecalculator\Domain\Repository\ProgramRepository|null
     */
    private ?ProgramRepository $programRepository = null;


    /**
     * @var \TYPO3\CMS\Fluid\View\StandaloneView|null
     */
    private ?StandaloneView $standAloneViewHelper = null;


    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager|null
     */
    private ?ObjectManager $objectManager = null;


    /**
     * Setup
     *
     * @throws \Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->importDataSet(self::FIXTURE_PATH . '/Database/Global.xml');
        $this->setUpFrontendRootPage(
            1,
            [
                'EXT:rkw_feecalculator/Configuration/TypoScript/setup.typoscript',
                'EXT:rkw_feecalculator/Configuration/TypoScript/constants.typoscript',
                self::FIXTURE_PATH . '/Frontend/Configuration/Rootpage.typoscript',
            ]
        );

        /** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);

        /** @var \RKW\RkwFeecalculator\Domain\Repository\CalculatorRepository calculatorRepository */
        $this->calculatorRepository = $this->objectManager->get(CalculatorRepository::class);

        /** @var \RKW\RkwFeecalculator\Domain\Repository\ProgramRepository programRepository */
        $this->programRepository = $this->objectManager->get(ProgramRepository::class);

        /** @var \TYPO3\CMS\Fluid\View\StandaloneView standAloneViewHelper */
        $this->standAloneViewHelper = $this->objectManager->get(StandaloneView::class);
        $this->standAloneViewHelper->setTemplateRootPaths(
            [
                0 => self::FIXTURE_PATH . '/Frontend/Templates'
            ]
        );

    }

    #==========================================================================

    /**
     * @test
     * @throws \Exception
     */
    public function itReturnsCorrectCalculationLessStandardUnitCostsThreshold()
    {

        /**
         * Scenario:
         *
         * Given the ViewHelper is used in a template
         * Given a persisted calculator-object
         * Given a persisted program-object
         * Given rkwFeePerDay is 120
         * Given fundingFactor is 0.5
         * Given standardUnitCosts is 950
         * When days are set to 6
         * When consultantFeePerDay is set to 700
         * Then the subventionTotal is subTotalPerDay * days = 4920
         */

        $this->importDataSet(static::FIXTURE_PATH . '/Database/Check10.xml');

        /** @var \RKW\RkwFeecalculator\Domain\Model\Calculator $calculator */
        $calculator = $this->calculatorRepository->findByUid(1);

        /** @var \RKW\RkwFeecalculator\Domain\Model\Program $program */
        $selectedProgram = $this->programRepository->findByUid(1);

        /** @var  \RKW\RkwFeecalculator\Domain\Model\Calculation calculation */
        $calculation = GeneralUtility::makeInstance(Calculation::class);
        $calculation->setCalculator($calculator);

        $calculation->setSelectedProgram($selectedProgram);

        $calculation->setDays(6);
        $calculation->setConsultantFeePerDay(700);

        $this->standAloneViewHelper->setTemplate('Check10.html');
        $this->standAloneViewHelper->assign('calculation', $calculation);
        $result = $this->standAloneViewHelper->render();

        self::assertStringContainsString('subventionTotal: 4920', $result);
        self::assertStringContainsString('rkwFee: 720', $result);
        self::assertStringContainsString('consultantFee: 4200', $result);
        self::assertStringContainsString('subtotalPerDay: 820', $result);
        self::assertStringContainsString('subtotal: 4920', $result);
        self::assertStringContainsString('tax: 934.8', $result);
        self::assertStringContainsString('total: 5854.8', $result);
        self::assertStringContainsString('consultantFeeSubvention: 4200', $result);
        self::assertStringContainsString('rkwFeeSubvention: 720', $result);
        self::assertStringContainsString('subventionSubtotal: 4920', $result);
        self::assertStringContainsString('funding: 2850', $result);
        self::assertStringContainsString('ownFundingNet: 2070', $result);
        self::assertStringContainsString('ownFundingGross: 3004.8', $result);
        self::assertStringContainsString('fundingPercentage: 57.926829268293', $result);

    }


    /**
     * @test
     * @throws \Exception
     */
    public function itReturnsCorrectCalculationGreaterStandardUnitCostsThreshold()
    {

        /**
         * Scenario:
         *
         * Given the ViewHelper is used in a template
         * Given a persisted calculator-object
         * Given a persisted program-object
         * Given rkwFeePerDay is 120
         * Given fundingFactor is 0.5
         * Given standardUnitCosts is 950
         * When days are set to 6
         * When consultantFeePerDay is set to 1000
         * Then the subventionTotal is standardUnitCosts * days = 5700
         */

        $this->importDataSet(static::FIXTURE_PATH . '/Database/Check20.xml');

        /** @var \RKW\RkwFeecalculator\Domain\Model\Calculator $calculator */
        $calculator = $this->calculatorRepository->findByUid(1);

        /** @var \RKW\RkwFeecalculator\Domain\Model\Program $program */
        $selectedProgram = $this->programRepository->findByUid(1);

        /** @var  \RKW\RkwFeecalculator\Domain\Model\Calculation calculation */
        $calculation = GeneralUtility::makeInstance(Calculation::class);
        $calculation->setCalculator($calculator);

        $calculation->setSelectedProgram($selectedProgram);

        $calculation->setDays(6);
        $calculation->setConsultantFeePerDay(1000);

        $this->standAloneViewHelper->setTemplate('Check10.html');
        $this->standAloneViewHelper->assign('calculation', $calculation);
        $result = $this->standAloneViewHelper->render();

        self::assertStringContainsString('subventionTotal: 5700', $result);
        self::assertStringContainsString('rkwFee: 720', $result);
        self::assertStringContainsString('consultantFee: 6000', $result);
        self::assertStringContainsString('subtotalPerDay: 1120', $result);
        self::assertStringContainsString('subtotal: 6720', $result);
        self::assertStringContainsString('tax: 1276.8', $result);
        self::assertStringContainsString('total: 7996.8', $result);
        self::assertStringContainsString('consultantFeeSubvention: 6000', $result);
        self::assertStringContainsString('rkwFeeSubvention: 720', $result);
        self::assertStringContainsString('subventionSubtotal: 6720', $result);
        self::assertStringContainsString('funding: 2850', $result);
        self::assertStringContainsString('ownFundingNet: 3870', $result);
        self::assertStringContainsString('ownFundingGross: 5146.8', $result);
        self::assertStringContainsString('fundingPercentage: 42.410714285714', $result);

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
