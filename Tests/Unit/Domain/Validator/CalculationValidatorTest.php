<?php
namespace RKW\RkwFeecalculator\Tests\Unit\Domain\Model;

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
     * @var \RKW\RkwFeecalculator\Validation\CalculationValidator
     */
    protected $subject = null;

    /**
     * @var \RKW\RkwFeecalculator\Domain\Model\Calculation
     */
    protected $calculation = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \RKW\RkwFeecalculator\Validation\CalculationValidator();
        $this->calculation = new \RKW\RkwFeecalculator\Domain\Model\Calculation();
    }

    /**
     * @test
     */
    public function givenSelectedProgramHasPossibleDaysMinLessDaysAreNotValid()
    {
        $selectedProgram = new \RKW\RkwFeecalculator\Domain\Model\Program();
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
        $selectedProgram = new \RKW\RkwFeecalculator\Domain\Model\Program();
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

        $selectedProgram = new \RKW\RkwFeecalculator\Domain\Model\Program();
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
        $selectedProgram = new \RKW\RkwFeecalculator\Domain\Model\Program();
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
        $selectedProgram = new \RKW\RkwFeecalculator\Domain\Model\Program();
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
        $selectedProgram = new \RKW\RkwFeecalculator\Domain\Model\Program();
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
        $selectedProgram = new \RKW\RkwFeecalculator\Domain\Model\Program();
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
        $selectedProgram = new \RKW\RkwFeecalculator\Domain\Model\Program();

        $this->calculation->setSelectedProgram($selectedProgram);
        $this->calculation->setConsultantFeePerDay(1000);

        $this->assertFalse($this->subject->isValid($this->calculation));
    }

    /**
     * @test
     */
    public function givenSelectedProgramConsultantFeePerDayIsRequired()
    {
        $selectedProgram = new \RKW\RkwFeecalculator\Domain\Model\Program();

        $this->calculation->setSelectedProgram($selectedProgram);
        $this->calculation->setDays(10);

        $this->assertFalse($this->subject->isValid($this->calculation));
    }

    /**
     * @test
     */
    public function submittingAMoneyValueWithLettersIsNotValid()
    {
        $selectedProgram = new \RKW\RkwFeecalculator\Domain\Model\Program();

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
