<?php

namespace RKW\RkwGraphs\ViewHelpers;

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

/**
 * Class JsArrayViewHelper
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwGraphs
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class JsArrayViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     * Parses strings to arrays
     *
     * @param string $data
     * @param string $delimiter
     * @param bool $checkFloat
     * @return integer
     */
    public function render($data, $delimiter = '|', $checkFloat = false)
    {

        $parsedData = [];
        $strings = GeneralUtility::trimExplode($delimiter, $data, true);
        foreach ($strings as $string) {
            if ($checkFloat) {
                $parsedData[] = floatval(str_replace(',', '.', $string));
            } else {
                $parsedData[] = addslashes($string);
            }
        }

        if (count($parsedData) < 1) {
            $parsedData = [];
            //===
        }

        return json_encode($parsedData, JSON_NUMERIC_CHECK);
        //===
    }

}
