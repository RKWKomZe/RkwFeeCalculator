<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function ($extKey) {

        //=================================================================
        // Configure Plugin
        //=================================================================
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'RKW.RkwFeecalculator',
            'Calculator',
            [
                'Calculation' => 'show,store',
            ],
            // non-cacheable actions
            [
                'Calculation' => 'show,store',
            ]
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'RKW.RkwFeecalculator',
            'Request',
            [
                'SupportRequest' => 'new, requestForm, create'
            ],
            // non-cacheable actions
            [
                'SupportRequest' => 'new, requestForm, create'
            ]
        );

        //=================================================================
        // Register CommandController
        //=================================================================
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][] = 'RKW\\RkwFeecalculator\\Controller\\SupportRequestCommandController';

        //=================================================================
        // Register SignalSlots
        //=================================================================
        /**
         * @var \TYPO3\CMS\Extbase\SignalSlot\Dispatcher $signalSlotDispatcher
         */
        $signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class);

        $signalSlotDispatcher->connect(
            RKW\RkwFeecalculator\Controller\SupportRequestController::class,
            \RKW\RkwFeecalculator\Controller\SupportRequestController::SIGNAL_AFTER_REQUEST_CREATED_USER,
            RKW\RkwFeecalculator\Service\RkwMailService::class,
            'userMail'
        );

        $signalSlotDispatcher->connect(
            RKW\RkwFeecalculator\Controller\SupportRequestController::class,
            \RKW\RkwFeecalculator\Controller\SupportRequestController::SIGNAL_AFTER_REQUEST_CREATED_ADMIN,
            RKW\RkwFeecalculator\Service\RkwMailService::class,
            'adminMail'
        );
    },
    $_EXTKEY
);
