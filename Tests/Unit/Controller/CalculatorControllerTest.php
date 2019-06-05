<?php
namespace Rkw\RkwFeecalculator\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 */
class CalculatorControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \Rkw\RkwFeecalculator\Controller\FeeCalculatorController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Rkw\RkwFeecalculator\Controller\FeeCalculatorController::class)
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

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assignMultiple')->with([
            'calculator' => $calculator,
            'assignedPrograms' => $calculator->getAssignedPrograms()->toArray()
        ]);

        $this->subject->showAction($calculator);
    }


}
