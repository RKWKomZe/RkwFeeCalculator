<?php
namespace RKW\RkwFeecalculator\Tests\Unit\Domain\Model;

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

use RKW\RkwFeecalculator\Domain\Model\Consulting;
use RKW\RkwFeecalculator\Domain\Model\Program;
use RKW\RkwFeecalculator\Tests\Unit\TestCase;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Class ProgramTest
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwFeecalculator
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @todo there are no scenarios defined. See coding guidelines!
 */
class ProgramTest extends TestCase
{
    /**
     * @var \RKW\RkwFeecalculator\Domain\Model\Program|null
     */
    protected ?Program $subject = null;


    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @var \RKW\RkwFeecalculator\Domain\Model\Program subject */
        $this->subject = GeneralUtility::makeInstance(Program::class);
    }

    #==========================================================================


    /**
     * @test
     */
    public function getNameReturnsInitialValueForString()
    {
        self::assertSame('', $this->subject->getName());
    }


    /**
     * @test
     */
    public function setNameForStringSetsName()
    {
        $this->subject->setName('Conceived at T3CON10');

        self::assertEquals('Conceived at T3CON10', $this->subject->getName());

    }

    #==========================================================================


    /**
     * @test
     */
    public function getPossibleDaysMinReturnsInitialValueForInt()
    {
        self::assertSame(0, $this->subject->getPossibleDaysMin());
    }


    /**
     * @test
     */
    public function setPossibleDaysMinForIntSetsPossibleDaysMin()
    {
        $this->subject->setPossibleDaysMin(5);
        self::assertEquals(5, $this->subject->getPossibleDaysMin());
    }

    #==========================================================================

    /**
     * @test
     */
    public function getPossibleDaysMaxReturnsInitialValueForInt()
    {
        self::assertSame(0, $this->subject->getPossibleDaysMax());
    }


    /**
     * @test
     */
    public function setPossibleDaysMaxForIntSetsPossibleDaysMax()
    {
        $this->subject->setPossibleDaysMax(10);
        self::assertEquals(10, $this->subject->getPossibleDaysMax());
    }

    #==========================================================================

    /**
     * @test
     */
    public function getContentReturnsInitialValueForString()
    {
        self::assertSame('', $this->subject->getContent());
    }


    /**
     * @test
     */
    public function setContentForStringSetsContent()
    {
        $this->subject->setContent('Conceived at T3CON10');
        self::assertEquals('Conceived at T3CON10', $this->subject->getContent());

    }

    #==========================================================================

    /**
     * @test
     */
    public function getRkwFeePerDayReturnsInitialValueForDouble()
    {
        self::assertSame(0.00, $this->subject->getRkwFeePerDay());
    }


    /**
     * @test
     */
    public function setRkwFeePerDayForDoubleSetsRkwFeePerDay()
    {
        $this->subject->setRkwFeePerDay(100.87);
        self::assertEquals(100.87, $this->subject->getRkwFeePerDay());
    }


    /**
     * @test
     */
    public function setRkwFeePerDayIsSetAsADotValue()
    {
        $this->subject->setRkwFeePerDay('100,46');
        self::assertEquals(100.46, $this->subject->getRkwFeePerDay());
    }

    #==========================================================================

    /**
     * @test
     */
    public function getConsultantFeePerDayLimitReturnsInitialValueForDouble()
    {
        self::assertSame(0.00, $this->subject->getConsultantFeePerDayLimit());
    }


    /**
     * @test
     */
    public function setConsultantFeePerDayLimitForDoubleSetsConsultantFeePerDayLimit()
    {
        $this->subject->setConsultantFeePerDayLimit(800);
        self::assertEquals(800, $this->subject->getConsultantFeePerDayLimit());
    }

    /**
     * @test
     */
    public function setConsultantFeePerDayLimitIsSetAsADotValue()
    {

        $this->subject->setConsultantFeePerDayLimit('1000,46');
        self::assertEquals(1000.46, $this->subject->getConsultantFeePerDayLimit());
    }

    #==========================================================================

    /**
     * @test
     */
    public function getConsultantSubventionLimitReturnsInitialValueForDouble()
    {
        self::assertSame(0.00, $this->subject->getConsultantSubventionLimit());
    }

    /**
     * @test
     */
    public function setConsultantSubventionLimitForDoubleSetsConsultantSubventionLimit()
    {
        $this->subject->setConsultantSubventionLimit(3550);
        self::assertEquals(3550, $this->subject->getConsultantSubventionLimit());
    }

    #==========================================================================

    /**
     * @test
     */
    public function getRkwFeePerDayAsLimitReturnsInitialValueForBoolean()
    {
        self::assertFalse($this->subject->getRkwFeePerDayAsLimit());
    }


    /**
     * @test
     */
    public function setRkwFeePerDayAsLimitForBooleanSetsConsultantSubventionLimit()
    {
        $this->subject->setRkwFeePerDayAsLimit(true);
        self::assertEquals(true, $this->subject->getRkwFeePerDayAsLimit());

    }

    #==========================================================================

    /**
     * @test
     */
    public function getFundingFactorReturnsInitialValueForFloat()
    {
        self::assertSame(1.0, $this->subject->getFundingFactor());
    }

    /**
     * @test
     */
    public function setFundingFactor()
    {
        $this->subject->setFundingFactor(0.8);
        self::assertEquals(0.8, $this->subject->getFundingFactor());
    }

    #==========================================================================

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

        self::assertSame([], $this->subject->getPossibleDays());
    }

    #==========================================================================

    /**
     * @test
     */
    public function getConsultingReturnsInitialValueForConsulting()
    {
        /** @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage $newObjectStorage  */
        $newObjectStorage = GeneralUtility::makeInstance(ObjectStorage::class);

        self::assertEquals($newObjectStorage, $this->subject->getConsulting());
    }

    /**
     * @test
     */
    public function setConsultingForObjectStorageContainingConsultingSetsConsulting()
    {
        /** @var \RKW\RkwFeecalculator\Domain\Model\Consulting $consulting */
        $consulting = GeneralUtility::makeInstance(Consulting::class);

        /** @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage $objectStorageHoldingExactlyOneConsulting  */
        $objectStorageHoldingExactlyOneConsulting = GeneralUtility::makeInstance(ObjectStorage::class);
        $objectStorageHoldingExactlyOneConsulting->attach($consulting);
        $this->subject->setConsulting($objectStorageHoldingExactlyOneConsulting);

        self::assertEquals($objectStorageHoldingExactlyOneConsulting, $this->subject->getConsulting());

    }


    /**
     * @test
     */
    public function addConsultingToObjectStorageHoldingConsulting()
    {
        /** @var \RKW\RkwFeecalculator\Domain\Model\Consulting $consulting */
        $consulting = GeneralUtility::makeInstance(Consulting::class);

        /** @var \PHPUnit\Framework\MockObject\MockObject $consultingObjectStorageMock */
        $consultingObjectStorageMock = $this->getMockBuilder(ObjectStorage::class)
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
        /** @var \RKW\RkwFeecalculator\Domain\Model\Consulting $consulting */
        $consulting = GeneralUtility::makeInstance(Consulting::class);

        /** @var \PHPUnit\Framework\MockObject\MockObject $consultingObjectStorageMock */
        $consultingObjectStorageMock = $this->getMockBuilder(ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $consultingObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($consulting));
        $this->inject($this->subject, 'consulting', $consultingObjectStorageMock);

        $this->subject->removeConsulting($consulting);

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
