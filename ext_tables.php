<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function ($extKey) {

        $extensionName = strtolower(\TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($extKey));

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'RKW.RkwFeecalculator',
            'Calculator',
            'RKW FeeCalculator'
        );


        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'RKW.RkwFeecalculator',
            'Request',
            'Rkw FeeCalculator: Antragsformular (Förderprogramm)'
        );

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
            $extKey,
            'Configuration/TypoScript',
            'RKW FeeCalculator'
        );

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
            'tx_rkwfeecalculator_domain_model_calculator',
            'EXT:rkw_feecalculator/Resources/Private/Language/locallang_csh_tx_rkwfeecalculator_domain_model_calculator.xlf'
        );
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages(
            'tx_rkwfeecalculator_domain_model_calculator'
        );

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
            'tx_rkwfeecalculator_domain_model_program',
            'EXT:rkw_feecalculator/Resources/Private/Language/locallang_csh_tx_rkwfeecalculator_domain_model_program.xlf'
        );
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages(
            'tx_rkwfeecalculator_domain_model_program'
        );

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
            'tx_rkwfeecalculator_domain_model_consulting',
            'EXT:rkw_feecalculator/Resources/Private/Language/locallang_csh_tx_rkwfeecalculator_domain_model_consulting.xlf'
        );
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages(
            'tx_rkwfeecalculator_domain_model_consulting'
        );

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
            'tx_rkwmanagementconsultancy_domain_model_supportrequest',
            'EXT:rkw_feecalculator/Resources/Private/Language/locallang_csh_tx_rkwmanagementconsultancy_domain_model_supportrequest.xlf'
        );
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages(
            'tx_rkwmanagementconsultancy_domain_model_supportrequest'
        );

        //  Flexform
        //  Plugin Calculator
        $pluginSignature = $extensionName.'_'.strtolower('Calculator');

        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
            $pluginSignature,
            'FILE:EXT:' . $extKey . '/Configuration/FlexForms/flexform_feecalculator.xml'
        );

        //  Plugin Request
        $pluginSignature = $extensionName.'_'.strtolower('Request');

        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,select_key,pages';
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
            $pluginSignature,
            'FILE:EXT:' . $extKey . '/Configuration/FlexForms/Request.xml');


    },
    $_EXTKEY
);
