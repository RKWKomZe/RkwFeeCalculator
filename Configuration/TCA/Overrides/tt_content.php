<?php
defined('TYPO3_MODE') || die('Access denied.');

//=================================================================
// Register Plugin
//=================================================================
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

//=================================================================
// Add Flexform
//=================================================================
$extKey = 'rkw_feecalculator';

$pluginSignature = str_replace('_', '', $extKey) . '_calculator';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    $pluginSignature,
    'FILE:EXT:' . $extKey . '/Configuration/FlexForms/flexform_feecalculator.xml'
);

//  Flexform
//  Plugin Calculator
$extensionName = strtolower(\TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($extKey));
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