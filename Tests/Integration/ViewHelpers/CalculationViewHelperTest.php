<?php

namespace RKW\RkwFeecalculator\Tests\Integration\ViewHelpers;

use TYPO3\CMS\Fluid\View\StandaloneView;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use RKW\RkwFeecalculator\Domain\Model\Calculation;
use Nimut\TestingFramework\TestCase\FunctionalTestCase;
use RKW\RkwFeecalculator\ViewHelpers\CalculationViewHelper;
use RKW\RkwFeecalculator\Domain\Repository\ProgramRepository;
use RKW\RkwFeecalculator\Domain\Repository\CalculatorRepository;

/**
 * Test case.
 *
 * @author Christian Dilger <c.dilger@addorange.de>
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
     * @var \RKW\RkwFeecalculator\Domain\Repository\CalculatorRepository
     */
    private $calculatorRepository;

    /**
     * @var \RKW\RkwFeecalculator\Domain\Repository\ProgramRepository
     */
    private $programRepository;

    /**
     * @var \TYPO3\CMS\Fluid\View\StandaloneView
     */
    private $standAloneViewHelper;

    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager
     */
    private $objectManager;

    /**
     * @var Calculation
     */
    protected $calculation;

    /**
     * @var CalculationViewHelper
     */
    protected $calculationViewHelper;

    /**
     * Setup
     *
     * @throws \Exception
     */
    protected function setUp()
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

    /**
     * @test
     * @throws \Exception
     * @throws \TYPO3\CMS\Fluid\View\Exception\InvalidTemplateResourceException
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

        $this->calculation = new Calculation();
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
     * @throws \TYPO3\CMS\Fluid\View\Exception\InvalidTemplateResourceException
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

        $this->calculation = new Calculation();
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

}