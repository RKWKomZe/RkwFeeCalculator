<?php

namespace RKW\RkwFeecalculator\Validation;

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
use TYPO3\CMS\Extbase\Error\Error;
use TYPO3\CMS\Extbase\Error\Result;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;

/**
 * Class CalculationValidator
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwFeeCalculator
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class CalculationValidator extends AbstractValidator
{

    /**
     * validation
     *
     * @return boolean
     * @var \RKW\RkwFeecalculator\Domain\Model\Calculation $objectSource
     */
    public function isValid($objectSource)
    {

        $this->result = new Result();

        $mandatoryFields = ['selectedProgram', 'days', 'consultantFeePerDay'];

        $isValid = true;

        if (!$objectSource->getSelectedProgram() || $objectSource->getSelectedProgram() !== $objectSource->getPreviousSelectedProgram()) {
            $objectSource->setPreviousSelectedProgram($objectSource->getSelectedProgram());
            $mandatoryFields = ['selectedProgram'];
        }

        if ($objectSource->getSelectedProgram()) {
            $possibleDaysMin = $objectSource->getSelectedProgram()->getPossibleDaysMin();
            $possibleDaysMax = $objectSource->getSelectedProgram()->getPossibleDaysMax();

            if (
                $possibleDaysMin > 0
                && $possibleDaysMax > 0
            ) {

                if ($possibleDaysMin > $objectSource->getDays()) {
                    $isValid = false;
                }

                if ($possibleDaysMax < $objectSource->getDays()) {
                    $isValid = false;
                }

            }
        }

        //  properties
        $requiredGetters = array_filter(get_class_methods($objectSource), static function ($method) use ($mandatoryFields) {
            return strpos($method, 'get') !== false && in_array(lcfirst(substr($method, 3)), $mandatoryFields, true);
        });

        foreach ($requiredGetters as $getter) {

            $property = lcfirst(substr($getter, 3));

            $field = LocalizationUtility::translate(
                'tx_rkwfeecalculator_domain_model_calculator.' . GeneralUtility::camelCaseToLowerCaseUnderscored($property),
                'rkw_feecalculator'
            );

            if ($getter === 'getConsultantFeePerDay') {
                $getter = 'getRawConsultantFeePerDay';
            }

            if (!trim($objectSource->$getter())) {
                $this->result->forProperty($property)->addError(
                    new Error(
                        LocalizationUtility::translate(
                            'validator.notempty.empty',
                            'rkw_feecalculator',
                            [$field]
                        ), 1449314603
                    )
                );
                $isValid = false;
            }

            if ($getter === 'getRawConsultantFeePerDay'
                && trim($objectSource->$getter()) !== ''
                && !preg_match('/^(\d+(?:[\.\,]\d{1,2})?)$/', $objectSource->$getter())
            ) {
                $this->result->forProperty(lcfirst(substr($getter, 3)))->addError(
                    new Error(
                        LocalizationUtility::translate(
                            'validator.number.notvalid',
                            'rkw_feecalculator',
                            [$field]
                        ), 1449314604
                    )
                );
                $isValid = false;
            }

        }

        if ($mandatoryFields !== ['selectedProgram']) {
            $objectSource->setShowResults($isValid);
        }

        return $isValid;
    }

}

