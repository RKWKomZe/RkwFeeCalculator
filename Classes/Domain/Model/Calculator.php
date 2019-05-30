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
     * days
     *
     * @var int
     */
    protected $days = 0;

    /**
     * consultantFeePerDay
     *
     * @var int
     */
    protected $consultantFeePerDay = 0;

    /**
     * assignedPrograms
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Rkw\RkwFeecalculator\Domain\Model\Program>
     * @cascade remove
     */
    protected $assignedPrograms = null;

    /**
     * selectedProgram
     *
     * @var \Rkw\RkwFeecalculator\Domain\Model\Program
     */
    protected $selectedProgram = null;

    /**
     * rkwFeeSubvention
     *
     * @var int
     */
    protected $rkwFeeSubvention;

    /**
     * consultantFeeSubvention
     *
     * @var int
     */
    protected $consultantFeeSubvention;

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
        $this->assignedPrograms = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
     * Returns the selectedProgram
     *
     * @return \Rkw\RkwFeecalculator\Domain\Model\Program $selectedProgram
     */
    public function getSelectedProgram()
    {
        return $this->selectedProgram;
    }

    /**
     * Sets the selectedProgram
     *
     * @param \Rkw\RkwFeecalculator\Domain\Model\Program $selectedProgram
     * @return void
     */
    public function setSelectedProgram(\Rkw\RkwFeecalculator\Domain\Model\Program $selectedProgram)
    {
        $this->selectedProgram = $selectedProgram;
    }

    /**
     * Adds a Program
     *
     * @param \Rkw\RkwFeecalculator\Domain\Model\Program $assignedProgram
     * @return void
     */
    public function addAssignedProgram(\Rkw\RkwFeecalculator\Domain\Model\Program $assignedProgram)
    {
        $this->assignedPrograms->attach($assignedProgram);
    }

    /**
     * Removes a Program
     *
     * @param \Rkw\RkwFeecalculator\Domain\Model\Program $assignedProgramToRemove The Program to be removed
     * @return void
     */
    public function removeAssignedProgram(\Rkw\RkwFeecalculator\Domain\Model\Program $assignedProgramToRemove)
    {
        $this->assignedPrograms->detach($assignedProgramToRemove);
    }

    /**
     * Returns the assignedPrograms
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Rkw\RkwFeecalculator\Domain\Model\Program> assignedPrograms
     */
    public function getAssignedPrograms()
    {
        return $this->assignedPrograms;
    }

    /**
     * Sets the assignedPrograms
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Rkw\RkwFeecalculator\Domain\Model\Program> $assignedPrograms
     * @return void
     */
    public function setAssignedPrograms(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $assignedPrograms)
    {
        $this->assignedPrograms = $assignedPrograms;
    }

    /**
     * Returns the consultantFeePerDay
     *
     * @return int consultantFeePerDay
     */
    public function getConsultantFeePerDay()
    {
        return $this->consultantFeePerDay;
    }

    /**
     * Sets the consultantFeePerDay
     *
     * @param int $consultantFeePerDay
     * @return void
     */
    public function setConsultantFeePerDay($consultantFeePerDay)
    {
        $this->consultantFeePerDay = $consultantFeePerDay;
    }

    /**
     * Sets the consultantFeeSubvention
     *
     * @param $consultantFeeSubvention
     * @return void;
     */
    public function setConsultantFeeSubvention($consultantFeeSubvention)
    {
        $this->consultantFeeSubvention = $consultantFeeSubvention;
    }

    /**
     * Returns the consultantFeeSubvention
     *
     * @return int consultantFeeSubvention
     */
    public function getConsultantFeeSubvention()
    {
        return $this->consultantFeeSubvention;
    }

    /**
     * Sets the rkwFeeSubvention
     *
     * @param $rkwFeeSubvention
     * @return void;
     */
    public function setRkwFeeSubvention($rkwFeeSubvention)
    {
        $this->rkwFeeSubvention = $rkwFeeSubvention;
    }

    /**
     * Returns the rkwFeeSubvention
     *
     * @return int rkwFeeSubvention
     */
    public function getRkwFeeSubvention()
    {
        return $this->rkwFeeSubvention;
    }

    public function calculate()
    {

        if ($this->consultantFeePerDay > $this->selectedProgram->getConsultantFeePerDayLimit()) {
            $this->setConsultantFeeSubvention($this->days * $this->selectedProgram->getConsultantFeePerDayLimit());
        } else {
            $this->setConsultantFeeSubvention($this->days * $this->consultantFeePerDay);
        }

        $this->setRkwFeeSubvention($this->days * $this->selectedProgram->getRkwFeePerDay());

    }
}
