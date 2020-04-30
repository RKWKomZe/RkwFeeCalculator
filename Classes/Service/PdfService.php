<?php

namespace RKW\RkwFeecalculator\Service;

use Spipu\Html2Pdf\Html2Pdf;
use RKW\RkwBasics\Helper\Common;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;
use RKW\RkwFeecalculator\Domain\Model\SupportRequest;
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
 * PdfService
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwFeecalculator
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class PdfService implements \TYPO3\CMS\Core\SingletonInterface
{

    /**
     * @var \RKW\RkwFeecalculator\Service\LayoutService
     * @inject
     */
    protected $layoutService;

    /**
     * @param \RKW\RkwFeecalculator\Domain\Model\SupportRequest $supportRequest
     *
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     * @throws \TYPO3\CMS\Fluid\View\Exception\InvalidTemplateResourceException
     */
    public function createPdf(SupportRequest $supportRequest)
    {

        try {

            $settingsFramework = Common::getTyposcriptConfiguration($this->extensionName, ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);

            if ($settingsFramework) {

                /** @var \TYPO3\CMS\Fluid\View\StandaloneView $standaloneView */
                $standaloneView = GeneralUtility::makeInstance(\TYPO3\CMS\Fluid\View\StandaloneView::class);
                $standaloneView->setLayoutRootPaths(array(GeneralUtility::getFileAbsFileName($settingsFramework['view']['layoutRootPaths'][0])));
                $standaloneView->setPartialRootPaths(array(GeneralUtility::getFileAbsFileName($settingsFramework['view']['partialRootPaths'][0])));
                $standaloneView->setTemplateRootPaths(array(GeneralUtility::getFileAbsFileName($settingsFramework['view']['templateRootPaths'][0])));
                $standaloneView->setTemplate('SupportRequest/Pdf.html');
                $standaloneView->assign('supportRequest', $supportRequest);
                $standaloneView->assign('supportProgramme', $supportRequest->getSupportProgramme());

                $fieldsets = $this->layoutService->getFields($supportRequest->getSupportProgramme());

                $standaloneView->assign('applicant', $fieldsets['applicant']);
                $standaloneView->assign('consulting', $fieldsets['consulting']);
                $standaloneView->assign('misc', $fieldsets['misc']);

                ob_start();

                $content = $standaloneView->render();

                ob_end_clean();

                $html2pdf = new Html2Pdf('P', 'A4', 'de', true, 'UTF-8', 0);
                $html2pdf->pdf->IncludeJS("print(true);");  //  force printer dialog
                $html2pdf->parsingCss;
                $html2pdf->writeHTML($content);

                $fileName = 'Beratungsanfrage-' . date('Y-m-d-Hi') . '.pdf';

                // Show for Ending "D", "F" or "S": https://github.com/spipu/html2pdf/blob/master/doc/output.md
                // -> "D" - Forcing the download of PDF via web browser, with a specific name
                // $html2pdf->output($_SERVER['DOCUMENT_ROOT'] . $fileName, 'F');
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

            $html2pdf->clean();

            $formatter = new ExceptionFormatter($e);
            echo $formatter->getHtmlMessage();
        }
    }

}