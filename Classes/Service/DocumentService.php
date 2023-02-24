<?php
namespace RKW\RkwFeecalculator\Service;

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

use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * DocumentService
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwFeecalculator
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class DocumentService implements \TYPO3\CMS\Core\SingletonInterface
{

    /**
     * @var string
     */
    protected string $defaultUploadFolder = '1:/user_upload/tx_rkwfeecalculator';


    /**
     * @var \TYPO3\CMS\Core\Resource\ResourceFactory|null
     */
    protected ?ResourceFactory $resourceFactory = null;


    /**
     * @var string
     */
    protected string $outputPath = '';


    /**
     * @return void
     */
    public function __construct()
    {
        /** @var \TYPO3\CMS\Core\Resource\ResourceFactory $resourceFactory */
        $this->resourceFactory = GeneralUtility::makeInstance(ResourceFactory::class);
    }


    /**
     * @param string $fileName
     * @return string
     *  @todo this is not the right way. To get the main storage folder, please use the storages used in BE
     */
    protected function getOutputPath(string $fileName): string
    {
        $uploadFolder = $this->resourceFactory->retrieveFileOrFolderObject($this->defaultUploadFolder);
        $fileAdminPath = GeneralUtility::getFileAbsFileName('fileadmin');

        return $fileAdminPath . $uploadFolder->getReadablePath() . '/' . $fileName;
    }

}
