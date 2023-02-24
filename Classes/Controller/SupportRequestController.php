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
use RKW\RkwFeecalculator\Domain\Repository\BackendUserRepository;
use RKW\RkwFeecalculator\Domain\Repository\FrontendUserRepository;
use RKW\RkwFeecalculator\Domain\Repository\ProgramRepository;
use RKW\RkwFeecalculator\Domain\Repository\SupportRequestRepository;
use RKW\RkwFeecalculator\Helper\UploadHelper;
use RKW\RkwFeecalculator\Service\LayoutService;
use RKW\RkwRegistration\Domain\Model\FrontendUser;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException;
use TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException;

/**
 * Class SupportRequestController
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @author Christian Dilger <c.dilger@addorange.de>
 * @copyright RKW Kompetenzzentrum
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
     * @var \RKW\RkwFeecalculator\Service\LayoutService
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected LayoutService $layoutService;


    /**
     * @var \RKW\RkwFeecalculator\Domain\Repository\ProgramRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected ProgramRepository $supportProgrammeRepository;


    /**
     * @var \RKW\RkwFeecalculator\Domain\Model\Program
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected Program $supportProgramme;


    /**
     * @var \RKW\RkwFeecalculator\Domain\Repository\SupportRequestRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected SupportRequestRepository $supportRequestRepository;


    /**
     * @var \RKW\RkwFeecalculator\Domain\Repository\FrontendUserRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected FrontendUserRepository $frontendUserRepository;


    /**
     * @var \RKW\RkwFeecalculator\Domain\Repository\BackendUserRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected BackendUserRepository $backendUserRepository;


    /**
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected PersistenceManager $persistenceManager;


    /**
     * Remove ErrorFlashMessage
     *
     * @see \TYPO3\CMS\Extbase\Mvc\Controller\ActionController::getErrorFlashMessage()
     */
    protected function getErrorFlashMessage(): bool
    {
        return false;
    }


    /**
     * action new
     *
     * @return void
     */
    public function newAction(): void
    {
        $querySettings = $this->supportProgrammeRepository->createQuery()->getQuerySettings();
        $querySettings->setStoragePageIds([$this->settings['programStoragePid']]);
        $this->supportProgrammeRepository->setDefaultQuerySettings($querySettings);

        $this->view->assign('supportProgrammeList', $this->supportProgrammeRepository->findAll());
    }


    /**
     * action requestForm
     *
     * @param \RKW\RkwFeecalculator\Domain\Model\Program|null $supportProgramme
     * @return void
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     */
    public function requestFormAction(Program $supportProgramme = null): void
    {

        if (!$supportProgramme) {

            $this->addFlashMessage(
                LocalizationUtility::translate(
                    'tx_rkwfeecalculator_controller_supportrequest.error.choose_support_programme',
                    'RkwFeecalculator'
                ),
                '',
                AbstractMessage::ERROR
            );

            $this->forward('new');
        }

        $this->supportProgramme = $supportProgramme;

        /**  @todo $requestFieldsArray isn't used anywhere in this method. Can be remove this line? */
        $requestFieldsArray = array_map(function($item) {
            return lcfirst(GeneralUtility::underscoredToUpperCamelCase(trim($item)));
        }, explode(',', $this->supportProgramme->getRequestFields()));

        $fieldsets = $this->layoutService->getFields($supportProgramme);

        $this->view->assign('supportProgramme', $this->supportProgramme);
        $this->view->assign('applicant', $fieldsets['applicant']);
        $this->view->assign('consulting', $fieldsets['consulting']);
        $this->view->assign('misc', $fieldsets['misc']);
        $this->view->assign('privacy', 0);
        $this->view->assign('mandatoryFields', $this->supportProgramme->getMandatoryFields());
    }


    /**
     * action create
     *
     * @param \RKW\RkwFeecalculator\Domain\Model\SupportRequest $supportRequest
     * @return void
     * @throws \TYPO3\CMS\Core\Resource\Exception\ExistingTargetFileNameException
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     * @TYPO3\CMS\Extbase\Annotation\Validate("\RKW\RkwFeecalculator\Validation\SupportRequestValidator", param="supportRequest")
     */
    public function createAction(\RKW\RkwFeecalculator\Domain\Model\SupportRequest $supportRequest): void
    {

        //  transform dates from string to timestamp
        $supportRequest->transformDates();
        $supportRequest->setPid((int)($this->settings['storagePid']));

        $this->supportRequestRepository->add($supportRequest);
        $this->persistenceManager->persistAll();

        /** @var \RKW\RkwFeecalculator\Helper\UploadHelper $uploadHelper */
        $uploadHelper = GeneralUtility::makeInstance(UploadHelper::class);

        // save file(s)
        foreach ($supportRequest->getFileUpload() as $file) {

            if ($file['name'] == "" || $file['name'] == " ") {
                continue;
            }
            $supportRequest->addFile($uploadHelper->importUploadedResource($file));
        }

        $this->supportRequestRepository->update($supportRequest);
        $this->mailHandling($supportRequest);

        $this->addFlashMessage(
            LocalizationUtility::translate(
                'tx_rkwfeecalculator_controller_supportrequest.success.requestCreated',
                'RkwFeecalculator'
            )
        );

        $this->redirect('new');
    }


    /**
     * Manage email sending
     *
     * @param \RKW\RkwFeecalculator\Domain\Model\SupportRequest $supportRequest
     */
    protected function mailHandling(SupportRequest $supportRequest): void
    {

        /** @var FrontendUser $frontendUser */
        $frontendUser = GeneralUtility::makeInstance(FrontendUser::class);

        $frontendUser->setEmail($supportRequest->getContactPersonEmail());
        $frontendUser->setName($supportRequest->getContactPersonName());
        $frontendUser->setTxRkwregistrationLanguageKey($GLOBALS['TSFE']->config['config']['language'] ?: 'de');

        /*
        // currently we do not use real privacy-entries
        if ($this->settings['includeRkwRegistrationPrivacy']) {
            // add privacy info
            \RKW\RkwRegistration\DataProtection\ConsentHandler::add($this->request, $frontendUser, $supportRequest, 'new support request');
        }
        */

        try {
            $this->sendConfirmationMail($frontendUser, $supportRequest);
        } catch (InvalidSlotException|InvalidSlotReturnException $e) {
            // do nothing
        }

        try {
            $this->sendNotificationMail($supportRequest);
        } catch (InvalidSlotException|InvalidSlotReturnException $e) {
            // do nothing
        }

    }

    /**
     * Sends confirmation mail to frontenduser.
     *
     * @param \RKW\RkwRegistration\Domain\Model\FrontendUser $frontendUser
     * @param \RKW\RkwFeecalculator\Domain\Model\SupportRequest $supportRequest
     * @throws InvalidSlotException
     * @throws InvalidSlotReturnException
     */
    protected function sendConfirmationMail(FrontendUser $frontendUser, SupportRequest $supportRequest): void
    {
        $this->signalSlotDispatcher->dispatch(
            __CLASS__,
            self::SIGNAL_AFTER_REQUEST_CREATED_USER,
            [$frontendUser, $supportRequest]
        );
    }


    /**
     * Sends notification mail to admin.
     *
     * @param \RKW\RkwFeecalculator\Domain\Model\SupportRequest $supportRequest
     * @throws InvalidSlotException if the slot is not valid
     * @throws InvalidSlotReturnException if a slot return
     */
    protected function sendNotificationMail(SupportRequest $supportRequest): void
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

        $attachmentTypes = explode(',', $this->settings['mail']['attachment']['types']);
        $this->signalSlotDispatcher->dispatch(
            __CLASS__,
            self::SIGNAL_AFTER_REQUEST_CREATED_ADMIN,
            [$backendUsers, $supportRequest, $attachmentTypes]
        );
    }

}
