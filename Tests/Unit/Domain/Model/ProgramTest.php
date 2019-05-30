<?php
namespace Rkw\RkwFeecalculator\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 */
class ProgramTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \Rkw\RkwFeecalculator\Domain\Model\Program
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Rkw\RkwFeecalculator\Domain\Model\Program();
    }

    protected function tearDown()
    {
        parent::tearDown();
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

    /**
     * @test
     */
    public function getResponsibleInstitutionReturnsInitialValueForInt()
    {
    }

    /**
     * @test
     */
    public function setResponsibleInstitutionForIntSetsResponsibleInstitution()
    {
    }

    /**
     * @test
     */
    public function getCompanyAgeReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getCompanyAge()
        );

    }

    /**
     * @test
     */
    public function setCompanyAgeForStringSetsCompanyAge()
    {
        $this->subject->setCompanyAge('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'companyAge',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getPossibleDaysMinReturnsInitialValueForInt()
    {
    }

    /**
     * @test
     */
    public function setPossibleDaysMinForIntSetsPossibleDaysMin()
    {
    }

    /**
     * @test
     */
    public function getPossibleDaysMaxReturnsInitialValueForInt()
    {
    }

    /**
     * @test
     */
    public function setPossibleDaysMaxForIntSetsPossibleDaysMax()
    {
    }

    /**
     * @test
     */
    public function getConditionsReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getConditions()
        );

    }

    /**
     * @test
     */
    public function setConditionsForStringSetsConditions()
    {
        $this->subject->setConditions('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'conditions',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getContentReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getContent()
        );

    }

    /**
     * @test
     */
    public function setContentForStringSetsContent()
    {
        $this->subject->setContent('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'content',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getRkwFeePerDayReturnsInitialValueForInt()
    {
    }

    /**
     * @test
     */
    public function setRkwFeePerDayForIntSetsRkwFeePerDay()
    {
    }

    /**
     * @test
     */
    public function getConsultantFeePerDayLimitReturnsInitialValueForInt()
    {
    }

    /**
     * @test
     */
    public function setConsultantFeePerDayLimitForIntSetsConsultantFeePerDayLimit()
    {
    }

    /**
     * @test
     */
    public function getMiscellaneousReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getMiscellaneous()
        );

    }

    /**
     * @test
     */
    public function setMiscellaneousForStringSetsMiscellaneous()
    {
        $this->subject->setMiscellaneous('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'miscellaneous',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function getInstitutionReturnsInitialValueForInstitution()
    {
        self::assertEquals(
            null,
            $this->subject->getInstitution()
        );

    }

    /**
     * @test
     */
    public function setInstitutionForInstitutionSetsInstitution()
    {
        $institutionFixture = new \Rkw\RkwFeecalculator\Domain\Model\Institution();
        $this->subject->setInstitution($institutionFixture);

        self::assertAttributeEquals(
            $institutionFixture,
            'institution',
            $this->subject
        );

    }
}
