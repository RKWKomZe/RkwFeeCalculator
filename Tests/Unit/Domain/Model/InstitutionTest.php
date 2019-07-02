<?php

namespace RKW\RkwFeecalculator\Tests\Unit\Domain\Model;

use RKW\RkwFeecalculator\Domain\Model\Institution;
use RKW\RkwFeecalculator\Tests\Unit\TestCase;

/**
 * Test case.
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 */
class InstitutionTest extends TestCase
{
    /**
     * @var Institution
     */
    protected $subject;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new Institution();
    }

    /**
     * @test
     */
    public function getNameReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getName()
        );

    }

    /**
     * @test
     */
    public function setNameForStringSetsName()
    {
        $this->subject->setName('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'name',
            $this->subject
        );

    }

}
