<?php

namespace RKW\RkwFeecalculator\Tests\Unit\ViewHelpers;

use RKW\RkwFeecalculator\Tests\Unit\TestCase;
use RKW\RkwFeecalculator\Domain\Model\Program;
use RKW\RkwFeecalculator\ViewHelpers\PossibleDaysViewHelper;

/**
 * Test case.
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 */
class PossibleDaysTest extends TestCase
{
    /**
     * @var PossibleDaysViewHelper
     */
    protected $subject;

    /**
     * @var Program
     */
    protected $program;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new PossibleDaysViewHelper();
        $this->program = new Program();

    }

    /**
     * @test
     */
    public function givenProgramWithPossibleDaysSetItReturnsTheCorrectRangeOfPossibleDays()
    {
        $this->program->setPossibleDaysMin(5);
        $this->program->setPossibleDaysMax(10);

        $expectedPossibleDays = [
            '5'  => 5,
            '6'  => 6,
            '7'  => 7,
            '8'  => 8,
            '9'  => 9,
            '10' => 10,
        ];

        $result = $this->subject->render($this->program);

        self::assertEquals(
            $expectedPossibleDays,
            $result
        );
    }

}
