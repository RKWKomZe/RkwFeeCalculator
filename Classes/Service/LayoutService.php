<?php

namespace RKW\RkwFeecalculator\Service;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use RKW\RkwFeecalculator\ViewHelpers\PossibleDaysViewHelper;

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
 * LayoutService
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwFeecalculator
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class LayoutService implements \TYPO3\CMS\Core\SingletonInterface
{

    /**
     * @var string
     */
    protected $fieldWidth = 'full';

    /**
     * @var \RKW\RkwFeecalculator\Domain\Model\Program
     */
    protected $supportProgramme;

    /**
     * companytypeRepository
     *
     * @var \RKW\RkwBasics\Domain\Repository\CompanyTypeRepository
     * @inject
     */
    protected $companytypeRepository = null;

    protected $companytypeList;

    public function getFields(\RKW\RkwFeecalculator\Domain\Model\Program $supportProgramme)
    {

        $this->supportProgramme = $supportProgramme;
        $this->companytypeList = $this->companytypeRepository->findAll();

        $requestFieldsArray = array_map(function($item) {
            return lcfirst(GeneralUtility::underscoredToUpperCamelCase(trim($item)));
        }, explode(',', $supportProgramme->getRequestFields()));

        $fieldsets = $this->getFieldsConfig();

        return $this->getFieldsLayout($this->filterFieldsets($fieldsets, $requestFieldsArray));

    }

    /**
     * Provide fields layout helpers
     *
     * @param $fieldsets
     *
     * @return mixed
     */
    protected function getFieldsLayout($fieldsets)
    {
        foreach ($fieldsets as $key => $fieldset) {

            foreach ($fieldset as $fieldKey => $field) {

                if ($this->fieldWidth === 'full' || $this->fieldWidth === '2-2' || $field['width'] === 'new') {
                    $field['width'] = (isset($field['width'])) ? $field['width'] : '1-2';
                }

                if ($this->fieldWidth === '1-2' && $field['width'] !== 'full' && $field['width'] !== 'new') {
                    $field['width'] = '2-2';
                }

                if ($field['width'] === 'new') {
                    $field['width'] = '1-2';
                }

                $this->fieldWidth = $field['width'];

                $fieldsets[$key][$fieldKey] = $field;

            }

            $this->fieldWidth = 'full';

        }

        return $fieldsets;
    }

    protected function getFieldsConfig()
    {
        return [
            'applicant' => [
                'name' => [
                    'type' => 'text',
                ],
                'founderName' => [
                    'type' => 'text',
                ],
                'address' => [
                    'type' => 'text',
                ],
                'zip' => [
                    'type' => 'text',
                ],
                'city' => [
                    'type' => 'text',
                ],
                'foundationDate' => [
                    'type' => 'date',
                ],
                'intendedFoundationDate' => [
                    'type' => 'date',
                ],
                'companytype' => [
                    'type' => 'select',
                    'options' => $this->companytypeList,
                    'optionValueField' => 'uid',
                    'optionLabelField' => 'name',
                ],
                'citizenship' => [
                    'type' => 'text',
                ],
                'birthdate' => [
                    'type' => 'date',
                ],
                'foundationLocation' => [
                    'type' => 'text',
                ],
                'balance' => [
                    'type' => 'text',
                ],
                'sales' => [
                    'type' => 'text',
                ],
                'employeesCount' => [
                    'type' => 'text',
                ],
                'manager' => [
                    'type' => 'text',
                    'width' => 'full',
                ],
                'singleRepresentative' => [
                    'type' => 'radio',
                    'options' => [
                        [
                            'value' => 1,
                            'label' => LocalizationUtility::translate(
                                'tx_rkwfeecalculator_domain_model_supportrequest.singleRepresentative.1',
                                'RkwFeecalculator'
                            ),
                        ],
                        [
                            'value' => 99,
                            'label' => LocalizationUtility::translate(
                                'tx_rkwfeecalculator_domain_model_supportrequest.singleRepresentative.99',
                                'RkwFeecalculator'
                            ),
                        ]
                    ]
                ],
                'preTaxDeduction' => [
                    'type' => 'radio',
                    'options' => [
                        [
                            'value' => 1,
                            'label' => LocalizationUtility::translate(
                                'tx_rkwfeecalculator_domain_model_supportrequest.preTaxDeduction.1',
                                'RkwFeecalculator'
                            ),
                        ],
                        [
                            'value' => 99,
                            'label' => LocalizationUtility::translate(
                                'tx_rkwfeecalculator_domain_model_supportrequest.preTaxDeduction.99',
                                'RkwFeecalculator'
                            ),
                        ]
                    ]
                ],
                'businessPurpose' => [
                    'type' => 'textarea',
                    'width' => 'full',
                ],
                'insolvencyProceedings' => [
                    'type' => 'radio',
                    'width' => 'full',
                    'options' => [
                        [
                            'value' => 1,
                            'label' => LocalizationUtility::translate(
                                'tx_rkwfeecalculator_domain_model_supportrequest.insolvencyProceedings.1',
                                'RkwFeecalculator'
                            ),
                        ],
                        [
                            'value' => 99,
                            'label' => LocalizationUtility::translate(
                                'tx_rkwfeecalculator_domain_model_supportrequest.insolvencyProceedings.99',
                                'RkwFeecalculator'
                            ),
                        ]
                    ],
                ],
                'chamber' => [
                    'type' => 'select',
                    'width' => 'full',
                    'options' => [
                        1 => LocalizationUtility::translate(
                            'tx_rkwfeecalculator_domain_model_supportrequest.chamber.1',
                            'RkwFeecalculator'
                        ),
                        2 => LocalizationUtility::translate(
                            'tx_rkwfeecalculator_domain_model_supportrequest.chamber.2',
                            'RkwFeecalculator'
                        ),
                        3 => LocalizationUtility::translate(
                            'tx_rkwfeecalculator_domain_model_supportrequest.chamber.3',
                            'RkwFeecalculator'
                        ),
                    ],
                ],
                'companyShares' => [
                    'type' => 'textarea',
                    'width' => 'full',
                ],
                'principalBank' => [
                    'type' => 'text',
                    'width' => 'full',
                ],
                'bic' => [
                    'type' => 'text',
                ],
                'iban' => [
                    'type' => 'text',
                ],
                'contactPersonName' => [
                    'type' => 'text',
                    'width' => 'full',
                ],
                'contactPersonPhone' => [
                    'type' => 'text',
                ],
                'contactPersonFax' => [
                    'type' => 'text',
                ],
                'contactPersonMobile' => [
                    'type' => 'text',
                ],
                'contactPersonEmail' => [
                    'type' => 'text',
                ],
                'preFoundationEmployment' => [
                    'type' => 'select',
                    'options' => [
                        1 => LocalizationUtility::translate(
                            'tx_rkwfeecalculator_domain_model_supportrequest.preFoundationEmployment.employed',
                            'RkwFeecalculator'
                        ),
                        2 => LocalizationUtility::translate(
                            'tx_rkwfeecalculator_domain_model_supportrequest.preFoundationEmployment.self_employed',
                            'RkwFeecalculator'
                        ),
                        3 => LocalizationUtility::translate(
                            'tx_rkwfeecalculator_domain_model_supportrequest.preFoundationEmployment.in_education',
                            'RkwFeecalculator'
                        ),
                        4 => LocalizationUtility::translate(
                            'tx_rkwfeecalculator_domain_model_supportrequest.preFoundationEmployment.unemployed',
                            'RkwFeecalculator'
                        ),
                    ],
                ],
                'preFoundationSelfEmployment' => [
                    'type' => 'select',
                    'options' => [
                        1 => LocalizationUtility::translate(
                            'tx_rkwfeecalculator_domain_model_supportrequest.preFoundationSelfEmployment.no',
                            'RkwFeecalculator'
                        ),
                        2 => LocalizationUtility::translate(
                            'tx_rkwfeecalculator_domain_model_supportrequest.preFoundationSelfEmployment.part_time',
                            'RkwFeecalculator'
                        ),
                        3 => LocalizationUtility::translate(
                            'tx_rkwfeecalculator_domain_model_supportrequest.preFoundationSelfEmployment.full_time',
                            'RkwFeecalculator'
                        ),
                        4 => LocalizationUtility::translate(
                            'tx_rkwfeecalculator_domain_model_supportrequest.preFoundationSelfEmployment.shareholder',
                            'RkwFeecalculator'
                        ),
                    ],
                ],
            ],
            'consulting' => [
                'consulting' => [
                    'type' => 'select',
                    'width' => 'full',
                    'options' => $this->supportProgramme->getConsulting(),
                    'optionValueField' => 'uid',
                    'optionLabelField' => 'title'
                ],
                'consultingDays' => [
                    'type' => 'select',
                    'options' => (new PossibleDaysViewHelper())->render($this->supportProgramme),
                ],
                'consultingDateFrom' => [
                    'type' => 'text',
                    'width' => 'new',   //  force new line
                ],
                'consultingDateTo' => [
                    'type' => 'text',
                ],
                'consultingContent' => [
                    'type' => 'textarea',
                    'width' => 'full',
                ],
                'consultantType' => [
                    'type' => 'select',
                    'width' => 'full',
                    'options' => [
                        1 => LocalizationUtility::translate(
                            'tx_rkwfeecalculator_domain_model_supportrequest.consultantType.1',
                            'RkwFeecalculator'
                        ),
                        2 => LocalizationUtility::translate(
                            'tx_rkwfeecalculator_domain_model_supportrequest.consultantType.2',
                            'RkwFeecalculator'
                        ),
                        3 => LocalizationUtility::translate(
                            'tx_rkwfeecalculator_domain_model_supportrequest.consultantType.3',
                            'RkwFeecalculator'
                        ),
                    ]
                ],
                'consultantCompany' => [
                    'type' => 'text',
                    'width' => 'full',
                ],
                'consultantName1' => [
                    'type' => 'text',
                ],
                'consultant1AccreditationNumber' => [
                    'type' => 'text',
                ],
                'consultantName2' => [
                    'type' => 'text',
                ],
                'consultant2AccreditationNumber' => [
                    'type' => 'text',
                ],
                'consultantPhone' => [
                    'type' => 'text',
                ],
                'consultantFee' => [
                    'type' => 'text',
                ],
                'consultantEmail' => [
                    'type' => 'text',
                ],
            ],
            'misc' => [
                'prematureStart' => [
                    'type' => 'radio',
                    'width' => 'full',
                    'options' => [
                        [
                            'value' => 1,
                            'label' => LocalizationUtility::translate(
                                'tx_rkwfeecalculator_domain_model_supportrequest.preTaxDeduction.1',
                                'RkwFeecalculator'
                            ),
                        ],
                        [
                            'value' => 99,
                            'label' => LocalizationUtility::translate(
                                'tx_rkwfeecalculator_domain_model_supportrequest.preTaxDeduction.99',
                                'RkwFeecalculator'
                            ),
                        ]
                    ],
                    'hints' => [
                        LocalizationUtility::translate(
                            'tx_rkwfeecalculator_domain_model_supportrequest.prematureStart.hint1',
                            'RkwFeecalculator',
                            [$this->supportProgramme->getName()]
                        ),
                        LocalizationUtility::translate(
                            'tx_rkwfeecalculator_domain_model_supportrequest.prematureStart.hint2',
                            'RkwFeecalculator',
                            [$this->supportProgramme->getName()]
                        ),
                    ]
                ],
                'bafaSupport' => [
                    'type' => 'radio',
                    'width' => 'full',
                    'options' => [
                        [
                            'value' => 1,
                            'label' => LocalizationUtility::translate(
                                'tx_rkwfeecalculator_domain_model_supportrequest.bafaSupport.1',
                                'RkwFeecalculator'
                            ),
                        ],
                        [
                            'value' => 99,
                            'label' => LocalizationUtility::translate(
                                'tx_rkwfeecalculator_domain_model_supportrequest.bafaSupport.99',
                                'RkwFeecalculator'
                            ),
                        ]
                    ],
                    'hints' => []
                ],
                'deMinimis' => [
                    'type' => 'radio',
                    'width' => 'full',
                    'options' => [
                        [
                            'value' => 1,
                            'label' => LocalizationUtility::translate(
                                'tx_rkwfeecalculator_domain_model_supportrequest.deMinimis.1',
                                'RkwFeecalculator'
                            ),
                        ],
                        [
                            'value' => 99,
                            'label' => LocalizationUtility::translate(
                                'tx_rkwfeecalculator_domain_model_supportrequest.deMinimis.99',
                                'RkwFeecalculator'
                            ),
                        ]
                    ],
                    'hints' => []
                ],
                'existenzGruenderPass' => [
                    'type' => 'radio',
                    'width' => 'full',
                    'options' => [
                        [
                            'value' => 1,
                            'label' => LocalizationUtility::translate(
                                'tx_rkwfeecalculator_domain_model_supportrequest.existenzGruenderPass.1',
                                'RkwFeecalculator'
                            ),
                        ],
                        [
                            'value' => 99,
                            'label' => LocalizationUtility::translate(
                                'tx_rkwfeecalculator_domain_model_supportrequest.existenzGruenderPass.99',
                                'RkwFeecalculator'
                            ),
                        ]
                    ],
                    'hints' => []
                ],
                'sendDocuments' => [
                    'type' => 'select',
                    'width' => 'full',
                    'options' => [
                        1 => LocalizationUtility::translate(
                            'tx_rkwfeecalculator_domain_model_supportrequest.sendDocuments.1',
                            'RkwFeecalculator'
                        ),
                        2 => LocalizationUtility::translate(
                            'tx_rkwfeecalculator_domain_model_supportrequest.sendDocuments.2',
                            'RkwFeecalculator'
                        ),
                    ],
                    'hints' => []
                ],
                'file' => [
                    'type' => 'upload',
                    'width' => 'full'
                ]
            ]
        ];
    }

    /**
     * Provide fieldsets
     *
     * @param $fieldsets
     * @param $requestFieldsArray
     *
     * @return mixed
     */
    protected function filterFieldsets($fieldsets, $requestFieldsArray)
    {
        foreach ($fieldsets as $key => $fieldset) {
            $fieldsets[$key] = array_filter($fieldset, function($item) use ($requestFieldsArray) {
                return in_array($item, $requestFieldsArray, true);
            },ARRAY_FILTER_USE_KEY);

            //  sort array
            $sortedFieldsets[$key] = array_merge(array_flip(array_intersect($requestFieldsArray, array_keys($fieldsets[$key]))), $fieldsets[$key]);
        }

        return $sortedFieldsets;
    }
}