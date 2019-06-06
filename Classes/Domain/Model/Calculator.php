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
     * name
     *
     * @var string
     */
    protected $name = '';

    /**
     * days
     *
     * @var integer
     */
    protected $days = 0;

    /**
     * consultantFeePerDay
     *
     * @var integer
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
     * rkwFee
     *
     * @var int
     */
    protected $rkwFee;

    /**
     * consultantFee
     *
     * @var int
     */
    protected $consultantFee;

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
     * subventionSubtotal
     *
     * @var int
     */
    protected $subventionSubtotal;

    /**
     * subtotal
     *
     * @var int
     */
    protected $subtotal;

    /**
     * subtotalPerDay
     *
     * @var int
     */
    protected $subtotalPerDay;

    /**
     * tax
     *
     * @var int
     */
    protected $tax;

    /**
     * total
     *
     * @var int
     */
    protected $total;

    /**
     * subventionTotal
     *
     * @var int
     */
    protected $subventionTotal;

    /**
     * funding
     *
     * @var int
     */
    protected $funding;

    /**
     * ownFundingNet
     *
     * @var int
     */
    protected $ownFundingNet;

    /**
     * ownFundingGross
     *
     * @var int
     */
    protected $ownFundingGross;

    /**
     * fundingPercentage
     *
     * @var int
     */
    protected $fundingPercentage;

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
     * Returns the name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name
     *
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * Sets the rkwFee
     *
     * @param $rkwFee
     * @return void;
     */
    public function setRkwFee($rkwFee)
    {
        $this->rkwFee = $rkwFee;
    }

    /**
     * Returns the rkwFee
     *
     * @return int rkwFee
     */
    public function getRkwFee()
    {
        return $this->rkwFee;
    }

    /**
     * Sets the consultantFee
     *
     * @param $consultantFee
     * @return void;
     */
    public function setConsultantFee($consultantFee)
    {
        $this->consultantFee = $consultantFee;
    }

    /**
     * Returns the consultantFee
     *
     * @return int consultantFee
     */
    public function getConsultantFee()
    {
        return $this->consultantFee;
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

    /**
     * Sets the subventionSubtotal
     *
     * @param $subventionSubtotal
     * @return void;
     */
    public function setSubventionSubtotal($subventionSubtotal)
    {
        $this->subventionSubtotal = $subventionSubtotal;
    }

    /**
     * Returns the subventionSubtotal
     *
     * @return int subventionSubtotal
     */
    public function getSubventionSubtotal()
    {
        return $this->subventionSubtotal;
    }

    /**
     * Sets the subtotal
     *
     * @param $subtotal
     * @return void;
     */
    public function setSubtotal($subtotal)
    {
        $this->subtotal = $subtotal;
    }

    /**
     * Returns the subtotal
     *
     * @return int subtotal
     */
    public function getSubtotal()
    {
        return $this->subtotal;
    }

    /**
     * Sets the subtotalPerDay
     *
     * @param $subtotalPerDay
     * @return void;
     */
    public function setSubtotalPerDay($subtotalPerDay)
    {
        $this->subtotalPerDay = $subtotalPerDay;
    }

    /**
     * Returns the subtotalPerDay
     *
     * @return int subtotalPerDay
     */
    public function getSubtotalPerDay()
    {
        return $this->subtotalPerDay;
    }

    /**
     * Sets the tax
     *
     * @param $tax
     * @return void;
     */
    public function setTax($tax)
    {
        $this->tax = $tax;
    }

    /**
     * Returns the tax
     *
     * @return int tax
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * Sets the total
     *
     * @param $total
     * @return void;
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }

    /**
     * Returns the total
     *
     * @return int total
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Sets the subventionTotal
     *
     * @param $subventionTotal
     * @return void;
     */
    public function setSubventionTotal($subventionTotal)
    {
        $this->subventionTotal = $subventionTotal;
    }

    /**
     * Returns the subventionTotal
     *
     * @return int subventionTotal
     */
    public function getSubventionTotal()
    {
        return $this->subventionTotal;
    }

    /**
     * Sets the funding
     *
     * @param $funding
     * @return void;
     */
    public function setFunding($funding)
    {
        $this->funding = $funding;
    }

    /**
     * Returns the funding
     *
     * @return int funding
     */
    public function getFunding()
    {
        return $this->funding;
    }

    /**
     * Sets the ownFundingNet
     *
     * @param $ownFundingNet
     * @return void;
     */
    public function setOwnFundingNet($ownFundingNet)
    {
        $this->ownFundingNet = $ownFundingNet;
    }

    /**
     * Returns the ownFundingNet
     *
     * @return int ownFundingNet
     */
    public function getOwnFundingNet()
    {
        return $this->ownFundingNet;
    }

    /**
     * Sets the ownFundingGross
     *
     * @param $ownFundingGross
     * @return void;
     */
    public function setOwnFundingGross($ownFundingGross)
    {
        $this->ownFundingGross = $ownFundingGross;
    }

    /**
     * Returns the ownFundingGross
     *
     * @return int ownFundingGross
     */
    public function getOwnFundingGross()
    {
        return $this->ownFundingGross;
    }

    /**
     * Sets the fundingPercentage
     *
     * @param $fundingPercentage
     * @return void;
     */
    public function setFundingPercentage($fundingPercentage)
    {
        $this->fundingPercentage = $fundingPercentage;
    }

    /**
     * Returns the fundingPercentage
     *
     * @return int fundingPercentage
     */
    public function getFundingPercentage()
    {
        return $this->fundingPercentage;
    }

    /**
     *
     */
    public function calculate()
    {

        $this->rkwFee = $this->days * $this->selectedProgram->getRkwFeePerDay();
        $this->consultantFee = $this->days * $this->consultantFeePerDay;
        $this->subtotalPerDay = $this->selectedProgram->getRkwFeePerDay() + $this->consultantFeePerDay;
        $this->subtotal = $this->days * $this->subtotalPerDay;
        $this->tax = $this->subtotal * 0.19;
        $this->total = $this->subtotal + $this->tax;

        if ($this->selectedProgram->getConsultantFeePerDayLimit() > 0 && $this->consultantFeePerDay > $this->selectedProgram->getConsultantFeePerDayLimit()) {
            $this->consultantFeeSubvention = $this->days * $this->selectedProgram->getConsultantFeePerDayFallback();
        } else {
            $this->consultantFeeSubvention = $this->consultantFee;
        }

        $this->rkwFeeSubvention = $this->rkwFee;
        $this->subventionSubtotal = $this->consultantFeeSubvention + $this->rkwFeeSubvention;
        $this->subventionTotal = $this->subventionSubtotal;

        $this->funding = $this->subventionTotal * $this->getSelectedProgram()->getFundingFactor();
        $this->ownFundingNet = $this->subtotal - $this->funding;
        $this->ownFundingGross = $this->ownFundingNet + $this->tax;
        $this->fundingPercentage = ($this->funding / ($this->subtotal * 0.01));

    }

}
