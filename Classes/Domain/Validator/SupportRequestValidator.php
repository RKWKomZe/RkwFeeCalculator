<?php
namespace RKW\RkwManagementConsultancy\Domain\Validator;

/**
 * Class SupportRequestValidator
 *
 * @package RKW\RkwManagementConsultancy\Domain\Validator
 */
class SupportRequestValidator extends \TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator
{

    protected $checkProperties = [];

    public function __construct(array $options = [])
    {
        parent::__construct($options);

        /** @todo pull these checkable properties from the support program config */
        $this->checkProperties = [
            'Thüringer Beratungsrichtlinie' => [

            ],
            'Thüringer Gründerrichtlinie' => [
                'citizenship',
                'birthdate',
                'foundationLocation'
            ]
            //  ...
        ];
    }

    /**
     * Validates a support request depending on chosen program
     *
     * @param \RKW\RkwManagementConsultancy\Domain\Model\SupportRequest $supportRequest
     * @return bool
     */
    protected function isValid($supportRequest)
    {

        $isValid = true;

        foreach($this->checkProperties[$supportRequest->getSupportProgramme()->getName()] as $property) {
            $getter = 'get' . $property;
            if ($supportRequest->$getter() === '') {
                $this->result->forProperty($property)
                    ->addError(
                        new \TYPO3\CMS\Extbase\Error\Error(
                            $this->translateErrorMessage(
                                'form.error.1221560718',
                                'RkwManagementConsultancy',
                                $this->getTranslationArguments($property)
                            ), 1238087674, $this->getTranslationArguments($property)
                        )
                    );

                $isValid = false;
            }

        };

        return $isValid;
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
                'RkwManagementConsultancy'
            )
        ];
    }
}
