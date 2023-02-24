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

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Class Calculator
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwFeecalculator
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Calculator extends AbstractEntity
{

    /**
     * @var string
     */
    protected string $name = '';


    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwFeecalculator\Domain\Model\Program>|null
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected ?ObjectStorage $assignedPrograms = null;


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
     * Adds a Program
     *
     * @param Program $assignedProgram
     * @return void
     */
    public function addAssignedProgram(Program $assignedProgram): void
    {
        $this->assignedPrograms->attach($assignedProgram);
    }


    /**
     * Removes a Program
     *
     * @param Program $assignedProgramToRemove
     * @return void
     */
    public function removeAssignedProgram(Program $assignedProgramToRemove): void
    {
        $this->assignedPrograms->detach($assignedProgramToRemove);
    }


    /**
     * Returns the assignedPrograms
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwFeecalculator\Domain\Model\Program>
     */
    public function getAssignedPrograms(): ObjectStorage
    {
        return $this->assignedPrograms;
    }


    /**
     * Sets the assignedPrograms
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwFeecalculator\Domain\Model\Program> $assignedPrograms
     * @return void
     */
    public function setAssignedPrograms(ObjectStorage $assignedPrograms): void
    {
        $this->assignedPrograms = $assignedPrograms;
    }

}
