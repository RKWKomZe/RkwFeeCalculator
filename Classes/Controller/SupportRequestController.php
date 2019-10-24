<?php
namespace RKW\RkwManagementConsultancy\Controller;

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

use RKW\RkwBasics\Helper\Common;
use \TYPO3\CMS\Core\Utility\GeneralUtility;
use RKW\RkwManagementConsultancy\Domain\Model\FrontendUser;
use RKW\RkwManagementConsultancy\Domain\Model\SupportRequest;

/**
 * SupportRequestController
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwManagementConsultancy
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
     * @var \RKW\RkwManagementConsultancy\Domain\Repository\SupportRequestRepository
     * @inject
     */
    protected $supportRequestRepository = null;

    /**
     * FrontendUserRepository
     *
     * @var \RKW\RkwManagementConsultancy\Domain\Repository\FrontendUserRepository
     * @inject
     */
    protected $frontendUserRepository;

    /**
     * BackendUserRepository
     *
     * @var \RKW\RkwManagementConsultancy\Domain\Repository\BackendUserRepository
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
                    'tx_rkwmanagementconsultancy_controller_supportrequest.error.choose_support_programme', 'rkw_management_consultancy'
                ),
                '',
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
            );
            $this->forward('new');
            //===
        }

        $this->view->assign('supportProgramme', $supportProgramme);
        $this->view->assign('consultingList', $supportProgramme->getConsulting());
        $this->view->assign('companyTypeList', $this->companyTypeRepository->findAll());
    }

    /**
     * action create
     *
     * @param \RKW\RkwManagementConsultancy\Domain\Model\SupportRequest $newSupportRequest
     * @param integer $terms
     * @param integer $privacy
     * @return void
     */
    public function createAction(\RKW\RkwManagementConsultancy\Domain\Model\SupportRequest $newSupportRequest, $terms = null, $privacy = null)
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
                'tx_rkwmanagementconsultancy_controller_supportrequest.success.requestCreated', 'rkw_management_consultancy'
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
     * @param \RKW\RkwManagementConsultancy\Domain\Model\SupportRequest $newSupportRequest
     */
    protected function sendConfirmationMail(\RKW\RkwRegistration\Domain\Model\FrontendUser $frontendUser, \RKW\RkwManagementConsultancy\Domain\Model\SupportRequest $newSupportRequest)
    {
        $this->signalSlotDispatcher->dispatch(__CLASS__, self::SIGNAL_AFTER_REQUEST_CREATED_USER, [$frontendUser, $newSupportRequest]);
    }

    /**
     * Sends notification mail to admin.
     *
     * @param \RKW\RkwManagementConsultancy\Domain\Model\SupportRequest $newSupportRequest
     */
    protected function sendNotificationMail(\RKW\RkwManagementConsultancy\Domain\Model\SupportRequest $newSupportRequest)
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
