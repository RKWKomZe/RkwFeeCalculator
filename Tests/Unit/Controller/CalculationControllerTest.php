<?php
namespace Rkw\RkwFeecalculator\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 */
class CalculationControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \Rkw\RkwFeecalculator\Controller\CalculationController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Rkw\RkwFeecalculator\Controller\CalculationController::class)
            ->setMethods(['redirect', 'forward', 'addFlashMessage'])
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenCalculatorToView()
    {

        $calculator = new \Rkw\RkwFeecalculator\Domain\Model\Calculator();

        $assignableProgram = new \Rkw\RkwFeecalculator\Domain\Model\Program();
        $assignableProgram->setPossibleDaysMin(5);
        $assignableProgram->setPossibleDaysMax(10);

        $objectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorage->attach($assignableProgram);

        $calculator->setAssignedPrograms($objectStorage);

        $calculation = new \Rkw\RkwFeecalculator\Domain\Model\Calculation();
        $calculation->setCalculator($calculator);
        $calculation->setSelectedProgram($assignableProgram);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assignMultiple')->with([
            'calculation' => $calculation,
            'assignedPrograms' => $calculation->getCalculator()->getAssignedPrograms()->toArray(),
            'possibleDays' => [
                '5' => 5,
                '6' => 6,
                '7' => 7,
                '8' => 8,
                '9' => 9,
                '10' => 10
            ],
        ]);

        $this->subject->showAction($calculation);
    }

}
