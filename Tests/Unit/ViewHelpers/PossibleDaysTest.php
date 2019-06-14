<?php
namespace RKW\RkwFeecalculator\Tests\Unit\ViewHelpers;

use Nimut\TestingFramework\TestCase\UnitTestCase;

/**
 * Test case.
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 */
class PossibleDaysTest extends UnitTestCase
{
    /**
     * @var \RKW\RkwFeecalculator\ViewHelpers\CalculationViewHelper
     */
    protected $subject = null;

    /**
     * @var \RKW\RkwFeecalculator\Domain\Model\Calculation
     */
    protected $calculation = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \RKW\RkwFeecalculator\ViewHelpers\PossibleDaysViewHelper();
        $this->calculation = new \RKW\RkwFeecalculator\Domain\Model\Calculation();
    }

    /**
     * @test
     */
    public function givenPossibleDaysMinAndMaxPossibleDaysAreCalculated()
    {

        $calculator = new \RKW\RkwFeecalculator\Domain\Model\Calculator();

        $assignableProgram = new \RKW\RkwFeecalculator\Domain\Model\Program();
        $assignableProgram->setPossibleDaysMin(5);
        $assignableProgram->setPossibleDaysMax(10);

        $objectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorage->attach($assignableProgram);

        $calculator->setAssignedPrograms($objectStorage);

        $this->calculation->setCalculator($calculator);
        $this->calculation->setSelectedProgram($assignableProgram);

        $expectedPossibleDays = [
            '5' => 5,
            '6' => 6,
            '7' => 7,
            '8' => 8,
            '9' => 9,
            '10' => 10
        ];

        $result = $this->subject->getPossibleDays($this->calculation);

        self::assertEquals(
            $expectedPossibleDays,
            $result
        );

    }

    /**
     * @test
     */
    public function givenPossibleDaysMinAndMaxAreZeroPossibleDaysAreCalculated()
    {

        $calculator = new \RKW\RkwFeecalculator\Domain\Model\Calculator();

        $assignableProgram = new \RKW\RkwFeecalculator\Domain\Model\Program();
        $assignableProgram->setPossibleDaysMin(0);
        $assignableProgram->setPossibleDaysMax(0);

        $objectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorage->attach($assignableProgram);

        $calculator->setAssignedPrograms($objectStorage);

        $this->calculation->setCalculator($calculator);
        $this->calculation->setSelectedProgram($assignableProgram);

        $expectedPossibleDays = [];

        $result = $this->subject->getPossibleDays($this->calculation);

        self::assertEquals(
            $expectedPossibleDays,
            $result
        );

    }

    /**
     * @test
     */
    public function givenPossibleDaysMinAndMaxAreNotZeroButSamePossibleDaysAreCalculated()
    {

        $calculator = new \RKW\RkwFeecalculator\Domain\Model\Calculator();

        $assignableProgram = new \RKW\RkwFeecalculator\Domain\Model\Program();
        $assignableProgram->setPossibleDaysMin(5);
        $assignableProgram->setPossibleDaysMax(5);

        $objectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorage->attach($assignableProgram);

        $calculator->setAssignedPrograms($objectStorage);

        $this->calculation->setCalculator($calculator);
        $this->calculation->setSelectedProgram($assignableProgram);

        $expectedPossibleDays = [
            '5' => 5
        ];

        $result = $this->subject->getPossibleDays($this->calculation);

        self::assertEquals(
            $expectedPossibleDays,
            $result
        );

    }

    protected function tearDown()
    {
        parent::tearDown();
    }

}
