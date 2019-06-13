<?php
namespace Rkw\RkwFeecalculator\Domain\Model;

/***
 *
 * This file is part of the "RKW FeeCalculator" Extension for TYPO3 CMS.
 *
 * For the full copyright and flicense information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2019 Christian Dilger <c.dilger@addorange.de>
 *
 ***/

/**
 * Calculation
 */
class Calculation extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * days
     *
     * @var integer
     * @validate Integer
     */
    protected $days = 0;

    /**
     * consultantFeePerDay
     *
     * @var string
     * @validate NotEmpty
     */
    protected $consultantFeePerDay = '0';

    /**
     * calculator
     *
     * @var \Rkw\RkwFeecalculator\Domain\Model\Calculator
     */
    protected $calculator = null;

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
     * Returns the calculator
     *
     * @return \Rkw\RkwFeecalculator\Domain\Model\Calculator $calculator
     */
    public function getCalculator()
    {
        return $this->calculator;
    }

    /**
     * Sets the calculator
     *
     * @param \Rkw\RkwFeecalculator\Domain\Model\Calculator $calculator
     * @return void
     */
    public function setCalculator(\Rkw\RkwFeecalculator\Domain\Model\Calculator $calculator)
    {
        $this->calculator = $calculator;
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
     * Returns the consultantFeePerDay
     *
     * @return float consultantFeePerDay
     */
    public function getConsultantFeePerDay()
    {
        if (!is_numeric($this->consultantFeePerDay)) {
            return $this->consultantFeePerDay;
        }

        $val = str_replace(",",".", $this->consultantFeePerDay);
        $val = preg_replace('/\.(?=.*\.)/', '', $val);
        return floatval($val);
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

}
