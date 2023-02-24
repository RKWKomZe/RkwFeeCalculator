<?php
namespace RKW\RkwFeecalculator\Tests\Unit\ViewHelpers;

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

use RKW\RkwFeecalculator\Tests\Unit\TestCase;
use RKW\RkwFeecalculator\Domain\Model\Program;
use RKW\RkwFeecalculator\ViewHelpers\PossibleDaysViewHelper;

/**
 * Class PossibleDaysTest
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwFeecalculator
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @todo there are no scenarios defined. See coding guidelines!
 */
class PossibleDaysTest extends TestCase
{

    /**
     * @var \RKW\RkwFeecalculator\ViewHelpers\PossibleDaysViewHelper|null
     */
    protected ?PossibleDaysViewHelper $subject = null;


    /**
     * @var \RKW\RkwFeecalculator\Domain\Model\Program|null
     */
    protected ?Program $program = null;


    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = new PossibleDaysViewHelper();
        $this->program = new Program();

    }

    #==========================================================================


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

        self::assertEquals($expectedPossibleDays, $result);
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
