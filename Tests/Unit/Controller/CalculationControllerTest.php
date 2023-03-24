<?php
namespace RKW\RkwFeecalculator\Tests\Unit\Controller;

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

use Nimut\TestingFramework\TestCase\UnitTestCase;
use RKW\RkwFeecalculator\Controller\CalculationController;
use RKW\RkwFeecalculator\Domain\Model\Calculation;
use RKW\RkwFeecalculator\Domain\Model\Calculator;
use RKW\RkwFeecalculator\Domain\Model\Program;
use RKW\RkwFeecalculator\Tests\Unit\TestCase;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Class CalculationControllerTest
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwFeecalculator
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @todo there are no scenarios defined. See coding guidelines!
 */
class CalculationControllerTest extends UnitTestCase
{
    /**
     * @var \RKW\RkwFeecalculator\Controller\CalculationController|null
     */
    protected ?CalculationController $subject= null;


    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @var \RKW\RkwFeecalculator\Controller\CalculationController subject */
        $this->subject = $this->getMockBuilder(CalculationController::class)
            ->setMethods(['redirect', 'forward', 'addFlashMessage'])
            ->disableOriginalConstructor()
            ->getMock();
    }

    #==========================================================================

    /**
     * @test
     */
    public function showActionAssignsTheGivenCalculatorToView()
    {

        /** @var \RKW\RkwFeecalculator\Domain\Model\Calculator $calculator */
        $calculator = GeneralUtility::makeInstance(Calculator::class);

        /** @var \RKW\RkwFeecalculator\Domain\Model\Program program */
        $assignableProgram = GeneralUtility::makeInstance(Program::class);

        /** @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage $objectStorage */
        $objectStorage = GeneralUtility::makeInstance(ObjectStorage::class);
        $objectStorage->attach($assignableProgram);

        $calculator->setAssignedPrograms($objectStorage);

        /** @var \RKW\RkwFeecalculator\Domain\Model\Calculation $calculation */
        $calculation = GeneralUtility::makeInstance(Calculation::class);
        $calculation->setCalculator($calculator);
        $calculation->setSelectedProgram($assignableProgram);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assignMultiple')->with([
            'calculation'      => $calculation,
            'assignedPrograms' => $calculation->getCalculator()->getAssignedPrograms()->toArray(),
        ]);

        $this->subject->showAction($calculation);
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
