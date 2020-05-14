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

use RKW\RkwFeecalculator\Helper\Misc;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use RKW\RkwRegistration\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException;
use TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException;

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
     * @var \RKW\RkwFeecalculator\Service\LayoutService
     * @inject
     */
    protected $layoutService;

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
     * @param \RKW\RkwFeecalculator\Domain\Model\Program $supportProgramme
     *
     * @return void
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     */
    public function requestFormAction(\RKW\RkwFeecalculator\Domain\Model\Program $supportProgramme = null)
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


        $fieldsets = $this->layoutService->getFields($supportProgramme);

        $this->view->assign('supportProgramme', $this->supportProgramme);
        $this->view->assign('applicant', $fieldsets['applicant']);
        $this->view->assign('consulting', $fieldsets['consulting']);
        $this->view->assign('misc', $fieldsets['misc']);
        $this->view->assign('mandatoryFields', $this->supportProgramme->getMandatoryFields());
    }

    /**
     * action create
     *
     * @param \RKW\RkwFeecalculator\Domain\Model\SupportRequest $supportRequest
     * @validate $supportRequest \RKW\RkwFeecalculator\Validation\SupportRequestValidator
     *
     * @throws InvalidSlotException
     * @throws InvalidSlotReturnException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     *
     * @return void
     */
    public function createAction(\RKW\RkwFeecalculator\Domain\Model\SupportRequest $supportRequest)
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
     * @param \RKW\RkwFeecalculator\Domain\Model\SupportRequest $supportRequest
     *
     * @throws InvalidSlotException
     * @throws InvalidSlotReturnException
     */
    protected function mailHandling(\RKW\RkwFeecalculator\Domain\Model\SupportRequest $supportRequest)
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
     * @param \RKW\RkwRegistration\Domain\Model\FrontendUser    $frontendUser
     * @param \RKW\RkwFeecalculator\Domain\Model\SupportRequest $supportRequest
     *
     * @throws InvalidSlotException
     * @throws InvalidSlotReturnException
     */
    protected function sendConfirmationMail(\RKW\RkwRegistration\Domain\Model\FrontendUser $frontendUser, \RKW\RkwFeecalculator\Domain\Model\SupportRequest $supportRequest)
    {
        $this->signalSlotDispatcher->dispatch(__CLASS__, self::SIGNAL_AFTER_REQUEST_CREATED_USER, [$frontendUser, $supportRequest]);
    }

    /**
     * Sends notification mail to admin.
     *
     * @param \RKW\RkwFeecalculator\Domain\Model\SupportRequest $supportRequest
     *
     * @throws InvalidSlotException if the slot is not valid
     * @throws InvalidSlotReturnException if a slot return
     */
    protected function sendNotificationMail(\RKW\RkwFeecalculator\Domain\Model\SupportRequest $supportRequest)
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

}
