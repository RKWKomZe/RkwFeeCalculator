<?php

namespace RKW\RkwManagementConsultancy\Service;

use \RKW\RkwBasics\Helper\Common;
use \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

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
 * RkwMailService
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwManagementConsultancy
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class RkwMailService implements \TYPO3\CMS\Core\SingletonInterface
{
    /**
     * Sends an E-Mail to a Frontend-User
     *
     * @param \RKW\RkwRegistration\Domain\Model\FrontendUser $frontendUser
     * @param \RKW\RkwManagementConsultancy\Domain\Model\SupportRequest $supportRequest
     *
     * @throws \RKW\RkwMailer\Service\MailException
     * @throws \TYPO3\CMS\Extbase\Persistence\Generic\Exception
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Fluid\View\Exception\InvalidTemplateResourceException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException
     */
    public function userMail(\RKW\RkwRegistration\Domain\Model\FrontendUser $frontendUser, \RKW\RkwManagementConsultancy\Domain\Model\SupportRequest $supportRequest)
    {
        // get settings
        $settings = $this->getSettings(ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
        $settingsDefault = $this->getSettings();

        if ($frontendUser->getEmail()) {
            if ($settings['view']['templateRootPaths'][0]) {

                /** @var \RKW\RkwMailer\Service\MailService $mailService */
                $mailService = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwMailer\\Service\\MailService');

                // send new user an email with token
                $mailService->setTo($frontendUser, [
                    'marker' => [
                        'supportRequest' => $supportRequest,
                        'frontendUser' => $frontendUser,
                        'pageUid'      => intval($GLOBALS['TSFE']->id),
                        'loginPid'     => intval($settingsDefault['loginPid']),
                    ],
                ]);

                $mailService->getQueueMail()->setSubject(
                    \RKW\RkwMailer\Helper\FrontendLocalization::translate(
                        'rkwMailService.confirmationUser.subject',
                        'rkw_management_consultancy',
                        null,
                        ($frontendUser->getTxRkwregistrationLanguageKey()) ? $frontendUser->getTxRkwregistrationLanguageKey() : 'de'
                    )
                );

                $mailService->getQueueMail()->addTemplatePaths($settings['view']['templateRootPaths']);
                $mailService->getQueueMail()->addPartialPaths($settings['view']['partialRootPaths']);

                $mailService->getQueueMail()->setPlaintextTemplate('Email/ConfirmationUser');
                $mailService->getQueueMail()->setHtmlTemplate('Email/ConfirmationUser');

                $mailService->send();
            }
        }

    }


    /**
     * Sends an E-Mail to an Admin
     *
     * @param \RKW\RkwOrder\Domain\Model\BackendUser|array $backendUser
     * @param \RKW\RkwManagementConsultancy\Domain\Model\SupportRequest $supportRequest
     *
     * @throws \RKW\RkwMailer\Service\MailException
     * @throws \TYPO3\CMS\Extbase\Persistence\Generic\Exception
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Fluid\View\Exception\InvalidTemplateResourceException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException
     */
    public function adminMail($backendUser, \RKW\RkwManagementConsultancy\Domain\Model\SupportRequest $supportRequest)
    {
        // get settings
        $settings = $this->getSettings(ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
        $settingsDefault = $this->getSettings();

        $recipients = [];
        if (is_array($backendUser)) {
            $recipients = $backendUser;
        } else {
            $recipients[] = $backendUser;
        }

        if ($settings['view']['templateRootPaths'][0]) {

            /** @var \RKW\RkwMailer\Service\MailService $mailService */
            $mailService = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwMailer\\Service\\MailService');

            foreach ($recipients as $recipient) {
                if (
                    ($recipient instanceof \RKW\RkwManagementConsultancy\Domain\Model\BackendUser)
                    && ($recipient->getEmail())
                ) {
                    // send new user an email with token
                    $mailService->setTo($recipient, [
                        'marker'  => [
                            'supportRequest' => $supportRequest,
                            'backendUser'  => $recipient,
                            'pageUid'      => intval($GLOBALS['TSFE']->id),
                            'loginPid'     => intval($settingsDefault['loginPid']),
                        ],
                        'subject' => \RKW\RkwMailer\Helper\FrontendLocalization::translate(
                            'rkwMailService.notifyAdmin.subject',
                            'rkw_management_consultancy',
                            null,
                            $recipient->getLang()
                        ),
                    ]);
                }
            }

            if (
                ($supportRequest->getContactPersonEmail())
            ) {
                $mailService->getQueueMail()->setReplyAddress($supportRequest->getContactPersonEmail());
            }

            $mailService->getQueueMail()->setSubject(
                \RKW\RkwMailer\Helper\FrontendLocalization::translate(
                    'rkwMailService.NotifyAdmin.subject',
                    'rkw_management_consultancy',
                    null,
                    'de'
                )
            );

            $mailService->getQueueMail()->addTemplatePaths($settings['view']['templateRootPaths']);
            $mailService->getQueueMail()->addPartialPaths($settings['view']['partialRootPaths']);

            $mailService->getQueueMail()->setPlaintextTemplate('Email/NotifyAdmin');
            $mailService->getQueueMail()->setHtmlTemplate('Email/NotifyAdmin');

            if (count($mailService->getTo())) {
                $mailService->send();
            }
        }
    }


    /**
     * Returns TYPO3 settings
     *
     * @param string $which Which type of settings will be loaded
     * @return array
     */
    protected function getSettings($which = ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS)
    {

        return Common::getTyposcriptConfiguration('Rkwmanagementconsultancy', $which);
        //===
    }
}
