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

        //=================================================================
        // Add XClasses for extending existing classes
        // ATTENTION: deactivated due to faulty mapping in TYPO3 9.5
        //=================================================================
        /*
        // for TYPO3 12+
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\Madj2k\FeRegister\Domain\Model\FrontendUser::class] = [
            'className' => \RKW\RkwFeecalculator\Domain\Model\FrontendUser::class
        ];

        // for TYPO3 9.5 - 11.5 only, not required for TYPO3 12
        \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Object\Container\Container::class)
            ->registerImplementation(
                \Madj2k\FeRegister\Domain\Model\FrontendUser::class,
                \RKW\RkwFeecalculator\Domain\Model\FrontendUser::class
            );

        // for TYPO3 12+
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\Madj2k\FeRegister\Domain\Model\BackendUser::class] = [
            'className' => \RKW\RkwFeecalculator\Domain\Model\BackendUser::class
        ];

        // for TYPO3 9.5 - 11.5 only, not required for TYPO3 12
        \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Object\Container\Container::class)
            ->registerImplementation(
                \Madj2k\FeRegister\Domain\Model\BackendUser::class,
                \RKW\RkwFeecalculator\Domain\Model\BackendUser::class
            );
        */

    },
    'rkw_feecalculator'
);
