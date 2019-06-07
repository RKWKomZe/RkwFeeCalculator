<?php
namespace Rkw\RkwFeecalculator\Tests\Functional\Domain\Model;

use Nimut\TestingFramework\TestCase\FunctionalTestCase;

/**
 * Test case.
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 */
class CalculationTest extends FunctionalTestCase
{
    /**
     * @var \Rkw\RkwFeecalculator\Domain\Model\Calculation
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Rkw\RkwFeecalculator\Domain\Model\Calculation();
    }

    /**
     * @todo
     */
    public function givenSelectedProgramHasPossibleDaysMinOnlyEqualOrMoreDaysCanBeSelected()
    {
        $selectedProgram = new \Rkw\RkwFeecalculator\Domain\Model\Program();
        $selectedProgram->setPossibleDaysMin(5);

        $this->subject->setDays(2);

        $this->assertNotEquals(2, $this->subject->getDays());
        $this->assertEquals(5, $this->subject->getDays());
        $this->assertTrue($this->subject->getDays() >= 5);
    }

    /**
     * @todo
     */
    public function givenSelectedProgramHasPossibleDaysMaxOnlyEqualOrLessDaysCanBeSelected()
    {
        $selectedProgram = new \Rkw\RkwFeecalculator\Domain\Model\Program();
        $selectedProgram->setPossibleDaysMax(20);

        $this->subject->setDays(22);

        $this->assertNotEquals(22, $this->subject->getDays());
        $this->assertEquals(20, $this->subject->getDays());
        $this->assertTrue($this->subject->getDays() <= 20);
    }


    /**
     * @test
     */
    public function aSelectedProgramContainedInAssignedProgramsCanBeSelected()
    {

        $calculator = new \Rkw\RkwFeecalculator\Domain\Model\Calculator();

        $assignedProgram1 = new \Rkw\RkwFeecalculator\Domain\Model\Program();
        $assignedProgram1->setName('Program 1');
        $assignedProgram2 = new \Rkw\RkwFeecalculator\Domain\Model\Program();
        $assignedProgram2->setName('Program 2');

        $objectStorageHoldingAssignedPrograms = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingAssignedPrograms->attach($assignedProgram1);
        $objectStorageHoldingAssignedPrograms->attach($assignedProgram2);

        $calculator->setAssignedPrograms($objectStorageHoldingAssignedPrograms);
        $this->subject->setCalculator($calculator);


        $selectedProgram = $assignedProgram1;

        //  @todo: Muss hier eine Validierung das Setzen eines Programms außerhalb der AssignedPrograms verhindern?!!

        $this->subject->setSelectedProgram($selectedProgram);

        self::assertTrue($this->subject->getCalculator()->getAssignedPrograms()->contains($this->subject->getSelectedProgram()));
        self::assertEquals($selectedProgram, $this->subject->getSelectedProgram());

    }

    /**
     * @todo
     */
    public function aSelectedProgramNotContainedInAssignedProgramsMustNotBeSelected()
    {

        $assignedProgram1 = new \Rkw\RkwFeecalculator\Domain\Model\Program();
        $assignedProgram1->setName('Program 1');
        $assignedProgram2 = new \Rkw\RkwFeecalculator\Domain\Model\Program();
        $assignedProgram2->setName('Program 2');

        $objectStorageHoldingAssignedPrograms = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingAssignedPrograms->attach($assignedProgram1);
        $objectStorageHoldingAssignedPrograms->attach($assignedProgram2);

        $calculator = new \Rkw\RkwFeecalculator\Domain\Model\Calculator();
        $calculator->setAssignedPrograms($objectStorageHoldingAssignedPrograms);

        $this->subject->setCalculator($calculator);

        $selectedProgram = new \Rkw\RkwFeecalculator\Domain\Model\Program();

        //  @todo: Muss hier eine Validierung das Setzen eines Programms außerhalb der AssignedPrograms verhindern?!!

        $this->subject->setSelectedProgram($selectedProgram);

        self::assertFalse($this->subject->getCalculator()->getAssignedPrograms()->contains($this->subject->getSelectedProgram()));
        self::assertNull($this->subject->getSelectedProgram());

    }

    protected function tearDown()
    {
        parent::tearDown();
    }

}
