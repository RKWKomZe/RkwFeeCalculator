<?php
namespace Rkw\RkwFeecalculator\Domain\Model;

/***
 *
 * This file is part of the "RKW FeeCalculator" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2019 Christian Dilger <c.dilger@addorange.de>
 *
 ***/

/**
 * Calculator
 */
class Calculator extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * selectedProgram
     *
     * @var int
     */
    protected $selectedProgram = 0;

    /**
     * days
     *
     * @var int
     */
    protected $days = 0;

    /**
     * feePerDay
     *
     * @var int
     */
    protected $feePerDay = 0;

    /**
     * programs
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Rkw\RkwFeecalculator\Domain\Model\Program>
     * @cascade remove
     */
    protected $programs = null;

    /**
     * __construct
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }

    /**
     * Initializes all ObjectStorage properties
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     *
     * @return void
     */
    protected function initStorageObjects()
    {
        $this->programs = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Returns the selectedProgram
     *
     * @return int $selectedProgram
     */
    public function getSelectedProgram()
    {
        return $this->selectedProgram;
    }

    /**
     * Sets the selectedProgram
     *
     * @param int $selectedProgram
     * @return void
     */
    public function setSelectedProgram($selectedProgram)
    {
        $this->selectedProgram = $selectedProgram;
    }

    /**
     * Returns the days
     *
     * @return int $days
     */
    public function getDays()
    {
        return $this->days;
    }

    /**
     * Sets the days
     *
     * @param int $days
     * @return void
     */
    public function setDays($days)
    {
        $this->days = $days;
    }

    /**
     * Returns the feePerDay
     *
     * @return int $feePerDay
     */
    public function getFeePerDay()
    {
        return $this->feePerDay;
    }

    /**
     * Sets the feePerDay
     *
     * @param int $feePerDay
     * @return void
     */
    public function setFeePerDay($feePerDay)
    {
        $this->feePerDay = $feePerDay;
    }

    /**
     * Adds a Program
     *
     * @param \Rkw\RkwFeecalculator\Domain\Model\Program $program
     * @return void
     */
    public function addProgram(\Rkw\RkwFeecalculator\Domain\Model\Program $program)
    {
        $this->programs->attach($program);
    }

    /**
     * Removes a Program
     *
     * @param \Rkw\RkwFeecalculator\Domain\Model\Program $programToRemove The Program to be removed
     * @return void
     */
    public function removeProgram(\Rkw\RkwFeecalculator\Domain\Model\Program $programToRemove)
    {
        $this->programs->detach($programToRemove);
    }

    /**
     * Returns the programs
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Rkw\RkwFeecalculator\Domain\Model\Program> $programs
     */
    public function getPrograms()
    {
        return $this->programs;
    }

    /**
     * Sets the programs
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Rkw\RkwFeecalculator\Domain\Model\Program> $programs
     * @return void
     */
    public function setPrograms(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $programs)
    {
        $this->programs = $programs;
    }
}
