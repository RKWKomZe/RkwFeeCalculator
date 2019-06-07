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

/**
 * Class CalculationViewHelper
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwFeeCalculator
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class CalculationViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     * Calculates the fees
     *
     * @param \Rkw\RkwFeecalculator\Domain\Model\Calculation $calculation
     */
    public function render(\Rkw\RkwFeecalculator\Domain\Model\Calculation $calculation = null)
    {
        $result[] = $this->calculate($calculation);

        $this->templateVariableContainer->add('calculationResult', $result);
        $output = $this->renderChildren();
        $this->templateVariableContainer->remove('calculationResult');

        return $output;
    }

    /**
     * @param \Rkw\RkwFeecalculator\Domain\Model\Calculation $calculation
     */
    public function calculate(\Rkw\RkwFeecalculator\Domain\Model\Calculation $calculation)
    {

        $result = [];

        $days = $calculation->getDays();
        $consultantFeePerDay = $calculation->getConsultantFeePerDay();
        $selectedProgram = $calculation->getSelectedProgram();

        $result['rkwFee'] = $days * $selectedProgram->getRkwFeePerDay();
        $result['consultantFee'] = $days * $consultantFeePerDay;
        $result['subtotalPerDay'] = $selectedProgram->getRkwFeePerDay() + $consultantFeePerDay;
        $result['subtotal'] = $days * $result['subtotalPerDay'];
        $result['tax'] = $result['subtotal'] * 0.19;
        $result['total'] = $result['subtotal'] + $result['tax'];

        if ($selectedProgram->getConsultantFeePerDayLimit() > 0 && $consultantFeePerDay > $selectedProgram->getConsultantFeePerDayLimit()) {
            $result['consultantFeeSubvention'] = $days * $selectedProgram->getConsultantFeePerDayLimit();
        } else {
            $result['consultantFeeSubvention'] = $result['consultantFee'];
        }

        $result['rkwFeeSubvention'] = $result['rkwFee'];
        $result['subventionSubtotal'] = $result['consultantFeeSubvention'] + $result['rkwFeeSubvention'];
        $result['subventionTotal'] = $result['subventionSubtotal'];

        $result['funding'] = $result['subventionTotal'] * $selectedProgram->getFundingFactor();
        $result['ownFundingNet'] = $result['subtotal'] - $result['funding'];
        $result['ownFundingGross'] = $result['ownFundingNet'] + $result['tax'];
        $result['fundingPercentage'] = ($result['funding'] / ($result['subtotal'] * 0.01));

        return $result;

    }


}
