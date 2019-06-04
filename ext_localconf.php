<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function($extKey)
	{
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'Rkw.RkwFeecalculator',
            'Calculator',
            [
                'FeeCalculator' => 'show,store'
            ],
            // non-cacheable actions
            [
                'FeeCalculator' => 'show,store'
            ]
        );
    },
    $_EXTKEY
);
