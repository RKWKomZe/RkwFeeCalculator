<?php
namespace RKW\RkwFeecalculator\Utilities;
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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Backend\Utility\BackendUtility;

/**
 * TCA
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwFeecalculator
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class TCA
{

    public function supportRequestTitle(&$parameters)
    {
        $record = BackendUtility::getRecord($parameters['table'], $parameters['row']['uid']);
        $newTitle = ($record['name'] !== '') ? $record['name'] : $record['founder_name'];

        $objectManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $supportProgrammeRepository = $objectManager->get('RKW\\RkwFeecalculator\\Domain\\Repository\\ProgramRepository');

        $requestedProgram = $supportProgrammeRepository->findByUid($record['support_programme']);

        if ($requestedProgram) {
            $newTitle = $newTitle . ' [' . $requestedProgram->getName() . ']';
        }

        $parameters['title'] = $newTitle;
    }

}
