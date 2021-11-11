<?php

namespace RKW\RkwFeecalculator\Service;

use TYPO3\CMS\Core\Resource\ResourceFactory;

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
 * DocumentService
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwFeecalculator
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class DocumentService implements \TYPO3\CMS\Core\SingletonInterface
{

    /**
     * @var string
     */
    protected $defaultUploadFolder = '1:/user_upload/tx_rkwfeecalculator';

    /**
     * @var \TYPO3\CMS\Core\Resource\ResourceFactory
     */
    protected $resourceFactory;

    /**
     * @var string
     */
    protected $outputPath;

    public function __construct()
    {
        /** @var \TYPO3\CMS\Core\Resource\ResourceFactory $resourceFactory */
        $this->resourceFactory = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(ResourceFactory::class);
    }

    protected function getOutputPath(string $fileName)
    {
        $uploadFolder = $this->resourceFactory->retrieveFileOrFolderObject($this->defaultUploadFolder);
        $fileAdminPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName('fileadmin');

        return $fileAdminPath . $uploadFolder->getReadablePath() . '/' . $fileName;
    }

}