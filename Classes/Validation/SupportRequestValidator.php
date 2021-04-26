<?php

namespace RKW\RkwFeecalculator\Validation;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use RKW\RkwBasics\Validation\Validator\IbanValidator;
use RKW\RkwBasics\Validation\Validator\SwiftBicValidator;
use RKW\RkwFeecalculator\Validation\Validator\CustomDateValidator;

/**
 * Class SupportRequestValidator
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwFeeCalculator
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class SupportRequestValidator extends \TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator
{

    protected $objectManager;

    protected $validatorResolver;

    protected $reflectionService;

    protected $allowedMimeTypes = [
        'image/jpeg',
        'image/png',
        'application/pdf'
    ];

    public function __construct(array $options = [])
    {
        parent::__construct($options);

        /** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
        $this->objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Object\ObjectManager');
        $this->reflectionService = $this->objectManager->get(\TYPO3\CMS\Extbase\Reflection\ReflectionService::class);

        $this->validatorResolver = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Validation\\ValidatorResolver');

    }

    /**
     * Validates a support request depending on chosen program
     *
     * @param \RKW\RkwFeecalculator\Domain\Model\SupportRequest $supportRequest
     * @return bool
     */
    protected function isValid($supportRequest)
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
     * @param $property
     * @param $validator
     * @param $validation
     */
    protected function addErrors($property, $validator, $validation)
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
     * @param $property
     * @return array
     */
    protected function getTranslationArguments($property)
    {
        return [
            \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                'form.error.supportRequest.' . $property,
                'RkwFeecalculator'
            )
        ];
    }
}
