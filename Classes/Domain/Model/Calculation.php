<?php
namespace RKW\RkwFeecalculator\Domain\Model;

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

/**
 * Class Calculation
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwFeecalculator
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Calculation extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * @var bool
     */
    protected bool $showResults = false;


    /**
     * @var int
     * @TYPO3\CMS\Extbase\Annotation\Validate("Integer")
     */
    protected int $days = 0;


    /**
     * @var string
     */
    protected string $consultantFeePerDay = '0';


    /**
     * @var \RKW\RkwFeecalculator\Domain\Model\Calculator|null
     */
    protected ?Calculator $calculator = null;


    /**
     * @var \RKW\RkwFeecalculator\Domain\Model\Program|null
     */
    protected ?Program $selectedProgram = null;


    /**
     * @var \RKW\RkwFeecalculator\Domain\Model\Program|null
     */
    protected ?Program $previousSelectedProgram = null;


    /**
     * @var int
     */
    protected int $rkwFeeSubvention = 0;


    /**
     * @var int
     */
    protected int $consultantFeeSubvention = 0;


    /**
     * @var int
     */
    protected int $subventionSubtotal = 0;


    /**
     * @var int
     */
    protected int $subtotal = 0;


    /**
     * @var int
     */
    protected int $subtotalPerDay = 0;


    /**
     * @var int
     */
    protected int $tax = 0;


    /**
     * @var int
     */
    protected int $total = 0;


    /**
     * @var int
     */
    protected int $subventionTotal = 0;


    /**
     * @var int
     */
    protected int $funding = 0;


    /**
     * @var int
     */
    protected int $ownFundingNet = 0;


    /**
     * @var int
     */
    protected int $ownFundingGross = 0;


    /**
     * @var int
     */
    protected int $fundingPercentage = 0;


    /**
     * Returns the showResults
     *
     * @return bool
     */
    public function getShowResults(): bool
    {
        return $this->showResults;
    }


    /**
     * Sets the showResults
     *
     * @param bool $showResults
     * @return void
     */
    public function setShowResults(bool $showResults): void
    {
        $this->showResults = $showResults;
    }


    /**
     * Returns the days
     *
     * @return int
     */
    public function getDays(): int
    {
        return $this->days;
    }


    /**
     * Sets the days
     *
     * @param int $days
     * @return void
     */
    public function setDays(int $days): void
    {
        $this->days = $days;
    }


    /**
     * Returns the calculator
     *
     * @return \RKW\RkwFeecalculator\Domain\Model\Calculator
     */
    public function getCalculator():? Calculator
    {
        return $this->calculator;
    }


    /**
     * Sets the calculator
     *
     * @param \RKW\RkwFeecalculator\Domain\Model\Calculator $calculator
     * @return void
     */
    public function setCalculator(Calculator $calculator): void
    {
        $this->calculator = $calculator;
    }


    /**
     * Returns the selectedProgram
     *
     * @return \RKW\RkwFeecalculator\Domain\Model\Program
     */
    public function getSelectedProgram():? Program
    {
        return $this->selectedProgram;
    }


    /**
     * Sets the selectedProgram
     *
     * @param \RKW\RkwFeecalculator\Domain\Model\Program|null $selectedProgram
     * @return void
     */
    public function setSelectedProgram(Program $selectedProgram = null): void
    {
        if ($this->getCalculator()->getAssignedPrograms()->contains($selectedProgram)) {
            $this->selectedProgram = $selectedProgram;
        }
    }


    /**
     * Returns the previousSelectedProgram
     *
     * @return \RKW\RkwFeecalculator\Domain\Model\Program
     */
    public function getPreviousSelectedProgram():? Program
    {
        return $this->previousSelectedProgram;
    }


    /**
     * Sets the previousSelectedProgram
     *
     * @param \RKW\RkwFeecalculator\Domain\Model\Program|null $previousSelectedProgram
     * @return void
     */
    public function setPreviousSelectedProgram(Program $previousSelectedProgram = null): void
    {
        $this->previousSelectedProgram = $previousSelectedProgram;
    }


    /**
     * Returns the consultantFeePerDay
     *
     * @return float
     */
    public function getConsultantFeePerDay(): float
    {
        $val = str_replace(',', '.', $this->consultantFeePerDay);
        $val = preg_replace('/\.(?=.*\.)/', '', $val);

        return (float)$val;
    }


    /**
     * Returns the untouched consultantFeePerDay for validation
     *
     * @return string
     */
    public function getRawConsultantFeePerDay(): string
    {
        return $this->consultantFeePerDay;
    }


    /**
     * Sets the consultantFeePerDay
     *
     * @param string $consultantFeePerDay
     * @return void
     */
    public function setConsultantFeePerDay(string $consultantFeePerDay): void
    {
        $this->consultantFeePerDay = $consultantFeePerDay;
    }


    /**
     * Sets the consultantFeeSubvention
     *
     * @param int $consultantFeeSubvention
     * @return void
     */
    public function setConsultantFeeSubvention(int $consultantFeeSubvention): void
    {
        $this->consultantFeeSubvention = $consultantFeeSubvention;
    }


    /**
     * Returns the consultantFeeSubvention
     *
     * @return int
     */
    public function getConsultantFeeSubvention(): int
    {
        return $this->consultantFeeSubvention;
    }


    /**
     * Sets the rkwFeeSubvention
     *
     * @param $rkwFeeSubvention
     * @return void
     */
    public function setRkwFeeSubvention(int $rkwFeeSubvention): void
    {
        $this->rkwFeeSubvention = $rkwFeeSubvention;
    }


    /**
     * Returns the rkwFeeSubvention
     *
     * @return int
     */
    public function getRkwFeeSubvention(): int
    {
        return $this->rkwFeeSubvention;
    }


    /**
     * Sets the subventionSubtotal
     *
     * @param $subventionSubtotal
     * @return void
     */
    public function setSubventionSubtotal(int $subventionSubtotal): void
    {
        $this->subventionSubtotal = $subventionSubtotal;
    }


    /**
     * Returns the subventionSubtotal
     *
     * @return int
     */
    public function getSubventionSubtotal(): int
    {
        return $this->subventionSubtotal;
    }


    /**
     * Sets the subtotal
     *
     * @param int $subtotal
     * @return void
     */
    public function setSubtotal(int $subtotal): void
    {
        $this->subtotal = $subtotal;
    }


    /**
     * Returns the subtotal
     *
     * @return int
     */
    public function getSubtotal(): int
    {
        return $this->subtotal;
    }


    /**
     * Sets the subtotalPerDay
     *
     * @param int $subtotalPerDay
     * @return void
     */
    public function setSubtotalPerDay(int $subtotalPerDay): void
    {
        $this->subtotalPerDay = $subtotalPerDay;
    }


    /**
     * Returns the subtotalPerDay
     *
     * @return int
     */
    public function getSubtotalPerDay(): int
    {
        return $this->subtotalPerDay;
    }


    /**
     * Sets the tax
     *
     * @param int $tax
     * @return void
     */
    public function setTax(int $tax): void
    {
        $this->tax = $tax;
    }


    /**
     * Returns the tax
     *
     * @return int
     */
    public function getTax(): int
    {
        return $this->tax;
    }


    /**
     * Sets the total
     *
     * @param int $total
     * @return void
     */
    public function setTotal(int $total): void
    {
        $this->total = $total;
    }


    /**
     * Returns the total
     *
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }


    /**
     * Sets the subventionTotal
     *
     * @param int $subventionTotal
     * @return void
     */
    public function setSubventionTotal(int $subventionTotal): void
    {
        $this->subventionTotal = $subventionTotal;
    }


    /**
     * Returns the subventionTotal
     *
     * @return int
     */
    public function getSubventionTotal(): int
    {
        return $this->subventionTotal;
    }


    /**
     * Sets the funding
     *
     * @param int $funding
     * @return void
     */
    public function setFunding(int $funding): void
    {
        $this->funding = $funding;
    }


    /**
     * Returns the funding
     *
     * @return int funding
     */
    public function getFunding(): int
    {
        return $this->funding;
    }


    /**
     * Sets the ownFundingNet
     *
     * @param int $ownFundingNet
     * @return void
     */
    public function setOwnFundingNet(int $ownFundingNet): void
    {
        $this->ownFundingNet = $ownFundingNet;
    }


    /**
     * Returns the ownFundingNet
     *
     * @return int
     */
    public function getOwnFundingNet(): int
    {
        return $this->ownFundingNet;
    }


    /**
     * Sets the ownFundingGross
     *
     * @param int $ownFundingGross
     * @return void
     */
    public function setOwnFundingGross(int $ownFundingGross): void
    {
        $this->ownFundingGross = $ownFundingGross;
    }


    /**
     * Returns the ownFundingGross
     *
     * @return int ownFundingGross
     */
    public function getOwnFundingGross(): int
    {
        return $this->ownFundingGross;
    }


    /**
     * Sets the fundingPercentage
     *
     * @param int $fundingPercentage
     * @return void
     */
    public function setFundingPercentage(int $fundingPercentage): void
    {
        $this->fundingPercentage = $fundingPercentage;
    }


    /**
     * Returns the fundingPercentage
     *
     * @return int
     */
    public function getFundingPercentage(): int
    {
        return $this->fundingPercentage;
    }

}
