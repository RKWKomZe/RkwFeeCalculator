<?php

namespace RKW\RkwFeecalculator\Service;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use RKW\RkwMailer\Utility\FrontendLocalizationUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

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
 * @author Christian Dilger <c.dilger@addorange.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwFeecalculator
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class RkwMailService implements \TYPO3\CMS\Core\SingletonInterface
{

    /**
     * @var \RKW\RkwFeecalculator\Service\PdfService
     * @inject
     */
    protected $pdfService;

    /**
     * @var \RKW\RkwFeecalculator\Service\CsvService
     * @inject
     */
    protected $csvService;

    /**
     * @var \RKW\RkwFeecalculator\Service\LayoutService
     * @inject
     */
    protected $layoutService;

    /**
     * Sends an E-Mail to a Frontend-User
     *
     * @param \RKW\RkwRegistration\Domain\Model\FrontendUser $frontendUser
     * @param \RKW\RkwFeecalculator\Domain\Model\SupportRequest $supportRequest
     *
     * @throws \RKW\RkwMailer\Service\MailException
     * @throws \TYPO3\CMS\Extbase\Persistence\Generic\Exception
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3Fluid\Fluid\View\Exception\InvalidTemplateResourceException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException
     */
    public function userMail(\RKW\RkwRegistration\Domain\Model\FrontendUser $frontendUser, \RKW\RkwFeecalculator\Domain\Model\SupportRequest $supportRequest)
    {
        // get settings
        $settings = $this->getSettings(ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
        $settingsDefault = $this->getSettings();

        if ($frontendUser->getEmail() && $settings['view']['templateRootPaths'][0]) {

            $fieldsets = $this->layoutService->getFields($supportRequest->getSupportProgramme());

            /** @var \RKW\RkwMailer\Service\MailService $mailService */
            $mailService = GeneralUtility::makeInstance('RKW\\RkwMailer\\Service\\MailService');

            // send new user an email with token
            $mailService->setTo($frontendUser, [
                'marker' => [
                    'supportRequest' => $supportRequest,
                    'supportProgramme' => $supportRequest->getSupportProgramme(),
                    'frontendUser' => $frontendUser,
                    'pageUid'      => intval($GLOBALS['TSFE']->id),
                    'applicant' => $fieldsets['applicant'],
                    'consulting' => $fieldsets['consulting'],
                    'misc' => $fieldsets['misc'],
                ],
            ]);

            $mailService->getQueueMail()->setSubject(
                FrontendLocalizationUtility::translate(
                    'templates_email_confirmationUser.subject',
                    'RkwFeecalculator',
                    [$settings['settings']['websiteName']],
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


    /**
     * Sends an E-Mail to an Admin
     *
     * @param \RKW\RkwFeecalculator\Domain\Model\BackendUser|array $backendUser
     * @param \RKW\RkwFeecalculator\Domain\Model\SupportRequest $supportRequest
     *
     * @throws \RKW\RkwMailer\Service\MailException
     * @throws \TYPO3\CMS\Extbase\Persistence\Generic\Exception
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3Fluid\Fluid\View\Exception\InvalidTemplateResourceException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException
     */
    public function adminMail($backendUser, \RKW\RkwFeecalculator\Domain\Model\SupportRequest $supportRequest)
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

            $fieldsets = $this->layoutService->getFields($supportRequest->getSupportProgramme());

            /** @var \RKW\RkwMailer\Service\MailService $mailService */
            $mailService = GeneralUtility::makeInstance('RKW\\RkwMailer\\Service\\MailService');

            foreach ($recipients as $recipient) {
                if (
                    ($recipient instanceof \RKW\RkwFeecalculator\Domain\Model\BackendUser)
                    && ($recipient->getEmail())
                ) {

                    $mailService->setTo($recipient, [
                        'marker'  => [
                            'supportRequest' => $supportRequest,
                            'supportProgramme' => $supportRequest->getSupportProgramme(),
                            'backendUser'  => $recipient,
                            'pageUid'      => intval($GLOBALS['TSFE']->id),
                            'applicant' => $fieldsets['applicant'],
                            'consulting' => $fieldsets['consulting'],
                            'misc' => $fieldsets['misc'],
                        ],
                        'subject' => FrontendLocalizationUtility::translate(
                            'rkwMailService.notifyAdmin.subject',
                            'RkwFeecalculator',
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
                FrontendLocalizationUtility::translate(
                    'rkwMailService.notifyAdmin.subject',
                    'RkwFeecalculator'
                )
            );

            $mailService->getQueueMail()->addTemplatePaths($settings['view']['templateRootPaths']);
            $mailService->getQueueMail()->addPartialPaths($settings['view']['partialRootPaths']);

            $mailService->getQueueMail()->setPlaintextTemplate('Email/NotifyAdmin');
            $mailService->getQueueMail()->setHtmlTemplate('Email/NotifyAdmin');

            $attachments = [];

            //  create pdf and attach it to email
            /*
            if ($pdf = $this->pdfService->createPdf($supportRequest)) {
                $attachments[] = $pdf;
            }
            */

            //  create csv and attach it to mail
            if ($csv = $this->csvService->createCsv($supportRequest)) {
                $attachments[] = $csv;
            }

            //  add uploads to mail
            foreach ($supportRequest->getFile() as $fileReference) {

                $attachments[] = [
                    'path' => GeneralUtility::getIndpEnv('TYPO3_DOCUMENT_ROOT') . '/fileadmin/' . $fileReference->getOriginalResource()->getOriginalFile()->getName(),
                    'type' => $fileReference->getOriginalResource()->getOriginalFile()->getMimeType(),
                    'name' => $fileReference->getOriginalResource()->getOriginalFile()->getName(),
                ];

            }

            if (! empty($attachments)) {
                $mailService->getQueueMail()->setAttachment(json_encode($attachments));
            }

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

        return \RKW\RkwBasics\Utility\GeneralUtility::getTyposcriptConfiguration('RkwFeecalculator', $which);
        //===
    }
}
