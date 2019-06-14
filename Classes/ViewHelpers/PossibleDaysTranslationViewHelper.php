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

/**
 * Class PossibleDaysTranslationViewHelper
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwFeeCalculator
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class PossibleDaysTranslationViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     * Calculates the fees
     *
     * @param \RKW\RkwFeecalculator\Domain\Model\Calculation $calculation
     */
    public function render(\RKW\RkwFeecalculator\Domain\Model\Calculation $calculation = null)
    {

        $output = '';

        if ($calculation->getSelectedProgram()->getPossibleDays()) {
            $output = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                'tx_rkwfeecalculator_domain_model_program.form.possible_days.value',
                'rkw_feecalculator',
                [$calculation->getSelectedProgram()->getPossibleDaysMin(), $calculation->getSelectedProgram()->getPossibleDaysMax()]
            );

            return $output;
        }

        $output = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
            'tx_rkwfeecalculator_domain_model_program.form.possible_days.value.unlimited',
            'rkw_feecalculator'
        );

        return $output;
    }

}
