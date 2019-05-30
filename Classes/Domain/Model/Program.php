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
 * Program
 */
class Program extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * name
     *
     * @var string
     * @validate NotEmpty
     */
    protected $name = '';

    /**
     * responsibleInstitution
     *
     * @var int
     * @validate NotEmpty
     */
    protected $responsibleInstitution = 0;

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
     * @validate NotEmpty
     */
    protected $possibleDaysMin = 0;

    /**
     * possibleDaysMax
     *
     * @var int
     * @validate NotEmpty
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
     * @var int
     * @validate NotEmpty
     */
    protected $rkwFeePerDay = 0;

    /**
     * miscellaneous
     *
     * @var string
     */
    protected $miscellaneous = '';

    /**
     * institution
     *
     * @var \Rkw\RkwFeecalculator\Domain\Model\Institution
     */
    protected $institution = null;

    /**
     * formula
     *
     * @var string
     */
    protected $formula = '';

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
     * Returns the responsibleInstitution
     *
     * @return int $responsibleInstitution
     */
    public function getResponsibleInstitution()
    {
        return $this->responsibleInstitution;
    }

    /**
     * Sets the responsibleInstitution
     *
     * @param int $responsibleInstitution
     * @return void
     */
    public function setResponsibleInstitution($responsibleInstitution)
    {
        $this->responsibleInstitution = $responsibleInstitution;
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
     * @param int $rkwFeePerDay
     * @return void
     */
    public function setRkwFeePerDay($rkwFeePerDay)
    {
        $this->rkwFeePerDay = $rkwFeePerDay;
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
     * @return \Rkw\RkwFeecalculator\Domain\Model\Institution $institution
     */
    public function getInstitution()
    {
        return $this->institution;
    }

    /**
     * Sets the institution
     *
     * @param \Rkw\RkwFeecalculator\Domain\Model\Institution $institution
     * @return void
     */
    public function setInstitution(\Rkw\RkwFeecalculator\Domain\Model\Institution $institution)
    {
        $this->institution = $institution;
    }

    /**
     * Returns the formula
     *
     * @return string $formula
     */
    public function getFormula()
    {
        return $this->formula;
    }

    /**
     * Sets the formula
     *
     * @param string $formula
     * @return void
     */
    public function setFormula($formula)
    {
        $this->formula = $formula;
    }
}
