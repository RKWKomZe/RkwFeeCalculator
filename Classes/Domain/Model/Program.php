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

use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Class Program
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwFeecalculator
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Program extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("StringLength", options={"minimum": 3, "maximum": 100})
     */
    protected string $name = '';


    /**
     * @var int
     * @TYPO3\CMS\Extbase\Annotation\Validate("Integer")
     */
    protected int $possibleDaysMin = 0;


    /**
     * @var int
     * @TYPO3\CMS\Extbase\Annotation\Validate("Integer")
     */
    protected int $possibleDaysMax = 0;


    /**
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected string $content = '';


    /**
     * @var string
     */
    protected string $resultHint = '';


    /**
     * @var float
     * @TYPO3\CMS\Extbase\Annotation\Validate("Float")
     */
    protected float $rkwFeePerDay = 0.00;


    /**
     * @var float
     * @TYPO3\CMS\Extbase\Annotation\Validate("Float")
     */
    protected float $consultantFeePerDayLimit = 0.00;


    /**
     * @var float
     * @TYPO3\CMS\Extbase\Annotation\Validate("Float")
     */
    protected float $consultantSubventionLimit = 0.00;

    /**
     * @var bool
     */
    protected bool $rkwFeePerDayAsLimit = false;

    /**
     *
     * @var float
     * @TYPO3\CMS\Extbase\Annotation\Validate("Float")
     */
    protected float $fundingFactor = 1.00;


    /**
     * @var float
     * @TYPO3\CMS\Extbase\Annotation\Validate("Float")
     */
    protected float $standardUnitCosts = 0.00;


    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwFeecalculator\Domain\Model\Consulting>
     */
    protected ?ObjectStorage $consulting = null;


    /**
     * @var string
     */
    protected string $requestFields = '';


    /**
     * @var string
     */
    protected string $mandatoryFields = '';


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
        $this->consulting = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }


    /**
     * Returns the name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }


    /**
     * Sets the name
     *
     * @param string $name
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }


    /**
     * Returns the possibleDaysMin
     *
     * @return int
     */
    public function getPossibleDaysMin(): int
    {
        return $this->possibleDaysMin;
    }


    /**
     * Sets the possibleDaysMin
     *
     * @param int $possibleDaysMin
     * @return void
     */
    public function setPossibleDaysMin(int $possibleDaysMin): void
    {
        $this->possibleDaysMin = $possibleDaysMin;
    }


    /**
     * Returns the possibleDaysMax
     *
     * @return int
     */
    public function getPossibleDaysMax(): int
    {
        return $this->possibleDaysMax;
    }


    /**
     * Sets the possibleDaysMax
     *
     * @param int $possibleDaysMax
     * @return void
     */
    public function setPossibleDaysMax(int $possibleDaysMax): void
    {
        $this->possibleDaysMax = $possibleDaysMax;
    }


    /**
     * Returns the possibleDays (min <-> max) as array
     *
     * @return array $possibleDays
     */
    public function getPossibleDays(): array
    {

        $possibleDays = [];
        if ($this->possibleDaysMin > 0 && $this->possibleDaysMax > 0) {
            $possibleDays = range($this->possibleDaysMin, $this->possibleDaysMax);
            $possibleDays = array_combine($possibleDays, $possibleDays);
        }

        return $possibleDays;
    }


    /**
     * Returns the content
     *
     * @return string $content
     */
    public function getContent(): string
    {
        // @extensionScannerIgnoreLine
        return $this->content;
    }


    /**
     * Sets the content
     *
     * @param string $content
     * @return void
     */
    public function setContent(string $content): void
    {
        // @extensionScannerIgnoreLine
        $this->content = $content;
    }


    /**
     * Returns the resultHint
     *
     * @return string $resultHint
     */
    public function getResultHint(): string
    {
        // @extensionScannerIgnoreLine
        return $this->resultHint;
    }


    /**
     * Sets the resultHint
     *
     * @param string $resultHint
     * @return void
     */
    public function setResultHint(string $resultHint): void
    {
        // @extensionScannerIgnoreLine
        $this->resultHint = $resultHint;
    }


    /**
     * Returns the rkwFeePerDay
     *
     * @return float
     */
    public function getRkwFeePerDay(): float
    {
        return $this->rkwFeePerDay;
    }


    /**
     * Sets the rkwFeePerDay
     *
     * @param float|string $rkwFeePerDay
     * @return void
     */
    public function setRkwFeePerDay($rkwFeePerDay): void
    {
        $this->rkwFeePerDay = str_replace(',', '.', $rkwFeePerDay);
    }


    /**
     * Returns the fundingFactor
     *
     * @return float
     */
    public function getFundingFactor(): float
    {
        return $this->fundingFactor;
    }


    /**
     * Sets the fundingFactor
     *
     * @param float|string $fundingFactor
     * @return void
     */
    public function setFundingFactor($fundingFactor): void
    {
        $this->fundingFactor = str_replace(',', '.', $fundingFactor);
    }


    /**
     * Returns the standardUnitCosts
     *
     * @return float
     */
    public function getStandardUnitCosts(): float
    {
        return $this->standardUnitCosts;
    }


    /**
     * Sets the standardUnitCosts
     *
     * @param float|string $standardUnitCosts
     * @return void
     */
    public function setStandardUnitCosts($standardUnitCosts): void
    {
        $this->standardUnitCosts = str_replace(',', '.', $standardUnitCosts);
    }


    /**
     * Adds a Consulting
     *
     * @param \RKW\RkwFeecalculator\Domain\Model\Consulting $consulting
     * @return void
     */
    public function addConsulting(Consulting $consulting): void
    {
        $this->consulting->attach($consulting);
    }


    /**
     * Removes a Consulting
     *
     * @param \RKW\RkwFeecalculator\Domain\Model\Consulting $consultingToRemove The Consulting to be removed
     * @return void
     */
    public function removeConsulting(Consulting $consultingToRemove): void
    {
        $this->consulting->detach($consultingToRemove);
    }

    /**
     * Returns the consulting
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwFeecalculator\Domain\Model\Consulting> $consulting
     */
    public function getConsulting(): ObjectStorage
    {
        return $this->consulting;
    }


    /**
     * Sets the consulting
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwFeecalculator\Domain\Model\Consulting> $consulting
     * @return void
     */
    public function setConsulting(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $consulting): void
    {
        $this->consulting = $consulting;
    }


    /**
     * Returns the consultantFeePerDayLimit
     *
     * @return float
     */
    public function getConsultantFeePerDayLimit(): float
    {
        return $this->consultantFeePerDayLimit;
    }


    /**
     * Sets the consultantFeePerDayLimit
     *
     * @param float|string $consultantFeePerDayLimit
     * @return void
     */
    public function setConsultantFeePerDayLimit($consultantFeePerDayLimit): void
    {
        $this->consultantFeePerDayLimit = str_replace(',', '.', $consultantFeePerDayLimit);
    }


    /**
     * Returns the consultantSubventionLimit
     *
     * @return float
     */
    public function getConsultantSubventionLimit(): float
    {
        return $this->consultantSubventionLimit;
    }


    /**
     * Sets the consultantSubventionLimit
     *
     * @param float|string $consultantSubventionLimit
     * @return void
     */
    public function setConsultantSubventionLimit($consultantSubventionLimit): void
    {
        $this->consultantSubventionLimit = str_replace(',', '.', $consultantSubventionLimit);
    }


    /**
     * Returns the rkwFeePerDayAsLimit
     *
     * @return bool $rkwFeePerDayAsLimit
     */
    public function getRkwFeePerDayAsLimit(): bool
    {
        return $this->rkwFeePerDayAsLimit;
    }


    /**
     * Sets the rkwFeePerDayAsLimit
     *
     * @param int $rkwFeePerDayAsLimit
     * @return void
     */
    public function setRkwFeePerDayAsLimit(bool $rkwFeePerDayAsLimit): void
    {
        $this->rkwFeePerDayAsLimit = $rkwFeePerDayAsLimit;
    }


    /**
     * Returns the requestFields
     *
     * @return string $requestFields
     */
    public function getRequestFields(): string
    {
        return $this->requestFields;
    }


    /**
     * Sets the requestFields
     *
     * @param string $requestFields
     * @return void
     */
    public function setRequestFields(string $requestFields): void
    {
        $this->requestFields = $requestFields;
    }


    /**
     * Returns the mandatoryFields
     *
     * @return string $mandatoryFields
     */
    public function getMandatoryFields(): string
    {
        return $this->mandatoryFields;
    }


    /**
     * Sets the mandatoryFields
     *
     * @param string $mandatoryFields
     * @return void
     */
    public function setMandatoryFields(string $mandatoryFields): void
    {
        $this->mandatoryFields = $mandatoryFields;
    }

}
