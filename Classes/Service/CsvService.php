<?php

namespace RKW\RkwFeecalculator\Service;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use RKW\RkwBasics\Domain\Model\CompanyType;
use RKW\RkwFeecalculator\Domain\Model\Consulting;
use RKW\RkwFeecalculator\Domain\Model\SupportRequest;

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
 * CsvService
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwFeecalculator
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class CsvService extends DocumentService
{
    /**
     * action csv
     * because extbase makes some trouble if some survey has a starttime in future, ist disabled or something, just give the uid
     *
     * @param \RKW\RkwFeecalculator\Domain\Model\SupportRequest $supportRequest
     * @return void
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function createCsv(SupportRequest $supportRequest)
    {
        $fileName = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
            'tx_rkwfeecalculator_domain_model_supportrequest',
            'RkwFeecalculator'
        );

        $attachmentName = $fileName . '-' . date('Y-m-d-Hi') . '.csv';

        $path = $this->getOutputPath($attachmentName);

        $separator = ';';
        $csv = fopen($path, 'w');

        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=$attachmentName");
        header("Pragma: no-cache");

        // properties aka headings
        $properties = array_filter(
            array_map(function($item) {
                if ($item !== 'file') {
                    return lcfirst(GeneralUtility::underscoredToUpperCamelCase(trim($item)));
                }
            }, explode(',', $supportRequest->getSupportProgramme()->getRequestFields()))
        );

        $headings = [];
        foreach ($properties as $property) {
            $headings[] = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                'tx_rkwfeecalculator_domain_model_supportrequest.' . $property,
                'RkwFeecalculator'
            );
        }

        // set headings
        fputcsv($csv, $headings, $separator);

        //  get content
        $row =[];
        foreach ($properties as $property) {
            $getter = 'get' . ucfirst($property);

            $row[$property] = $supportRequest->$getter();

            if ($supportRequest->$getter() instanceof CompanyType) {
                $row[$property] = $supportRequest->$getter()->getName();
            }

            if ($supportRequest->$getter() instanceof Consulting) {
                $row[$property] = $supportRequest->$getter()->getTitle();
            }

        }

        fputcsv($csv, $row, $separator);

        fclose($csv);

        return [
            'path' => $path,
            'type' => 'text/csv',
            'name' => $attachmentName,
        ];

        //===
    }

}
