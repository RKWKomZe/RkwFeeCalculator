<?php
namespace RKW\RkwFeecalculator\Validation\Validator;

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

use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;

/**
 * Validator for empty/zero selections.
 *
 * @api
 */
class CustomSelectValidator extends AbstractValidator
{
    /**
     * Checks if the given value is a valid DateTime object. If this is not
     * the case, the function adds an error.
     *
     * @param mixed $value The value that should be validated
     * @return void
     */
    public function isValid($value)
    {

        if ($value > 0) {
            return;
        }

        $this->addError(
            $this->translateErrorMessage(
                'validator.selection.empty',
                'RkwFeecalculator',
                [
                    gettype($value)
                ]
            ), 1238087674, [gettype($value)]);
    }
}
