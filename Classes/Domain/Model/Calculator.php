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
     * assignedPrograms
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwFeecalculator\Domain\Model\Program>
     * @cascade remove
     */
    protected $assignedPrograms = null;

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
     * Adds a Program
     *
     * @param \RKW\RkwFeecalculator\Domain\Model\Program $assignedProgram
     * @return void
     */
    public function addAssignedProgram(\RKW\RkwFeecalculator\Domain\Model\Program $assignedProgram)
    {
        $this->assignedPrograms->attach($assignedProgram);
    }

    /**
     * Removes a Program
     *
     * @param \RKW\RkwFeecalculator\Domain\Model\Program $assignedProgramToRemove The Program to be removed
     * @return void
     */
    public function removeAssignedProgram(\RKW\RkwFeecalculator\Domain\Model\Program $assignedProgramToRemove)
    {
        $this->assignedPrograms->detach($assignedProgramToRemove);
    }

    /**
     * Returns the assignedPrograms
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwFeecalculator\Domain\Model\Program> assignedPrograms
     */
    public function getAssignedPrograms()
    {
        return $this->assignedPrograms;
    }

    /**
     * Sets the assignedPrograms
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwFeecalculator\Domain\Model\Program> $assignedPrograms
     * @return void
     */
    public function setAssignedPrograms(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $assignedPrograms)
    {
        $this->assignedPrograms = $assignedPrograms;
    }

}
