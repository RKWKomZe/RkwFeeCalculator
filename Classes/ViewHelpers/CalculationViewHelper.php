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

use RKW\RkwFeecalculator\Domain\Model\Calculation;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Class CalculationViewHelper
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwFeeCalculator
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class CalculationViewHelper extends AbstractViewHelper
{

    /**
     * The output must not be escaped.
     *
     * @var bool
     */
    protected $escapeOutput = false;

    /**
     * Calculates the fees
     *
     * @param Calculation $calculation
     * @return mixed
     * @throws \TYPO3Fluid\Fluid\Core\Exception
     */
    public function render(Calculation $calculation = null)
    {
        $result[] = $this->calculate($calculation);

        $this->templateVariableContainer->add('calculationResult', $result);
        $output = $this->renderChildren();
        $this->templateVariableContainer->remove('calculationResult');

        return $output;
    }

    /**
     * @param Calculation $calculation
     * @return array
     */
    public function calculate(Calculation $calculation)
    {

        $result = [];

        $days = $calculation->getDays();
        $consultantFeePerDay = $calculation->getConsultantFeePerDay();
        $selectedProgram = $calculation->getSelectedProgram();
        $consultantFeePerDayLimit = $selectedProgram->getConsultantFeePerDayLimit();
        $consultantSubventionLimit = $selectedProgram->getConsultantSubventionLimit();

        if ($selectedProgram->getRkwFeePerDayAsLimit()) {
            $result['rkwFeePerDay'] = ($selectedProgram->getRkwFeePerDay() / $days);
        } else {
            $result['rkwFeePerDay'] = $selectedProgram->getRkwFeePerDay();
        }

        $result['rkwFee'] = $days * $result['rkwFeePerDay'];
        $result['consultantFee'] = $days * $consultantFeePerDay;
        $result['subtotalPerDay'] = $result['rkwFeePerDay'] + $consultantFeePerDay;
        $result['subtotal'] = $days * $result['subtotalPerDay'];
        $result['tax'] = $result['subtotal'] * 0.19;
        $result['total'] = $result['subtotal'] + $result['tax'];

        if ($consultantFeePerDayLimit > 0 && $consultantFeePerDay > $consultantFeePerDayLimit) {
            $result['consultantFeeSubvention'] = $days * $consultantFeePerDayLimit;
        } else if ($consultantSubventionLimit > 0 && $result['consultantFee'] > $consultantSubventionLimit) {
            $result['consultantFeeSubvention'] = $consultantSubventionLimit;
        } else {
            $result['consultantFeeSubvention'] = $result['consultantFee'];
        }

        $result['rkwFeeSubvention'] = $result['rkwFee'];
        $result['subventionSubtotal'] = $result['consultantFeeSubvention'] + $result['rkwFeeSubvention'];

        $result['subventionTotal'] = ($days * $selectedProgram->getStandardUnitCosts() > $result['subtotal']) ? $result['subtotal'] : $days * $selectedProgram->getStandardUnitCosts();

        $result['funding'] = $days * $selectedProgram->getStandardUnitCosts() * $selectedProgram->getFundingFactor();

        $result['ownFundingNet'] = $result['subtotal'] - $result['funding'];
        $result['ownFundingGross'] = $result['ownFundingNet'] + $result['tax'];
        $result['fundingPercentage'] = ($result['funding'] / ($result['subtotal'] * 0.01));

        return $result;

    }

}
