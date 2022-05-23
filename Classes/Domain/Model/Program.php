<?php

namespace RKW\RkwFeecalculator\Domain\Model;

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
 * Program
 */
class Program extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * name
     *
     * @var string
     * @validate StringLength(minimum=3, maximum=100)
     */
    protected $name = '';

    /**
     * possibleDaysMin
     *
     * @var int
     * @validate Integer
     */
    protected $possibleDaysMin = 0;

    /**
     * possibleDaysMax
     *
     * @var int
     * @validate Integer
     */
    protected $possibleDaysMax = 0;

    /**
     * content
     *
     * @var string
     * @validate NotEmpty
     */
    protected $content = '';

    /**
     * rkwFeePerDay
     *
     * @var double
     * @validate Float
     */
    protected $rkwFeePerDay = 0.00;

    /**
     * consultantFeePerDayLimit
     *
     * @var double
     * @validate Float
     */
    protected $consultantFeePerDayLimit = 0.00;

    /**
     * consultantSubventionLimit
     *
     * @var double
     * @validate Float
     */
    protected $consultantSubventionLimit = 0.00;

    /**
     *
     * @var boolean
     */
    protected $rkwFeePerDayAsLimit = false;

    /**
     * fundingFactor
     *
     * @var double
     * @validate Float
     */
    protected $fundingFactor = 1.00;

    /**
     * standardUnitCosts
     *
     * @var double
     * @validate Float
     */
    protected $standardUnitCosts = 0.00;

    /**
     * consulting
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwFeecalculator\Domain\Model\Consulting>
     */
    protected $consulting = null;

    /**
     * requestFields
     *
     * @var string
     */
    protected $requestFields = '';

    /**
     * mandatoryFields
     *
     * @var string
     */
    protected $mandatoryFields = '';

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
     * Returns the possibleDaysMin
     *
     * @return int $possibleDaysMin
     */
    public function getPossibleDaysMin()
    {
        return $this->possibleDaysMin;
    }

    /**
     * Sets the possibleDaysMin
     *
     * @param int $possibleDaysMin
     * @return void
     */
    public function setPossibleDaysMin($possibleDaysMin)
    {
        $this->possibleDaysMin = $possibleDaysMin;
    }

    /**
     * Returns the possibleDaysMax
     *
     * @return int $possibleDaysMax
     */
    public function getPossibleDaysMax()
    {
        return $this->possibleDaysMax;
    }

    /**
     * Sets the possibleDaysMax
     *
     * @param int $possibleDaysMax
     * @return void
     */
    public function setPossibleDaysMax($possibleDaysMax)
    {
        $this->possibleDaysMax = $possibleDaysMax;
    }

    /**
     * Returns the possibleDays (min <-> max) as array
     *
     * @return array $possibleDays
     */
    public function getPossibleDays()
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
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Sets the content
     *
     * @param string $content
     * @return void
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * Returns the rkwFeePerDay
     *
     * @return int $rkwFeePerDay
     */
    public function getRkwFeePerDay()
    {
        return $this->rkwFeePerDay;
    }

    /**
     * Sets the rkwFeePerDay
     *
     * @param double $rkwFeePerDay
     * @return void
     */
    public function setRkwFeePerDay($rkwFeePerDay)
    {
        $this->rkwFeePerDay = str_replace(',', '.', $rkwFeePerDay);
    }

    /**
     * Returns the fundingFactor
     *
     * @return float $fundingFactor
     */
    public function getFundingFactor()
    {
        return $this->fundingFactor;
    }

    /**
     * Sets the fundingFactor
     *
     * @param float $fundingFactor
     * @return void
     */
    public function setFundingFactor($fundingFactor)
    {
        $this->fundingFactor = $fundingFactor;
    }

    /**
     * Returns the standardUnitCosts
     *
     * @return float $standardUnitCosts
     */
    public function getStandardUnitCosts()
    {
        return $this->standardUnitCosts;
    }

    /**
     * Sets the standardUnitCosts
     *
     * @param float $standardUnitCosts
     * @return void
     */
    public function setStandardUnitCosts($standardUnitCosts)
    {
        $this->standardUnitCosts = $standardUnitCosts;
    }

    /**
     * Adds a Consulting
     *
     * @param \RKW\RkwFeecalculator\Domain\Model\Consulting $consulting
     * @return void
     */
    public function addConsulting(\RKW\RkwFeecalculator\Domain\Model\Consulting $consulting)
    {
        $this->consulting->attach($consulting);
    }

    /**
     * Removes a Consulting
     *
     * @param \RKW\RkwFeecalculator\Domain\Model\Consulting $consultingToRemove The Consulting to be removed
     * @return void
     */
    public function removeConsulting(\RKW\RkwFeecalculator\Domain\Model\Consulting $consultingToRemove)
    {
        $this->consulting->detach($consultingToRemove);
    }

    /**
     * Returns the consulting
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwFeecalculator\Domain\Model\Consulting> $consulting
     */
    public function getConsulting()
    {
        return $this->consulting;
    }

    /**
     * Sets the consulting
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwFeecalculator\Domain\Model\Consulting> $consulting
     * @return void
     */
    public function setConsulting(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $consulting)
    {
        $this->consulting = $consulting;
    }

    /**
     * Returns the consultantFeePerDayLimit
     *
     * @return int $consultantFeePerDayLimit
     */
    public function getConsultantFeePerDayLimit()
    {
        return $this->consultantFeePerDayLimit;
    }

    /**
     * Sets the consultantFeePerDayLimit
     *
     * @param int $consultantFeePerDayLimit
     * @return void
     */
    public function setConsultantFeePerDayLimit($consultantFeePerDayLimit)
    {
        $this->consultantFeePerDayLimit = str_replace(',', '.', $consultantFeePerDayLimit);
    }

    /**
     * Returns the consultantSubventionLimit
     *
     * @return int $consultantSubventionLimit
     */
    public function getConsultantSubventionLimit()
    {
        return $this->consultantSubventionLimit;
    }

    /**
     * Sets the consultantSubventionLimit
     *
     * @param int $consultantSubventionLimit
     * @return void
     */
    public function setConsultantSubventionLimit($consultantSubventionLimit)
    {
        $this->consultantSubventionLimit = str_replace(',', '.', $consultantSubventionLimit);
    }

    /**
     * Returns the rkwFeePerDayAsLimit
     *
     * @return int $rkwFeePerDayAsLimit
     */
    public function getRkwFeePerDayAsLimit()
    {
        return $this->rkwFeePerDayAsLimit;
    }

    /**
     * Sets the rkwFeePerDayAsLimit
     *
     * @param int $rkwFeePerDayAsLimit
     * @return void
     */
    public function setRkwFeePerDayAsLimit($rkwFeePerDayAsLimit)
    {
        $this->rkwFeePerDayAsLimit = $rkwFeePerDayAsLimit;
    }

    /**
     * Returns the requestFields
     *
     * @return string $requestFields
     */
    public function getRequestFields()
    {
        return $this->requestFields;
    }

    /**
     * Sets the requestFields
     *
     * @param string $requestFields
     * @return void
     */
    public function setRequestFields($requestFields)
    {
        $this->requestFields = $requestFields;
    }

    /**
     * Returns the mandatoryFields
     *
     * @return string $mandatoryFields
     */
    public function getMandatoryFields()
    {
        return $this->mandatoryFields;
    }

    /**
     * Sets the mandatoryFields
     *
     * @param string $mandatoryFields
     * @return void
     */
    public function setMandatoryFields($mandatoryFields)
    {
        $this->mandatoryFields = $mandatoryFields;
    }

}
