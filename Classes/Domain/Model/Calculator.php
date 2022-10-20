<?php

namespace RKW\RkwFeecalculator\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

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
class Calculator extends AbstractEntity
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
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $assignedPrograms;

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
        $this->assignedPrograms = new ObjectStorage();
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
     * @param Program $assignedProgram
     * @return void
     */
    public function addAssignedProgram(Program $assignedProgram)
    {
        $this->assignedPrograms->attach($assignedProgram);
    }

    /**
     * Removes a Program
     *
     * @param Program $assignedProgramToRemove
     * @return void
     */
    public function removeAssignedProgram(Program $assignedProgramToRemove)
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
    public function setAssignedPrograms(ObjectStorage $assignedPrograms)
    {
        $this->assignedPrograms = $assignedPrograms;
    }

}
