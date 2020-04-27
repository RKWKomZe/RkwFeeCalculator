<?php

namespace RKW\RkwFeecalculator\Helper;

use RKW\RkwBasics\Helper\Common;
use RKW\RkwFeecalculator\Domain\Model\FileReference;
use RKW\RkwFeecalculator\Domain\Repository\FileRepository;
use TYPO3\CMS\Core\Log\Logger;
use TYPO3\CMS\Core\Log\LogLevel;
use TYPO3\CMS\Core\Log\LogManager;
use TYPO3\CMS\Core\Resource\StorageRepository;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Object\ObjectManager;

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
 * Misc
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @author Christian Dilger <c.dilger@addorange.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwFeecalculator
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Misc implements SingletonInterface
{

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * createFileReference
     *
     * @param array $file
     * @param string $fieldName
     * @param object $ownerObject
     * @return void
     * @throws \TYPO3\CMS\Core\Resource\Exception\ExistingTargetFileNameException
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     */
    public function createFileReference($file, $fieldName, $ownerObject)
    {
        $settingsDefault = $this->getSettings();

        // file uploaden
        /** @var \TYPO3\CMS\Core\Resource\StorageRepository $storageRepository */
        $storageRepository = GeneralUtility::makeInstance(StorageRepository::class);

        /** @var \TYPO3\CMS\Core\Resource\ResourceStorage $storage */
        $storage = $storageRepository->findByUid($settingsDefault['sysFileStorageUid']);

        if ($storage) {

            $newFileObject = $storage->addFile($file['tmp_name'], $storage->getRootLevelFolder(), $file['name']);
            $newFileObject = $storage->getFile($newFileObject->getIdentifier());

            /** @var \RKW\RkwFeecalculator\Domain\Repository\FileRepository $fileRepository */
            $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
            $fileRepository = $objectManager->get(FileRepository::class);
            $newFile = $fileRepository->findByUid($newFileObject->getProperty('uid'));

            /** @var \RKW\RkwFeecalculator\Domain\Model\FileReference $newFileReference */
            $newFileReference = GeneralUtility::makeInstance(FileReference::class);
            $newFileReference->setFile($newFile);
            $newFileReference->setFieldname($fieldName);

            if ($fieldName == 'file') {
                $ownerObject->addFile($newFileReference);
            }

        } else {

            $this->getLogger()->log(
                LogLevel::INFO,
                sprintf('SysFileStorage not found or misconfigured in typoscript. Please define a correct storage uid for file uploads.')
            );
        }

    }

    /**
     * Returns TYPO3 settings
     *
     * @param string $which Which type of settings will be loaded
     * @return array
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     */
    public static function getSettings($which = ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS)
    {
        return Common::getTyposcriptConfiguration('Rkwfeecalculator', $which);
        //===
    }


    /**
     * Returns logger instance
     *
     * @return Logger
     */
    protected function getLogger()
    {
        if (!$this->logger instanceof Logger) {
            $this->logger = GeneralUtility::makeInstance(LogManager::class)->getLogger(__CLASS__);
        }

        return $this->logger;
        //===
    }

}
