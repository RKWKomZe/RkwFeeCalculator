<?php

namespace RKW\RkwFeecalculator\Tests\Unit\Domain\Model;

use RKW\RkwFeecalculator\Domain\Model\Institution;
use RKW\RkwFeecalculator\Domain\Model\Program;
use RKW\RkwFeecalculator\Tests\Unit\TestCase;

/**
 * Test case.
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 */
class ProgramTest extends TestCase
{
    /**
     * @var Program
     */
    protected $subject;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new Program();
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
    public function getPossibleDaysMinReturnsInitialValueForInt()
    {
        self::assertSame(
            0,
            $this->subject->getPossibleDaysMin()
        );
    }

    /**
     * @test
     */
    public function setPossibleDaysMinForIntSetsPossibleDaysMin()
    {
        $this->subject->setPossibleDaysMin(5);

        self::assertAttributeEquals(
            5,
            'possibleDaysMin',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getPossibleDaysMaxReturnsInitialValueForInt()
    {
        self::assertSame(
            0,
            $this->subject->getPossibleDaysMax()
        );
    }

    /**
     * @test
     */
    public function setPossibleDaysMaxForIntSetsPossibleDaysMax()
    {
        $this->subject->setPossibleDaysMax(10);

        self::assertAttributeEquals(
            10,
            'possibleDaysMax',
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
    public function getRkwFeePerDayReturnsInitialValueForDouble()
    {
        self::assertSame(
            0.00,
            $this->subject->getRkwFeePerDay()
        );
    }

    /**
     * @test
     */
    public function setRkwFeePerDayForDoubleSetsRkwFeePerDay()
    {
        $this->subject->setRkwFeePerDay(100.87);

        self::assertAttributeEquals(
            100.87,
            'rkwFeePerDay',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getConsultantFeePerDayLimitReturnsInitialValueForDouble()
    {
        self::assertSame(
            0.00,
            $this->subject->getConsultantFeePerDayLimit()
        );
    }

    /**
     * @test
     */
    public function setConsultantFeePerDayLimitForDoubleSetsConsultantFeePerDayLimit()
    {
        $this->subject->setConsultantFeePerDayLimit(800);

        self::assertAttributeEquals(
            800,
            'consultantFeePerDayLimit',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getConsultantSubventionLimitReturnsInitialValueForDouble()
    {
        self::assertSame(
            0.00,
            $this->subject->getConsultantSubventionLimit()
        );
    }

    /**
     * @test
     */
    public function setConsultantSubventionLimitForDoubleSetsConsultantSubventionLimit()
    {
        $this->subject->setConsultantSubventionLimit(3550);

        self::assertAttributeEquals(
            3550,
            'consultantSubventionLimit',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getRkwFeePerDayAsLimitReturnsInitialValueForBoolean()
    {
        self::assertFalse(
            $this->subject->getRkwFeePerDayAsLimit()
        );
    }

    /**
     * @test
     */
    public function setRkwFeePerDayAsLimitForBooleanSetsConsultantSubventionLimit()
    {
        $this->subject->setRkwFeePerDayAsLimit(true);

        self::assertAttributeEquals(
            true,
            'rkwFeePerDayAsLimit',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getFundingFactorReturnsInitialValueForFloat()
    {
        self::assertSame(
            1.0,
            $this->subject->getFundingFactor()
        );
    }

    /**
     * @test
     */
    public function setFundingFactor()
    {
        $this->subject->setFundingFactor(0.8);

        self::assertAttributeEquals(
            0.8,
            'fundingFactor',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function aCommaRkwFeePerDayValueIsSetAsADotValue()
    {
        $this->subject->setRkwFeePerDay('100,46');

        self::assertAttributeEquals(
            100.46,
            'rkwFeePerDay',
            $this->subject
        );

        $this->subject->setConsultantFeePerDayLimit('1000,46');

        self::assertAttributeEquals(
            1000.46,
            'consultantFeePerDayLimit',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function givenPossibleMinAndMaxDaysItReturnsCorrectPossibleDaysArray()
    {
        $this->subject->setPossibleDaysMin(5);
        $this->subject->setPossibleDaysMax(10);

        self::assertSame(
            [
                '5'  => 5,
                '6'  => 6,
                '7'  => 7,
                '8'  => 8,
                '9'  => 9,
                '10' => 10,
            ],
            $this->subject->getPossibleDays()
        );
    }

    /**
     * @test
     */
    public function givenPossibleMinAndMaxDaysAreSetToZeroItReturnsEmptyPossibleDaysArray()
    {
        $this->subject->setPossibleDaysMin(0);
        $this->subject->setPossibleDaysMax(0);

        self::assertSame(
            [],
            $this->subject->getPossibleDays()
        );
    }

    /**
     * @test
     */
    public function getConsultingReturnsInitialValueForConsulting()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getConsulting()
        );

    }

    /**
     * @test
     */
    public function setConsultingForObjectStorageContainingConsultingSetsConsulting()
    {
        $consulting = new \RKW\RkwFeecalculator\Domain\Model\Consulting();
        $objectStorageHoldingExactlyOneConsulting = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneConsulting->attach($consulting);
        $this->subject->setConsulting($objectStorageHoldingExactlyOneConsulting);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneConsulting,
            'consulting',
            $this->subject
        );

    }

    /**
     * @test
     */
    public function addConsultingToObjectStorageHoldingConsulting()
    {
        $consulting = new \RKW\RkwFeecalculator\Domain\Model\Consulting();
        $consultingObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $consultingObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($consulting));
        $this->inject($this->subject, 'consulting', $consultingObjectStorageMock);

        $this->subject->addConsulting($consulting);
    }

    /**
     * @test
     */
    public function removeConsultingFromObjectStorageHoldingConsulting()
    {
        $consulting = new \RKW\RkwFeecalculator\Domain\Model\Consulting();
        $consultingObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $consultingObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($consulting));
        $this->inject($this->subject, 'consulting', $consultingObjectStorageMock);

        $this->subject->removeConsulting($consulting);

    }

}
