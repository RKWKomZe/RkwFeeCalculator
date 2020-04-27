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

use RKW\RkwFeecalculator\Domain\Model\Program;
use RKW\RkwFeecalculator\Domain\Model\SupportRequest;
use RKW\RkwFeecalculator\Helper\Misc;
use RKW\RkwRegistration\Domain\Model\FrontendUser;
use \TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Messaging\AbstractMessage;
use RKW\RkwFeecalculator\ViewHelpers\PossibleDaysViewHelper;
use TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException;
use TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * SupportRequestController
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @author Christian Dilger <c.dilger@addorange.de>
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
     * supportProgramme
     *
     * @var \RKW\RkwFeecalculator\Domain\Model\Program
     * @inject
     */
    protected $supportProgramme = null;

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

    protected $companyTypeList;

    protected $consultingList;

    protected $fieldWidth = 'full';

    /**
     * Remove ErrorFlashMessage
     *
     * @see \TYPO3\CMS\Extbase\Mvc\Controller\ActionController::getErrorFlashMessage()
     */
    protected function getErrorFlashMessage()
    {
        return false;
        //===
    }

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
     * @param Program $supportProgramme
     *
     * @return void
     */
    public function requestFormAction(Program $supportProgramme = null)
    {
        if (!$supportProgramme) {
            $this->addFlashMessage(
                LocalizationUtility::translate(
                    'tx_rkwfeecalculator_controller_supportrequest.error.choose_support_programme', 'rkw_feecalculator'
                ),
                '',
                AbstractMessage::ERROR
            );
            $this->forward('new');
            //===
        }

        $this->supportProgramme = $supportProgramme;

        $requestFieldsArray = array_map(function($item) {
            return lcfirst(GeneralUtility::underscoredToUpperCamelCase(trim($item)));
        }, explode(',', $this->supportProgramme->getRequestFields()));

        $this->companyTypeList = $this->companyTypeRepository->findAll();
        $this->consultingList = $this->supportProgramme->getConsulting();

        $fieldsets = $this->getFieldsConfig();

        $fieldsets = $this->getFieldsLayout($this->filterFieldsets($fieldsets, $requestFieldsArray));

        $this->view->assign('supportProgramme', $this->supportProgramme);
        $this->view->assign('applicant', $fieldsets['applicant']);
        $this->view->assign('consulting', $fieldsets['consulting']);
        $this->view->assign('consultant', $fieldsets['consultant']);
        $this->view->assign('misc', $fieldsets['misc']);
        $this->view->assign('consultingList', $this->consultingList);
        $this->view->assign('companyTypeList', $this->companyTypeList);
    }

    /**
     * action create
     *
     * @param SupportRequest $supportRequest
     * @validate $supportRequest \RKW\RkwFeecalculator\Validation\SupportRequestValidator
     * @return void
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws InvalidSlotException if the slot is not valid
     * @throws InvalidSlotReturnException if a slot return
     */
    public function createAction(SupportRequest $supportRequest)
    {
        //  transform dates from string to timestamp
        $supportRequest->transformDates();
        $supportRequest->setPid((int)($this->settings['storagePid']));

        $this->supportRequestRepository->add($supportRequest);
        $this->persistenceManager->persistAll();

        /** @var \RKW\RkwFeecalculator\Helper\Misc $miscHelper */
        $miscHelper = GeneralUtility::makeInstance(Misc::class);

        // save file(s)
        foreach ($supportRequest->getFileUpload() as $file) {

            if ($file['name'] == "" || $file['name'] == " ") {
                continue;
                //===
            }

            $miscHelper->createFileReference($file, 'file', $supportRequest);
        }

        $this->supportRequestRepository->update($supportRequest);

        $this->mailHandling($supportRequest);

        $this->addFlashMessage(
            LocalizationUtility::translate(
                'tx_rkwfeecalculator_controller_supportrequest.success.requestCreated', 'rkw_feecalculator'
            )
        );

        $this->redirect('new');
    }

    /**
     * Manage email sending
     *
     * @param SupportRequest $supportRequest
     *
     * @throws InvalidSlotException if the slot is not valid
     * @throws InvalidSlotReturnException if a slot return
     */
    protected function mailHandling(SupportRequest $supportRequest)
    {

        /** @var FrontendUser $frontendUser */
        $frontendUser = GeneralUtility::makeInstance(FrontendUser::class);

        $frontendUser->setEmail($supportRequest->getContactPersonEmail());
        $frontendUser->setFirstName($supportRequest->getContactPersonName());
        $frontendUser->setLastName($supportRequest->getContactPersonName());
        $frontendUser->setTxRkwregistrationLanguageKey($GLOBALS['TSFE']->config['config']['language'] ? $GLOBALS['TSFE']->config['config']['language'] : 'de');

        /*
        // currently we do not use real privacy-entries
        if ($this->settings['includeRkwRegistrationPrivacy']) {
            // add privacy info
            \RKW\RkwRegistration\Tools\Privacy::addPrivacyData($this->request, $frontendUser, $supportRequest, 'new support request');
        }
        */

        try {
            $this->sendConfirmationMail($frontendUser, $supportRequest);
        } catch (InvalidSlotException $e) {
        } catch (InvalidSlotReturnException $e) {
        }

        try {
            $this->sendNotificationMail($supportRequest);
        } catch (InvalidSlotException $e) {
        } catch (InvalidSlotReturnException $e) {
        }

    }

    /**
     * Sends confirmation mail to frontenduser.
     *
     * @param FrontendUser   $frontendUser
     * @param SupportRequest $supportRequest
     *
     * @throws InvalidSlotException if the slot is not valid
     * @throws InvalidSlotReturnException if a slot return
     */
    protected function sendConfirmationMail(FrontendUser $frontendUser, SupportRequest $supportRequest)
    {
        $this->signalSlotDispatcher->dispatch(__CLASS__, self::SIGNAL_AFTER_REQUEST_CREATED_USER, [$frontendUser, $supportRequest]);
    }

    /**
     * Sends notification mail to admin.
     *
     * @param SupportRequest $supportRequest
     *
     * @throws InvalidSlotException if the slot is not valid
     * @throws InvalidSlotReturnException if a slot return
     */
    protected function sendNotificationMail(SupportRequest $supportRequest)
    {

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

        $this->signalSlotDispatcher->dispatch(__CLASS__, self::SIGNAL_AFTER_REQUEST_CREATED_ADMIN, [$backendUsers, $supportRequest]);
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
                'companyType' => [
                    'type' => 'select',
                    'options' => $this->companyTypeList,
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
                    'options' => $this->consultingList,
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
            ],
            'consultant' => [
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
}
