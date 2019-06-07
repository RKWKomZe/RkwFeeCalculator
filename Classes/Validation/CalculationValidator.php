<?php

namespace Rkw\RkwFeecalculator\Validation;

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

use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * Class CalculationValidator
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwFeeCalculator
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class CalculationValidator extends \TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator
{
    /**
     * validation
     *
     * @var mixed $objectSource
     * @return boolean
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     */
    public function isValid($objectSource)
    {
        $isValid = true;

//        if (! $objectSource->getConsultantFeePerDay()) {
//            $this->result->forProperty('consultantFeePerDay')->addError(
//                new \TYPO3\CMS\Extbase\Error\Error(
//                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
//                        'registrationController.error.accept_privacy',
//                        'rkw_registration'
//                    ), 1526904113
//                )
//            );
//            $isValid = false;
//        }

        /*

        // get required fields
        $settingsDefault = Misc::getSettings();

        $mandatoryFields = $settingsDefault['mandatoryFields'];

        // transform mandatoryFields to array
        $requiredFields = array();
        foreach ($mandatoryFields as $key => $fields) {
            if (!is_array($fields) && $fields) {

                foreach (explode(',', $fields) as $field) {

                    $requiredFields[$key][] = trim($field);
                }
            }
        }

        // properties
        if ($methods = get_class_methods($objectSource)) {

            foreach ($methods as $getter) {

                if (strpos($getter, 'get') === 0) {

                    // if required fields are set
                    if ($requiredFields['consultant']) {

                        if (in_array(lcfirst(substr($getter, 3)), $requiredFields['consultant'])) {

                            if (!trim($objectSource->$getter())) {

                                $this->result->forProperty(lcfirst(substr($getter, 3)))->addError(
                                    new \TYPO3\CMS\Extbase\Error\Error(
                                        \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                                            'validator.not_filled',
                                            'rkw_consultant'
                                        ), 1449314603
                                    )
                                );
                                $isValid = false;
                            }
                        }
                    }
                }
            }
        }
        */

        return $isValid;
        //===
    }

}

