<?php

namespace RKW\RkwFeecalculator\Tests\Unit\Controller;

use RKW\RkwFeecalculator\Domain\Model\Calculation;
use RKW\RkwFeecalculator\Domain\Model\Calculator;
use RKW\RkwFeecalculator\Domain\Model\Program;
use RKW\RkwFeecalculator\Tests\Unit\TestCase;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Test case.
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 */
class CalculationControllerTest extends TestCase
{
    /**
     * @var \RKW\RkwFeecalculator\Controller\CalculationController
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\RKW\RkwFeecalculator\Controller\CalculationController::class)
            ->setMethods(['redirect', 'forward', 'addFlashMessage'])
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenCalculatorToView()
    {

        $calculator = new Calculator();

        $assignableProgram = new Program();

        $objectStorage = new ObjectStorage();
        $objectStorage->attach($assignableProgram);

        $calculator->setAssignedPrograms($objectStorage);

        $calculation = new Calculation();
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

}
