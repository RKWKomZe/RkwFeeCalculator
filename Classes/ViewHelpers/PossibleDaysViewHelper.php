<?php

namespace Rkw\RkwFeecalculator\ViewHelpers;

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

use TYPO3\CMS\Fluid\ViewHelpers\Form\SelectViewHelper;
use TYPO3\CMS\Fluid\ViewHelpers\Form\TextfieldViewHelper;

/**
 * Class PossibleDaysViewHelper
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwFeeCalculator
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class PossibleDaysViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     * Render the possible days
     *
     * @param \Rkw\RkwFeecalculator\Domain\Model\Calculation $calculation
     */
    public function render(\Rkw\RkwFeecalculator\Domain\Model\Calculation $calculation = null)
    {

        $possibleDays = $this->getPossibleDays($calculation);

        if ($possibleDays) {
            $output = new SelectViewHelper();
        } else {
            $output = new TextfieldViewHelper();
        }

        $output = $possibleDays;

        return $output;
    }

    /**
     * Get the possible days
     *
     * @param \Rkw\RkwFeecalculator\Domain\Model\Calculation $calculation
     */
    public function getPossibleDays(\Rkw\RkwFeecalculator\Domain\Model\Calculation $calculation = null)
    {
        return ($calculation->getSelectedProgram()) ? $calculation->getSelectedProgram()->getPossibleDays() : [];
    }

}
