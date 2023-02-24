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

/**
 * Class IsMandatoryFieldViewHelper
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwFeeCalculator
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class IsMandatoryFieldViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     * Initialize arguments.
     *
     * @return void
     * @throws \TYPO3Fluid\Fluid\Core\ViewHelper\Exception
     */
    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument('fieldName', 'string', 'The current field name.', true);
        $this->registerArgument('mandatoryFields', 'string', 'The list of mandatory fields.', true);
    }


    /**
     * return true, if the given fieldName is CONTAINED IN given mandatoryFields
     *
     * @return bool
     */
    public function render(): bool
    {
        /** @var string $fieldName */
        $fieldName = $this->arguments['fieldName'];

        /** @var string $mandatoryFields */
        $mandatoryFields = $this->arguments['mandatoryFields'];

        $mandatoryFieldsArray = array_map(function($item) {
            return lcfirst(GeneralUtility::underscoredToUpperCamelCase(trim($item)));
        }, explode(',', $mandatoryFields));

        if (in_array($fieldName, $mandatoryFieldsArray, true)) {
            return true;
        }

        return false;
    }


}
