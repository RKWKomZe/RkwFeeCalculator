<?php
namespace RKW\RkwFeecalculator\Controller;

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

use \TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Core\Error\DebugExceptionHandler;
use RKW\RkwFeecalculator\ViewHelpers\PossibleDaysViewHelper;

/**
 * SupportRequestController
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwFeecalculator
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class SupportRequestController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * Signal name for use in ext_localconf.php
     *
     * @const string
     */
    const SIGNAL_AFTER_REQUEST_CREATED_USER = 'afterRequestCreatedUser';

    /**
     * Signal name for use in ext_localconf.php
     *
     * @const string
     */
    const SIGNAL_AFTER_REQUEST_CREATED_ADMIN = 'afterRequestCreatedAdmin';

    /**
     * supportProgrammeRepository
     *
     * @var \RKW\RkwFeecalculator\Domain\Repository\ProgramRepository
     * @inject
     */
    protected $supportProgrammeRepository = null;

    /**
     * companyTypeRepository
     *
     * @var \RKW\RkwBasics\Domain\Repository\CompanyTypeRepository
     * @inject
     */
    protected $companyTypeRepository = null;

    /**
     * supportRequestRepository
     *
     * @var \RKW\RkwFeecalculator\Domain\Repository\SupportRequestRepository
     * @inject
     */
    protected $supportRequestRepository = null;

    /**
     * FrontendUserRepository
     *
     * @var \RKW\RkwFeecalculator\Domain\Repository\FrontendUserRepository
     * @inject
     */
    protected $frontendUserRepository;

    /**
     * BackendUserRepository
     *
     * @var \RKW\RkwFeecalculator\Domain\Repository\BackendUserRepository
     * @inject
     */
    protected $backendUserRepository;

    /**
     * Persistence Manager
     *
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     * @inject
     */
    protected $persistenceManager;

    /**
     * action new
     *
     * @return void
     */
    public function newAction()
    {
        $querySettings = $this->supportProgrammeRepository->createQuery()->getQuerySettings();
        $querySettings->setStoragePageIds([$this->settings['programStoragePid']]);
        $this->supportProgrammeRepository->setDefaultQuerySettings($querySettings);

        $this->view->assign('supportProgrammeList', $this->supportProgrammeRepository->findAll());
    }

    /**
     * action requestForm
     *
     * @param \RKW\RkwFeecalculator\Domain\Model\Program $supportProgramme
     * @return void
     */
    public function requestFormAction(\RKW\RkwFeecalculator\Domain\Model\Program $supportProgramme = null)
    {
        if (!$supportProgramme) {
            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                    'tx_rkwfeecalculator_controller_supportrequest.error.choose_support_programme', 'rkw_feecalculator'
                ),
                '',
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
            );
            $this->forward('new');
            //===
        }

        //  get request fields and use them in the view, getting rid of the view helper
        $mandatoryFieldsArray = array_map(function($item) {
            return lcfirst(GeneralUtility::underscoredToUpperCamelCase(trim($item)));
        }, explode(',', $supportProgramme->getMandatoryFields()));

        $requestFieldsArray = array_map(function($item) {
            return lcfirst(GeneralUtility::underscoredToUpperCamelCase(trim($item)));
        }, explode(',', $supportProgramme->getRequestFields()));

        //  filter mandatoryFieldsArray to only contain requested fields
        $mandatoryFieldsArray = array_filter($mandatoryFieldsArray, function($item) use ($requestFieldsArray) {
            return in_array($item, $requestFieldsArray);
        });

        $companyTypeList = $this->companyTypeRepository->findAll();
        $consultingList = $supportProgramme->getConsulting();

        //  group the fields
        $fieldsets = [
            'applicant' => [
                'name' => [
                    'type' => 'text'
                ],
                'founderName' => [
                    'type' => 'text'
                ],
                'address' => [
                    'type' => 'text'
                ],
                'zip' => [
                    'type' => 'text'
                ],
                'city' => [
                    'type' => 'text'
                ],
                'foundationDate' => [
                    'type' => 'date'
                ],
                'intendedFoundationDate' => [
                    'type' => 'date'
                ],
                'companyType' => [
                    'type' => 'select',
                    'options' => $companyTypeList,
                    'optionValueField' => 'uid',
                    'optionLabelField' => 'name'
                ],
                'city' => [
                    'type' => 'text'
                ],
                'citizenship' => [
                    'type' => 'text'
                ],
                'birthdate' => [
                    'type' => 'date'
                ],
                'foundationLocation' => [
                    'type' => 'text'
                ],
                'balance' => [
                    'type' => 'text'
                ],
                'sales' => [
                    'type' => 'text'
                ],
                'employeesCount' => [
                    'type' => 'text'
                ],
                'manager' => [
                    'type' => 'text'
                ],
                'singleRepresentative' => [
                    'type' => 'radio',
                    'options' => [
                        [
                            'value' => 1,
                            'label' => \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                                'tx_rkwfeecalculator_domain_model_supportrequest.singleRepresentative.1',
                                'RkwFeecalculator'
                            ),
                        ],
                        [
                            'value' => 99,
                            'label' => \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
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
                            'label' => \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                                'tx_rkwfeecalculator_domain_model_supportrequest.preTaxDeduction.1',
                                'RkwFeecalculator'
                            ),
                        ],
                        [
                            'value' => 99,
                            'label' => \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                                'tx_rkwfeecalculator_domain_model_supportrequest.preTaxDeduction.99',
                                'RkwFeecalculator'
                            ),
                        ]
                    ]
                ],
                'businessPurpose' => [
                    'type' => 'textarea'
                ],
                'insolvencyProceedings' => [
                    'type' => 'radio',
                    'options' => [
                        [
                            'value' => 1,
                            'label' => \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                                'tx_rkwfeecalculator_domain_model_supportrequest.insolvencyProceedings.1',
                                'RkwFeecalculator'
                            ),
                        ],
                        [
                            'value' => 99,
                            'label' => \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                                'tx_rkwfeecalculator_domain_model_supportrequest.insolvencyProceedings.99',
                                'RkwFeecalculator'
                            ),
                        ]
                    ]
                ],
                'chamber' => [
                    'type' => 'select',
                    'options' => [
                        1 => \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                                'tx_rkwfeecalculator_domain_model_supportrequest.chamber.1',
                                'RkwFeecalculator'
                        ),
                        2 => \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                            'tx_rkwfeecalculator_domain_model_supportrequest.chamber.2',
                            'RkwFeecalculator'
                        ),
                        3 => \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                            'tx_rkwfeecalculator_domain_model_supportrequest.chamber.3',
                            'RkwFeecalculator'
                        ),
                    ]
                ],
                'companyShares' => [
                    'type' => 'textarea'
                ],
                'principalBank' => [
                    'type' => 'text'
                ],
                'bic' => [
                    'type' => 'text'
                ],
                'iban' => [
                    'type' => 'text'
                ],
                'contactPersonName' => [
                    'type' => 'text'
                ],
                'contactPersonPhone' => [
                    'type' => 'text'
                ],
                'contactPersonFax' => [
                    'type' => 'text'
                ],
                'contactPersonMobile' => [
                    'type' => 'text'
                ],
                'contactPersonEmail' => [
                    'type' => 'text'
                ],
                'preFoundationEmployment' => [
                    'type' => 'select',
                    'options' => [
                        1 => \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                            'tx_rkwfeecalculator_domain_model_supportrequest.preFoundationEmployment.employed',
                            'RkwFeecalculator'
                        ),
                        2 => \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                            'tx_rkwfeecalculator_domain_model_supportrequest.preFoundationEmployment.self_employed',
                            'RkwFeecalculator'
                        ),
                        3 => \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                            'tx_rkwfeecalculator_domain_model_supportrequest.preFoundationEmployment.in_education',
                            'RkwFeecalculator'
                        ),
                        4 => \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                            'tx_rkwfeecalculator_domain_model_supportrequest.preFoundationEmployment.unemployed',
                            'RkwFeecalculator'
                        ),
                    ]
                ],
                'preFoundationSelfEmployment' => [
                    'type' => 'select',
                    'options' => [
                        1 => \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                            'tx_rkwfeecalculator_domain_model_supportrequest.preFoundationSelfEmployment.no',
                            'RkwFeecalculator'
                        ),
                        2 => \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                            'tx_rkwfeecalculator_domain_model_supportrequest.preFoundationSelfEmployment.part_time',
                            'RkwFeecalculator'
                        ),
                        3 => \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                            'tx_rkwfeecalculator_domain_model_supportrequest.preFoundationSelfEmployment.full_time',
                            'RkwFeecalculator'
                        ),
                        4 => \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                            'tx_rkwfeecalculator_domain_model_supportrequest.preFoundationSelfEmployment.shareholder',
                            'RkwFeecalculator'
                        ),
                    ]
                ],
            ],
            'consulting' => [
                'consulting' => [
                    'type' => 'select',
                    'options' => $consultingList,
                    'optionValueField' => 'uid',
                    'optionLabelField' => 'title'
                ],
                'consultingDays' => [
                    'type' => 'select',
                    'options' => (new PossibleDaysViewHelper())->render($supportProgramme),
                ],
                'consultingDateFrom' => [
                    'type' => 'date'
                ],
                'consultingDateTo' => [
                    'type' => 'date'
                ],
                'consultingContent' => [
                    'type' => 'textarea'
                ],
            ],
            'consultant' => [
                'consultantType' => [
                    'type' => 'select',
                    'options' => [
                        1 => \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                            'tx_rkwfeecalculator_domain_model_supportrequest.consultantType.1',
                            'RkwFeecalculator'
                        ),
                        2 => \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                            'tx_rkwfeecalculator_domain_model_supportrequest.consultantType.2',
                            'RkwFeecalculator'
                        ),
                        3 => \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                            'tx_rkwfeecalculator_domain_model_supportrequest.consultantType.3',
                            'RkwFeecalculator'
                        ),
                    ]
                ],
                'consultantCompany' => [
                    'type' => 'text'
                ],
                'consultantName1' => [
                    'type' => 'text'
                ],
                'consultant1AccreditationNumber' => [
                    'type' => 'text'
                ],
                'consultantName2' => [
                    'type' => 'text'
                ],
                'consultant2AccreditationNumber' => [
                    'type' => 'text'
                ],
                'consultantFee' => [
                    'type' => 'text'
                ],
                'consultantFee' => [
                    'type' => 'text'
                ],
                'consultantPhone' => [
                    'type' => 'text'
                ],
                'consultantFee' => [
                    'type' => 'text'
                ],
                'consultantEmail' => [
                    'type' => 'text'
                ],
            ],
            'misc' => [
                'prematureStart' => [
                    'type' => 'radio',
                    'options' => [
                        [
                            'value' => 1,
                            'label' => \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                                'tx_rkwfeecalculator_domain_model_supportrequest.preTaxDeduction.1',
                                'RkwFeecalculator'
                            ),
                        ],
                        [
                            'value' => 99,
                            'label' => \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                                'tx_rkwfeecalculator_domain_model_supportrequest.preTaxDeduction.99',
                                'RkwFeecalculator'
                            ),
                        ]
                    ],
                    'hints' => [
                        \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                            'tx_rkwfeecalculator_domain_model_supportrequest.prematureStart.hint1',
                            'RkwFeecalculator',
                            $supportProgramme.name
                        ),
                        \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                            'tx_rkwfeecalculator_domain_model_supportrequest.prematureStart.hint2',
                            'RkwFeecalculator',
                            $supportProgramme.name
                        ),
                    ]
                ],
                'bafaSupport' => [
                    'type' => 'radio',
                    'options' => [
                        [
                            'value' => 1,
                            'label' => \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                                'tx_rkwfeecalculator_domain_model_supportrequest.bafaSupport.1',
                                'RkwFeecalculator'
                            ),
                        ],
                        [
                            'value' => 99,
                            'label' => \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                                'tx_rkwfeecalculator_domain_model_supportrequest.bafaSupport.99',
                                'RkwFeecalculator'
                            ),
                        ]
                    ],
                    'hints' => []
                ],
                'deMinimis' => [
                    'type' => 'radio',
                    'options' => [
                        [
                            'value' => 1,
                            'label' => \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                                'tx_rkwfeecalculator_domain_model_supportrequest.deMinimis.1',
                                'RkwFeecalculator'
                            ),
                        ],
                        [
                            'value' => 99,
                            'label' => \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                                'tx_rkwfeecalculator_domain_model_supportrequest.deMinimis.99',
                                'RkwFeecalculator'
                            ),
                        ]
                    ],
                    'hints' => []
                ],
                'sendDocuments' => [
                    'type' => 'select',
                    'options' => [
                        1 => \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                            'tx_rkwfeecalculator_domain_model_supportrequest.sendDocuments.1',
                            'RkwFeecalculator'
                        ),
                        2 => \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                            'tx_rkwfeecalculator_domain_model_supportrequest.sendDocuments.2',
                            'RkwFeecalculator'
                        ),
                    ],
                    'hints' => []
                ],
            ]
        ];

        $fieldsets['applicant'] = array_filter($fieldsets['applicant'], function($item) use ($requestFieldsArray) {
            return in_array($item, $requestFieldsArray);
        }, ARRAY_FILTER_USE_KEY);

        $fieldsets['consulting'] = array_filter($fieldsets['consulting'], function($item) use ($requestFieldsArray) {
            return in_array($item, $requestFieldsArray);
        }, ARRAY_FILTER_USE_KEY);

        $fieldsets['consultant'] = array_filter($fieldsets['consultant'], function($item) use ($requestFieldsArray) {
            return in_array($item, $requestFieldsArray);
        }, ARRAY_FILTER_USE_KEY);

        $fieldsets['misc'] = array_filter($fieldsets['misc'], function($item) use ($requestFieldsArray) {
            return in_array($item, $requestFieldsArray);
        }, ARRAY_FILTER_USE_KEY);

        $this->view->assign('supportProgramme', $supportProgramme);
        $this->view->assign('applicant', $fieldsets['applicant']);
        $this->view->assign('consulting', $fieldsets['consulting']);
        $this->view->assign('consultant', $fieldsets['consultant']);
        $this->view->assign('misc', $fieldsets['misc']);
        $this->view->assign('consultingList', $consultingList);
        $this->view->assign('companyTypeList', $companyTypeList);
    }

    /**
     * action create
     *
     * @param \RKW\RkwFeecalculator\Domain\Model\SupportRequest $newSupportRequest
     * @param integer $terms
     * @param integer $privacy
     * @return void
     */
    public function createAction(\RKW\RkwFeecalculator\Domain\Model\SupportRequest $newSupportRequest, $terms = null, $privacy = null)
    {
        /** @var \RKW\RkwRegistration\Domain\Model\FrontendUser $frontendUser */
        $frontendUser = GeneralUtility::makeInstance('RKW\\RkwRegistration\\Domain\\Model\\FrontendUser');
        $frontendUser->setEmail($newSupportRequest->getContactPersonEmail());
        $frontendUser->setFirstName($newSupportRequest->getContactPersonFirstName());
        $frontendUser->setLastName($newSupportRequest->getContactPersonLastName());

        //  transform dates from string to timestamp
        $newSupportRequest->transformDates();

        if ($this->settings['includeRkwRegistrationPrivacy']) {
            // add privacy info
            \RKW\RkwRegistration\Tools\Privacy::addPrivacyData($this->request, $frontendUser, $newSupportRequest, 'new support request');
        }

        $this->addFlashMessage(
            \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                'tx_rkwfeecalculator_controller_supportrequest.success.requestCreated', 'rkw_feecalculator'
            )
        );

        $newSupportRequest->setPid((int)($this->settings['storagePid']));
        $this->supportRequestRepository->add($newSupportRequest);

        // persist first before sending mail!
        $this->persistenceManager->persistAll();

        $this->sendConfirmationMail($frontendUser, $newSupportRequest);

        $this->sendNotificationMail($newSupportRequest);

        $this->redirect('new');
    }

    /**
     * Sends confirmation mail to frontenduser.
     *
     * @param \RKW\RkwRegistration\Domain\Model\FrontendUser $frontendUser
     * @param \RKW\RkwFeecalculator\Domain\Model\SupportRequest $newSupportRequest
     */
    protected function sendConfirmationMail(\RKW\RkwRegistration\Domain\Model\FrontendUser $frontendUser, \RKW\RkwFeecalculator\Domain\Model\SupportRequest $newSupportRequest)
    {
        $this->signalSlotDispatcher->dispatch(__CLASS__, self::SIGNAL_AFTER_REQUEST_CREATED_USER, [$frontendUser, $newSupportRequest]);
    }

    /**
     * Sends notification mail to admin.
     *
     * @param \RKW\RkwFeecalculator\Domain\Model\SupportRequest $newSupportRequest
     */
    protected function sendNotificationMail(\RKW\RkwFeecalculator\Domain\Model\SupportRequest $newSupportRequest)
    {

        // send information mail to admins
        $adminUidList = explode(',', $this->settings['mail']['backendUser']);
        $backendUsers = [];
        foreach ($adminUidList as $adminUid) {
            if ($adminUid) {
                $admin = $this->backendUserRepository->findByUid($adminUid);
                if ($admin) {
                    $backendUsers[] = $admin;
                }
            }
        }

        // fallback-handling
        if (
            (count($backendUsers) < 1)
            && ($backendUserFallback = (int)$this->settings['backendUserIdForMails'])
        ) {
            $admin = $this->backendUserRepository->findByUid($backendUserFallback);
            if (
                ($admin)
                && ($admin->getEmail())
            ) {
                $backendUsers[] = $admin;
            }

        }

        $this->signalSlotDispatcher->dispatch(__CLASS__, self::SIGNAL_AFTER_REQUEST_CREATED_ADMIN, [$backendUsers, $newSupportRequest]);
    }
}
