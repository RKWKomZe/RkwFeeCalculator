<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function($extKey)
	{

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'Rkw.RkwFeecalculator',
            'Calculator',
            [
                'FeeCalculator' => 'show'
            ],
            // non-cacheable actions
            [
                'FeeCalculator' => 'show'
            ]
        );

	// wizards
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
		'mod {
			wizards.newContentElement.wizardItems.plugins {
				elements {
					calculator {
						icon = ' . \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($extKey) . 'Resources/Public/Icons/user_plugin_calculator.svg
						title = LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkw_feecalculator_domain_model_calculator
						description = LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkw_feecalculator_domain_model_calculator.description
						tt_content_defValues {
							CType = list
							list_type = rkwfeecalculator_calculator
						}
					}
				}
				show = *
			}
	   }'
	);
    },
    $_EXTKEY
);
