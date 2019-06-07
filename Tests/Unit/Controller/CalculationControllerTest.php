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

        $assignableProgram = $this->getMockBuilder(\Rkw\RkwFeecalculator\Domain\Model\Program::class)->getMock();
        $objectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorage->attach($assignableProgram);

        $calculator->setAssignedPrograms($objectStorage);

        $calculation = new \Rkw\RkwFeecalculator\Domain\Model\Calculation();
        $calculation->setCalculator($calculator);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assignMultiple')->with([
            'calculation' => $calculation,
            'assignedPrograms' => $calculation->getCalculator()->getAssignedPrograms()->toArray()
        ]);

        $this->subject->showAction($calculation);
    }


}
