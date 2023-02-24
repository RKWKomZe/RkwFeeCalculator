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
     * @var \RKW\RkwFeecalculator\Domain\Model\Calculation|null
     */
    protected ?Calculation $calculation = null;


    /**
     * @var \RKW\RkwFeecalculator\ViewHelpers\CalculationViewHelper|null
     */
    protected ?CalculationViewHelper $calculationViewHelper = null;


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

        $this->calculationViewHelper = new CalculationViewHelper();
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
        $this->calculation = GeneralUtility::makeInstance(Calculation::class);
        $this->calculation->setCalculator($calculator);

        $this->calculation->setSelectedProgram($selectedProgram);

        $this->calculation->setDays(6);
        $this->calculation->setConsultantFeePerDay(700);

        $result = $this->calculationViewHelper->calculate($this->calculation);

        self::assertEquals(4920, $result['subventionTotal']);
        self::assertEquals(720, $result['rkwFee']);
        self::assertEquals(4200, $result['consultantFee']);
        self::assertEquals(820, $result['subtotalPerDay']);
        self::assertEquals(4920, $result['subtotal']);
        self::assertEquals(934.8, $result['tax']);
        self::assertEquals(5854.8, $result['total']);
        self::assertEquals(4200, $result['consultantFeeSubvention']);
        self::assertEquals(720, $result['rkwFeeSubvention']);
        self::assertEquals(4920, $result['subventionSubtotal']);
        self::assertEquals(2850, $result['funding']);
        self::assertEquals(2070, $result['ownFundingNet']);
        self::assertEquals(3004.8, $result['ownFundingGross']);
        self::assertEquals(57.926829268293, $result['fundingPercentage']);

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
        $this->calculation = GeneralUtility::makeInstance(Calculation::class);
        $this->calculation->setCalculator($calculator);

        $this->calculation->setSelectedProgram($selectedProgram);

        $this->calculation->setDays(6);
        $this->calculation->setConsultantFeePerDay(1000);

        $result = $this->calculationViewHelper->calculate($this->calculation);

        self::assertEquals(5700, $result['subventionTotal']);
        self::assertEquals(720, $result['rkwFee']);
        self::assertEquals(6000, $result['consultantFee']);
        self::assertEquals(1120, $result['subtotalPerDay']);
        self::assertEquals(6720, $result['subtotal']);
        self::assertEquals(1276.8, $result['tax']);
        self::assertEquals(7996.8, $result['total']);
        self::assertEquals(6000, $result['consultantFeeSubvention']);
        self::assertEquals(720, $result['rkwFeeSubvention']);
        self::assertEquals(6720, $result['subventionSubtotal']);
        self::assertEquals(2850, $result['funding']);
        self::assertEquals(3870, $result['ownFundingNet']);
        self::assertEquals(5146.8, $result['ownFundingGross']);
        self::assertEquals(42.410714285714, $result['fundingPercentage']);

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
