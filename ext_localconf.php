<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function($extKey)
	{
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'Rkw.RkwFeecalculator',
            'Calculator',
            [
                'Calculation' => 'show,store'
            ],
            // non-cacheable actions
            [
                'Calculation' => 'show,store'
            ]
        );
    },
    $_EXTKEY
);
