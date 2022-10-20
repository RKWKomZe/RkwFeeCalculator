<?php
namespace RKW\RkwFeecalculator\ViewHelpers;
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
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * Class IsMandatoryFieldViewHelper
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwFeeCalculator
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class IsMandatoryFieldViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     * return TRUE, if the given fieldName is CONTAINED IN given mandatoryFields
     *
     * @param string $fieldName
     * @param string $mandatoryFields
     * @return bool
     */
    public function render($fieldName, $mandatoryFields)
    {
        $mandatoryFieldsArray = array_map(function($item) {
            return lcfirst(GeneralUtility::underscoredToUpperCamelCase(trim($item)));
        }, explode(',', $mandatoryFields));

        if (in_array($fieldName, $mandatoryFieldsArray, true)) {

            return true;
            //===
        }

        return false;
        //===
    }


}
