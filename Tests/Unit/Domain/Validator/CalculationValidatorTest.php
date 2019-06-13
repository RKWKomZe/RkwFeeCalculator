<?php
namespace Rkw\RkwFeecalculator\Tests\Unit\Domain\Model;

use Nimut\TestingFramework\TestCase\UnitTestCase;

/**
 * Test case.
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 */
class CalculationValidatorTest extends UnitTestCase
{

    /**
     * @var string[]
     */
    protected $testExtensionsToLoad = [
        'typo3conf/ext/rkw_basics',
    ];

    /**
     * @var \Rkw\RkwFeecalculator\Validation\CalculationValidator
     */
    protected $subject = null;

    /**
     * @var \Rkw\RkwFeecalculator\Domain\Model\Calculation
     */
    protected $calculation = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Rkw\RkwFeecalculator\Validation\CalculationValidator();
        $this->calculation = new \Rkw\RkwFeecalculator\Domain\Model\Calculation();
    }

    /**
     * @test
     */
    public function givenSelectedProgramHasPossibleDaysMinLessDaysAreNotValid()
    {
        $selectedProgram = new \Rkw\RkwFeecalculator\Domain\Model\Program();
        $selectedProgram->setPossibleDaysMin(5);
        $selectedProgram->setPossibleDaysMax(10);

        $this->calculation->setSelectedProgram($selectedProgram);
        $this->calculation->setDays(2);

        $this->assertFalse($this->subject->isValid($this->calculation));
    }

    /**
     * @test
     */
    public function givenSelectedProgramHasPossibleDaysMinEqualDaysAreValid()
    {
        $selectedProgram = new \Rkw\RkwFeecalculator\Domain\Model\Program();
        $selectedProgram->setPossibleDaysMin(5);
        $selectedProgram->setPossibleDaysMax(10);

        $this->calculation->setSelectedProgram($selectedProgram);
        $this->calculation->setConsultantFeePerDay(1000);

        $this->calculation->setDays(5);

        $this->assertTrue($this->subject->isValid($this->calculation));
    }

    /**
     * @test
     */
    public function givenSelectedProgramHasPossibleDaysMinMoreDaysAreValid()
    {

        $selectedProgram = new \Rkw\RkwFeecalculator\Domain\Model\Program();
        $selectedProgram->setPossibleDaysMin(5);
        $selectedProgram->setPossibleDaysMax(10);

        $this->calculation->setSelectedProgram($selectedProgram);
        $this->calculation->setConsultantFeePerDay(1000);

        $this->calculation->setDays(10);

        $this->assertTrue($this->subject->isValid($this->calculation));
    }

    /**
     * @test
     */
    public function givenSelectedProgramHasPossibleDaysMaxMoreDaysAreNotValid()
    {
        $selectedProgram = new \Rkw\RkwFeecalculator\Domain\Model\Program();
        $selectedProgram->setPossibleDaysMin(5);
        $selectedProgram->setPossibleDaysMax(10);

        $this->calculation->setSelectedProgram($selectedProgram);
        $this->calculation->setConsultantFeePerDay(1000);

        $this->calculation->setDays(12);

        $this->assertFalse($this->subject->isValid($this->calculation));
    }

    /**
     * @test
     */
    public function givenSelectedProgramHasPossibleDaysMaxEqualDaysAreValid()
    {
        $selectedProgram = new \Rkw\RkwFeecalculator\Domain\Model\Program();
        $selectedProgram->setPossibleDaysMin(5);
        $selectedProgram->setPossibleDaysMax(10);

        $this->calculation->setSelectedProgram($selectedProgram);
        $this->calculation->setConsultantFeePerDay(1000);

        $this->calculation->setDays(10);

        $this->assertTrue($this->subject->isValid($this->calculation));
    }

    /**
     * @test
     */
    public function givenSelectedProgramHasPossibleDaysMaxLessDaysAreValid()
    {
        $selectedProgram = new \Rkw\RkwFeecalculator\Domain\Model\Program();
        $selectedProgram->setPossibleDaysMin(5);
        $selectedProgram->setPossibleDaysMax(10);

        $this->calculation->setSelectedProgram($selectedProgram);
        $this->calculation->setConsultantFeePerDay(1000);

        $this->calculation->setDays(5);

        $this->assertTrue($this->subject->isValid($this->calculation));
    }

    /**
     * @test
     */
    public function givenSelectedProgramHasPossibleDaysSetToZeroAnyDaysValueGreaterZeroIsValid()
    {
        $selectedProgram = new \Rkw\RkwFeecalculator\Domain\Model\Program();
        $selectedProgram->setPossibleDaysMin(0);
        $selectedProgram->setPossibleDaysMax(0);

        $this->calculation->setSelectedProgram($selectedProgram);
        $this->calculation->setConsultantFeePerDay(1000);

        $this->calculation->setDays(5);

        $this->assertTrue($this->subject->isValid($this->calculation));
    }

    /**
     * @test
     */
    public function givenSelectedProgramDaysIsRequired()
    {
        $selectedProgram = new \Rkw\RkwFeecalculator\Domain\Model\Program();

        $this->calculation->setSelectedProgram($selectedProgram);
        $this->calculation->setConsultantFeePerDay(1000);

        $this->assertFalse($this->subject->isValid($this->calculation));
    }

    /**
     * @test
     */
    public function givenSelectedProgramConsultantFeePerDayIsRequired()
    {
        $selectedProgram = new \Rkw\RkwFeecalculator\Domain\Model\Program();

        $this->calculation->setSelectedProgram($selectedProgram);
        $this->calculation->setDays(10);

        $this->assertFalse($this->subject->isValid($this->calculation));
    }

    /**
     * @test
     */
    public function submittingAMoneyValueWithLettersIsNotValid()
    {
        $selectedProgram = new \Rkw\RkwFeecalculator\Domain\Model\Program();

        $this->calculation->setSelectedProgram($selectedProgram);
        $this->calculation->setDays(10);
        $this->calculation->setConsultantFeePerDay('A7236483,234');

        $this->assertFalse($this->subject->isValid($this->calculation));
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

}
