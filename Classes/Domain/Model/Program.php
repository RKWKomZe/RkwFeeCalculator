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
     * companyAge
     *
     * @var string
     * @validate NotEmpty
     */
    protected $companyAge = '';

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
     * conditions
     *
     * @var string
     * @validate NotEmpty
     */
    protected $conditions = '';

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
     * miscellaneous
     *
     * @var string
     */
    protected $miscellaneous = '';

    /**
     * institution
     *
     * @var \RKW\RkwFeecalculator\Domain\Model\Institution
     * @validate NotEmpty
     */
    protected $institution = null;

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
     * Returns the companyAge
     *
     * @return string $companyAge
     */
    public function getCompanyAge()
    {
        return $this->companyAge;
    }

    /**
     * Sets the companyAge
     *
     * @param string $companyAge
     * @return void
     */
    public function setCompanyAge($companyAge)
    {
        $this->companyAge = $companyAge;
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
     * Returns the conditions
     *
     * @return string $conditions
     */
    public function getConditions()
    {
        return $this->conditions;
    }

    /**
     * Sets the conditions
     *
     * @param string $conditions
     * @return void
     */
    public function setConditions($conditions)
    {
        $this->conditions = $conditions;
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
     * Returns the miscellaneous
     *
     * @return string $miscellaneous
     */
    public function getMiscellaneous()
    {
        return $this->miscellaneous;
    }

    /**
     * Sets the miscellaneous
     *
     * @param string $miscellaneous
     * @return void
     */
    public function setMiscellaneous($miscellaneous)
    {
        $this->miscellaneous = $miscellaneous;
    }

    /**
     * Returns the institution
     *
     * @return \RKW\RkwFeecalculator\Domain\Model\Institution $institution
     */
    public function getInstitution()
    {
        return $this->institution;
    }

    /**
     * Sets the institution
     *
     * @param \RKW\RkwFeecalculator\Domain\Model\Institution $institution
     * @return void
     */
    public function setInstitution(\RKW\RkwFeecalculator\Domain\Model\Institution $institution)
    {
        $this->institution = $institution;
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

}
