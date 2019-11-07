<?php
namespace RKW\RkwFeecalculator\Domain\Validator;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use RKW\RkwFeecalculator\Validation\Validator\IbanValidator;
use RKW\RkwFeecalculator\Validation\Validator\CustomDateValidator;

/**
 * Class SupportRequestValidator
 *
 * @package RKW\RkwFeecalculator\Domain\Validator
 */
class SupportRequestValidator extends \TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator
{

    protected $checkProperties = [];

    protected $objectManager;

    protected $validatorResolver;

    protected $reflectionService;

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

        $requestFieldsArray = array_map(function($item) {
            return lcfirst(GeneralUtility::underscoredToUpperCamelCase(trim($item)));
        }, explode(',', $supportRequest->getSupportProgramme()->getMandatoryFields()));

        foreach($requestFieldsArray as $property) {
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

        return $isValid;
    }

    /**
     * @param $property
     * @param $validator
     * @param $validation
     */
    protected function addErrors($property, $validator, $validation)
    {
        if ($validator instanceof IbanValidator
            || $validator instanceof CustomDateValidator) {
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
                'form.error.newSupportRequest.' . $property,
                'RkwFeecalculator'
            )
        ];
    }
}
