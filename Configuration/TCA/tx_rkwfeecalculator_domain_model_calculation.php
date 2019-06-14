<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_calculation',
        'label' => 'name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'name,assigned_programs',
        'iconfile' => 'EXT:rkw_feecalculator/Resources/Public/Icons/tx_rkwfeecalculator_domain_model_calculation.gif',
        'hideTable' => 1
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, calculator, days, consultant_fee_per_day',
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, calculator, days, consultant_fee_per_day, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'special' => 'languages',
                'items' => [
                    [
                        'LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages',
                        -1,
                        'flags-multiple'
                    ]
                ],
                'default' => 0,
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_rkwfeecalculator_domain_model_calculator',
                'foreign_table_where' => 'AND tx_rkwfeecalculator_domain_model_calculator.pid=###CURRENT_PID### AND tx_rkwfeecalculator_domain_model_calculator.sys_language_uid IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        't3ver_label' => [
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
                    ]
                ],
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'size' => 13,
                'eval' => 'datetime',
                'default' => 0,
            ]
        ],
        'endtime' => [
            'exclude' => true,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'size' => 13,
                'eval' => 'datetime',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038)
                ]
            ],
        ],
        'calculator' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_calculation.calculator',
            'config' => [
                'type' => 'select',
                'foreign_table' => 'tx_rkwfeecalculator_domain_model_calculator',
                'foreign_table_where' => 'ORDER BY tx_rkwfeecalculator_domain_model_calculator.name ASC',
                'minitems' => 0,
                'maxitems' => 1,
                'appearance' => [
                    'collapseAll' => 1,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1
                ],
            ],
        ],
        'selected_program' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_calculation.selected_program',
            'config' => [
                'type' => 'select',
                'foreign_table' => 'tx_rkwfeecalculator_domain_model_program',
                'foreign_table_where' => 'ORDER BY tx_rkwfeecalculator_domain_model_program.name ASC',
                'minitems' => 0,
                'maxitems' => 1,
                'appearance' => [
                    'collapseAll' => 1,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1
                ],
            ],
        ],
        'previous_selected_program' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_calculation.previous_selected_program',
            'config' => [
                'type' => 'select',
                'foreign_table' => 'tx_rkwfeecalculator_domain_model_program',
                'foreign_table_where' => 'ORDER BY tx_rkwfeecalculator_domain_model_program.name ASC',
                'minitems' => 0,
                'maxitems' => 1,
                'appearance' => [
                    'collapseAll' => 1,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1
                ],
            ],
        ],
        'days' => [
            'exclude' => true,
            'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_calculation.days',
            'config' => [
                'type' => 'input',
                'size' => 4,
                'eval' => 'int,required'
            ]
        ],
        'consultant_fee_per_day' => [
            'exclude' => true,
            'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_program.consultant_fee_per_day',
            'config' => [
                'type' => 'input',
                'size' => 4,
                'eval' => 'double2,required'
            ]
        ],
    ],
];
