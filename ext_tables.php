<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function($extKey)
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'Rkw.RkwFeecalculator',
            'Calculator',
            'RKW FeeCalculator'
        );

        $pluginSignature = str_replace('_', '', $extKey) . '_calculator';

        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
            $pluginSignature,
            'FILE:EXT:' . $extKey . '/Configuration/FlexForms/flexform_feecalculator.xml'
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
            'tx_rkwfeecalculator_domain_model_institution',
            'EXT:rkw_feecalculator/Resources/Private/Language/locallang_csh_tx_rkwfeecalculator_domain_model_institution.xlf'
        );
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages(
            'tx_rkwfeecalculator_domain_model_institution'
        );

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::makeCategorizable(
            $extKey,
            'tx_rkwfeecalculator_domain_model_program'
        );

        if (TYPO3_MODE === 'BE') {

            /**
             * Registers a Backend Module
             */
            \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
                'RKW.' . $extKey,
                'tools',	 // Make module a submodule of 'Web'
                'FeeCalculatorAdmin',	// Submodule key
                '',						// Position
                array(
                    'Backend' => 'index',
                    'BackendCalculator' => 'index,create,store,show,edit,update,delete',
                    'BackendProgram' => 'index,create,store,show,edit,update,delete',
                ),
                array(
                    'access' => 'user,group',
                    'icon'   => 'EXT:' . $extKey . '/ext_icon.gif',
                    'labels' => 'LLL:EXT:' . $extKey . '/Resources/Private/Language/locallang_be.xlf',
                )
            );

        }


    },
    $_EXTKEY
);
