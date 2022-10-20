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

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Class UploadLabelViewHelper
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwFeeCalculator
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class UploadLabelViewHelper extends AbstractViewHelper
{

    /**
     * Return labels for file upload field
     *
     * return array
     */
    public function render()
    {
        return [
            'data-jcf' => json_encode([
                'buttonText' => LocalizationUtility::translate(
                    'tx_rkwfeecalculator_domain_model_supportrequest.general.upload.button.label',
                    'RkwFeecalculator'
                ),
                'placeholderText' => LocalizationUtility::translate(
                    'tx_rkwfeecalculator_domain_model_supportrequest.general.upload.placeholder',
                    'RkwFeecalculator'
                ),
            ])
        ];
    }

}
