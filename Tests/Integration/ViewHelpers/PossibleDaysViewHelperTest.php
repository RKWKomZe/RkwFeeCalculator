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

use Nimut\TestingFramework\TestCase\FunctionalTestCase;
use RKW\RkwFeecalculator\Domain\Model\Program;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Fluid\View\StandaloneView;

/**
 * Class PossibleDaysTest
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwFeecalculator
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @todo there are no scenarios defined. See coding guidelines!
 */
class PossibleDaysViewHelperTest extends FunctionalTestCase
{


    /**
     * @const
     */
    const FIXTURE_PATH = __DIR__ . '/PossibleDaysViewHelperTest/Fixtures';


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
     * @var \TYPO3\CMS\Fluid\View\StandaloneView|null
     */
    private ?StandaloneView $standAloneViewHelper = null;


    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager|null
     */
    private ?ObjectManager $objectManager = null;


    /**
     * @return void
     * @throws \Nimut\TestingFramework\Exception\Exception
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
     */
    public function givenProgramWithPossibleDaysSetItReturnsTheCorrectRangeOfPossibleDays()
    {

        /** @var \RKW\RkwFeecalculator\Domain\Model\Program $program */
        $program = GeneralUtility::makeInstance(Program::class);

        $program->setPossibleDaysMin(5);
        $program->setPossibleDaysMax(10);

        $this->standAloneViewHelper->setTemplate('Check10.html');
        $this->standAloneViewHelper->assign('program', $program);
        $result = $this->standAloneViewHelper->render();

        self::assertStringContainsString('5=5,6=6,7=7,8=8,9=9,10=10', $result);
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
