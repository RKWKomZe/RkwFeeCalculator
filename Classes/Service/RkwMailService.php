<?php

namespace RKW\RkwFeecalculator\Service;

use RKW\RkwBasics\Helper\Common;
use RKW\RkwFeecalculator\Domain\Model\SupportRequest;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Html2Pdf;
use TYPO3\CMS\Core\Utility\GeneralUtility;
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
     * Sends an E-Mail to a Frontend-User
     *
     * @param \RKW\RkwRegistration\Domain\Model\FrontendUser $frontendUser
     * @param \RKW\RkwFeecalculator\Domain\Model\SupportRequest $supportRequest
     *
     * @throws \RKW\RkwMailer\Service\MailException
     * @throws \TYPO3\CMS\Extbase\Persistence\Generic\Exception
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Fluid\View\Exception\InvalidTemplateResourceException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException
     */
    public function userMail(\RKW\RkwRegistration\Domain\Model\FrontendUser $frontendUser, \RKW\RkwFeecalculator\Domain\Model\SupportRequest $supportRequest)
    {
        // get settings
        $settings = $this->getSettings(ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
        $settingsDefault = $this->getSettings();

        if ($frontendUser->getEmail() && $settings['view']['templateRootPaths'][0]) {

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
                    'rkw_feecalculator',
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
     * @throws \TYPO3\CMS\Fluid\View\Exception\InvalidTemplateResourceException
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

            /** @var \RKW\RkwMailer\Service\MailService $mailService */
            $mailService = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwMailer\\Service\\MailService');

            foreach ($recipients as $recipient) {
                if (
                    ($recipient instanceof \RKW\RkwFeecalculator\Domain\Model\BackendUser)
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
                            'rkw_feecalculator',
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
                    'rkwMailService.notifyAdmin.subject',
                    'rkw_feecalculator',
                    null,
                    'de'
                )
            );

            $mailService->getQueueMail()->addTemplatePaths($settings['view']['templateRootPaths']);
            $mailService->getQueueMail()->addPartialPaths($settings['view']['partialRootPaths']);

            $mailService->getQueueMail()->setPlaintextTemplate('Email/NotifyAdmin');
            $mailService->getQueueMail()->setHtmlTemplate('Email/NotifyAdmin');

            //  create pdf and attach it to email
            if ($attachment = $this->createPdf($supportRequest)) {

                $mailService->getQueueMail()->setAttachment($attachment);
                $mailService->getQueueMail()->setAttachmentType('application/pdf');
                $mailService->getQueueMail()->setAttachmentName('beratungsanfrage.pdf');

            }

            if (count($mailService->getTo())) {
                $mailService->send();
            }
        }
    }

    /**
     * @param SupportRequest $supportRequest
     */
    protected function createPdf(SupportRequest $supportRequest)
    {

        try {
            if ($settingsFramework = $this->getSettings(ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK)) {

                /** @var \TYPO3\CMS\Fluid\View\StandaloneView $standaloneView */
                $standaloneView = GeneralUtility::makeInstance(\TYPO3\CMS\Fluid\View\StandaloneView::class);
                $standaloneView->setLayoutRootPaths(array(GeneralUtility::getFileAbsFileName($settingsFramework['view']['layoutRootPaths'][0])));
                $standaloneView->setPartialRootPaths(array(GeneralUtility::getFileAbsFileName($settingsFramework['view']['partialRootPaths'][0])));
                $standaloneView->setTemplateRootPaths(array(GeneralUtility::getFileAbsFileName($settingsFramework['view']['templateRootPaths'][0])));
                $standaloneView->setTemplate('SupportRequest/Pdf.html');
                $standaloneView->assign('supportRequest', $supportRequest);

                $content = $standaloneView->render();

                $html2pdf = new Html2Pdf('P', 'A4', 'de', true, 'UTF-8', 0);
                $html2pdf->parsingCss;
                $html2pdf->writeHTML($content);

                $fileName = 'Beratungsanfrage-' . date('Y-m-d-Hi') . '.pdf';

                ob_clean();

                // Show for Ending "D", "F" or "S": https://github.com/spipu/html2pdf/blob/master/doc/output.md
                // -> "D" - Forcing the download of PDF via web browser, with a specific name
                //  $html2pdf->output($_SERVER['DOCUMENT_ROOT'] . $fileName, 'F');
                return $html2pdf->output($fileName, 'S');

                // do not use "exit" here. Is making trouble (provides a unnamed "binary"-file instead a names pdf)
                //  readfile($fileName);
                //  echo $html2pdf->output();
                //  aber dadurch wird das Formular nicht weitergeleitet, das muss ich verhindern!
                //  hmm, liefert jetzt ein binary, dass ich auf .pdf umbenenne und siehe da, es hat den inhalt, aber warum nimmt es nicht den namen.
                //  Lösung: Siehe https://stackoverflow.com/questions/41282745/how-to-disable-save-changes-dialog-in-adobe-reader-create-pdf-using-tcpdf/41289131#41289131
                //  exit();
                //===
            }

        } catch (Html2PdfException $e) {

            /*
            $this->getLogger()->log(\TYPO3\CMS\Core\Log\LogLevel::ERROR, sprintf('An error occurred while trying to generate a PDF. Message: %s', str_replace(array("\n", "\r"), '', $e->getMessage())));
            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('ecosystemController.message.error.somethingWentWrong', 'rkw_ecosystem'),
                '',
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
            );
            $this->redirect('edit', null, null, array('ecosystemId' => $ecosystem->getUid()));
            //===
            */
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

        return Common::getTyposcriptConfiguration('Rkwfeecalculator', $which);
        //===
    }
}
