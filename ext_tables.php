<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function($extKey)
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'Rkw.RkwFeecalculator',
            'Calculator',
            'FeeCalculator - Calculator'
        );

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($extKey, 'Configuration/TypoScript', 'RKW FeeCalculator');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_rkwfeecalculator_domain_model_calculator', 'EXT:rkw_feecalculator/Resources/Private/Language/locallang_csh_tx_rkwfeecalculator_domain_model_calculator.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_rkwfeecalculator_domain_model_calculator');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_rkwfeecalculator_domain_model_program', 'EXT:rkw_feecalculator/Resources/Private/Language/locallang_csh_tx_rkwfeecalculator_domain_model_program.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_rkwfeecalculator_domain_model_program');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_rkwfeecalculator_domain_model_institution', 'EXT:rkw_feecalculator/Resources/Private/Language/locallang_csh_tx_rkwfeecalculator_domain_model_institution.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_rkwfeecalculator_domain_model_institution');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::makeCategorizable(
            $extKey,
            'tx_rkwfeecalculator_domain_model_program'
        );

    },
    $_EXTKEY
);
