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
use RKW\RkwBasics\Validation\Validator\IbanValidator;
use RKW\RkwBasics\Validation\Validator\SwiftBicValidator;
use RKW\RkwFeecalculator\Validation\Validator\CustomDateValidator;
use TYPO3\CMS\Extbase\Error\Result;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Validation\Validator\ValidatorInterface;
use TYPO3\CMS\Extbase\Validation\ValidatorResolver;
use TYPO3\CMS\Extbase\Reflection\ReflectionService;

/**
 * Class SupportRequestValidator
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwFeeCalculator
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class SupportRequestValidator extends \TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator
{

    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager|null
     */
    protected ?ObjectManager $objectManager = null;


    /**
     * @var \TYPO3\CMS\Extbase\Validation\ValidatorResolver|null
     */
    protected ?ValidatorResolver $validatorResolver = null;


    /**
     * @var \TYPO3\CMS\Extbase\Reflection\ReflectionService |null
     */
    protected ?ReflectionService $reflectionService = null;


    /**
     * @var string[]
     */
    protected $allowedMimeTypes = [
        'image/jpeg',
        'image/png',
        'application/pdf'
    ];


    /**
     * @param array $options
     * @return void
     * @throws \TYPO3\CMS\Extbase\Validation\Exception\InvalidValidationOptionsException
     */
    public function __construct(array $options = [])
    {
        parent::__construct($options);

        /** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
        $this->objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(ObjectManager::class);
        $this->reflectionService = $this->objectManager->get(ReflectionService::class);
        $this->validatorResolver = $this->objectManager->get(ValidatorResolver::class);

    }


    /**
     * Validates a support request depending on chosen program
     *
     * @param \RKW\RkwFeecalculator\Domain\Model\SupportRequest $supportRequest
     * @return bool
     */
    protected function isValid($supportRequest): bool
    {
        $isValid = true;

        $mandatoryFieldsArray = array_map(function($item) {
            return lcfirst(GeneralUtility::underscoredToUpperCamelCase(trim($item)));
        }, explode(',', $supportRequest->getSupportProgramme()->getMandatoryFields()));

        $requestFieldsArray = array_map(function($item) {
            return lcfirst(GeneralUtility::underscoredToUpperCamelCase(trim($item)));
        }, explode(',', $supportRequest->getSupportProgramme()->getRequestFields()));

        //  filter mandatoryFieldsArray to only contain requested fields
        $mandatoryFieldsArray = array_intersect($mandatoryFieldsArray, $requestFieldsArray);

        foreach($mandatoryFieldsArray as $property) {

            $getter = 'get' . ucfirst($property);
            if (method_exists($supportRequest, $getter)) {

                $propertyTagsValues = $this->reflectionService->getPropertyTagsValues(get_class($supportRequest), $property);
                if (isset($propertyTagsValues['validateOnObject'])) {

                    foreach ($propertyTagsValues['validateOnObject'] as $rules) {
                        foreach (GeneralUtility::trimExplode(',', $rules) as $rule) {

                            $validator = $this->validatorResolver->createValidator($rule);
                            $validation = $validator->validate($supportRequest->$getter());
                            if ($validation->hasErrors()) {
                                $this->addErrors($property, $validator, $validation);
                                $isValid = false;

                            }
                        }
                    }
                }
            }
        }

        if (method_exists($supportRequest, 'getPrivacy') && $supportRequest->getPrivacy() !== 1) {

            $this->result->forProperty('privacy')
                ->addError(
                    new \TYPO3\CMS\Extbase\Error\Error(
                        $this->translateErrorMessage(
                            'registrationController.error.accept_privacy',
                            'RkwRegistration',
                            $this->getTranslationArguments($property)
                        ), 1238087674, $this->getTranslationArguments($property)
                    )
                );

        }

        $uploads = array_filter($supportRequest->getFileUpload(), function ($upload) {
            return strlen($upload['name']) > 0;
        });

        foreach ($uploads as $upload) {

            if (! in_array($upload['type'], $this->allowedMimeTypes)) {

                $property = 'file';
                $this->result->forProperty('file')
                    ->addError(
                        new \TYPO3\CMS\Extbase\Error\Error(
                            $this->translateErrorMessage(
                                'form.error.supportRequest.file.mime',
                                'RkwFeecalculator'
                            ), 1238087674, $this->getTranslationArguments($property)
                        )
                    );

            }
        }

        return $isValid;
    }

    /**
     *
     * @param string $property
     * @param \TYPO3\CMS\Extbase\Validation\Validator\ValidatorInterface $validator
     * @param \TYPO3\CMS\Extbase\Error\Result $validation
     */
    protected function addErrors(string $property, ValidatorInterface $validator, Result $validation): void
    {
        if (
            $validator instanceof IbanValidator
            || $validator instanceof SwiftBicValidator
            || $validator instanceof CustomDateValidator
        ) {
            $this->result->forProperty($property)
                ->addError($validation->getFirstError());

        } else {

            $this->result->forProperty($property)
                ->addError(
                    new \TYPO3\CMS\Extbase\Error\Error(
                        $this->translateErrorMessage(
                            'form.error.1221560718',
                            'RkwFeecalculator',
                            $this->getTranslationArguments($property)
                        ), 1238087674, $this->getTranslationArguments($property)
                    )
                );
        }
    }


    /**
     * @param string $property
     * @return array
     */
    protected function getTranslationArguments(string $property): array
    {
        return [
            \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                'form.error.supportRequest.' . $property,
                'RkwFeecalculator'
            )
        ];
    }
}
