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
    },
    $_EXTKEY
);
