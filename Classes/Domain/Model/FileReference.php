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
 * Class FileReference
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwFeecalculator
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class FileReference extends \TYPO3\CMS\Extbase\Domain\Model\FileReference
{

    /**
     * @var string
     */
    protected string $fieldname = '';


    /**
     * @var \RKW\RkwFeecalculator\Domain\Model\File|null
     */
    protected ?File $file = null;


    /**
     * Returns the fieldname
     *
     * @return string
     */
    public function getFieldname(): string
    {
        return $this->fieldname;
    }


    /**
     * Sets the fieldname
     *
     * @param string $fieldname
     * @return void
     */
    public function setFieldname(string $fieldname): void
    {
        $this->fieldname = $fieldname;
    }


    /**
     * Returns the uidLocal
     *
     * @return int
     */
    public function getUidLocal(): int
    {
        return $this->uidLocal;
    }


    /**
     * Sets the uidLocal
     *
     * @param int $uidLocal
     * @return void
     */
    public function setUidLocal(int $uidLocal): void
    {
        $this->uidLocal = $uidLocal;
    }


    /**
     * Set file
     *
     * @param \RKW\RkwFeecalculator\Domain\Model\File $file
     */
    public function setFile(File $file): void
    {
        $this->file = $file;
    }


    /**
     * Get file
     *
     * @return \RKW\RkwFeecalculator\Domain\Model\File
     */
    public function getFile():? File
    {
        return $this->file;
    }
}
