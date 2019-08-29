<?php
return [
    'ctrl'      => [
        'title'                    => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_program',
        'label'                    => 'name',
        'tstamp'                   => 'tstamp',
        'crdate'                   => 'crdate',
        'cruser_id'                => 'cruser_id',
        'sortby'                   => 'sorting',
        'versioningWS'             => true,
        'languageField'            => 'sys_language_uid',
        'transOrigPointerField'    => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete'                   => 'deleted',
        'enablecolumns'            => [
            'disabled'  => 'hidden',
            'starttime' => 'starttime',
            'endtime'   => 'endtime',
        ],
        'searchFields'             => 'name,company_age,possible_days_min,possible_days_max,conditions,content,rkw_fee_per_day,consultant_fee_per_day_limit,consultant_subvention_limit, rkw_fee_per_day_as_limit,miscellaneous,funding_factor,institution,can_start_prematurely,consulting',
        'iconfile'                 => 'EXT:rkw_feecalculator/Resources/Public/Icons/tx_rkwfeecalculator_domain_model_program.gif',
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, name, company_age, possible_days_min, possible_days_max, conditions, content, rkw_fee_per_day, consultant_fee_per_day_limit, consultant_subvention_limit, rkw_fee_per_day_as_limit, miscellaneous, funding_factor, institution, can_start_prematurely, consulting',
    ],
    'types'     => [
        '1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, name, company_age, possible_days_min, possible_days_max, conditions, content, rkw_fee_per_day, consultant_fee_per_day_limit, consultant_subvention_limit, rkw_fee_per_day_as_limit, miscellaneous, funding_factor, institution, can_start_prematurely, consulting, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
    ],
    'columns'   => [
        'sys_language_uid'             => [
            'exclude' => true,
            'label'   => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
            'config'  => [
                'type'       => 'select',
                'renderType' => 'selectSingle',
                'special'    => 'languages',
                'items'      => [
                    [
                        'LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages',
                        -1,
                        'flags-multiple',
                    ],
                ],
                'default'    => 0,
            ],
        ],
        'l10n_parent'                  => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude'     => true,
            'label'       => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
            'config'      => [
                'type'                => 'select',
                'renderType'          => 'selectSingle',
                'items'               => [
                    ['', 0],
                ],
                'foreign_table'       => 'tx_rkwfeecalculator_domain_model_program',
                'foreign_table_where' => 'AND tx_rkwfeecalculator_domain_model_program.pid=###CURRENT_PID### AND tx_rkwfeecalculator_domain_model_program.sys_language_uid IN (-1,0)',
            ],
        ],
        'l10n_diffsource'              => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        't3ver_label'                  => [
            'label'  => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max'  => 255,
            ],
        ],
        'hidden'                       => [
            'exclude' => true,
            'label'   => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config'  => [
                'type'  => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled',
                    ],
                ],
            ],
        ],
        'starttime'                    => [
            'exclude'   => true,
            'l10n_mode' => 'mergeIfNotBlank',
            'label'     => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
            'config'    => [
                'type'    => 'input',
                'size'    => 13,
                'eval'    => 'datetime',
                'default' => 0,
            ],
        ],
        'endtime'                      => [
            'exclude'   => true,
            'l10n_mode' => 'mergeIfNotBlank',
            'label'     => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
            'config'    => [
                'type'    => 'input',
                'size'    => 13,
                'eval'    => 'datetime',
                'default' => 0,
                'range'   => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038),
                ],
            ],
        ],
        'name'                         => [
            'exclude' => false,
            'label'   => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_program.name',
            'config'  => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required',
            ],
        ],
        'company_age'                  => [
            'exclude' => false,
            'label'   => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_program.company_age',
            'config'  => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required',
            ],
        ],
        'possible_days_min'            => [
            'exclude' => false,
            'label'   => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_program.possible_days_min',
            'config'  => [
                'type' => 'input',
                'size' => 4,
                'eval' => 'int,required',
            ],
        ],
        'possible_days_max'            => [
            'exclude' => false,
            'label'   => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_program.possible_days_max',
            'config'  => [
                'type' => 'input',
                'size' => 4,
                'eval' => 'int,required',
            ],
        ],
        'conditions'                   => [
            'exclude' => false,
            'label'   => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_program.conditions',
            'config'  => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim,required',
            ],
        ],
        'content'                      => [
            'exclude' => false,
            'label'   => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_program.content',
            'config'  => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim,required',
            ],
        ],
        'rkw_fee_per_day'              => [
            'exclude' => false,
            'label'   => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_program.rkw_fee_per_day',
            'config'  => [
                'type' => 'input',
                'size' => 4,
                'eval' => 'double2,required',
            ],
        ],
        'consultant_fee_per_day_limit' => [
            'exclude' => false,
            'label'   => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_program.consultant_fee_per_day_limit',
            'config'  => [
                'type'    => 'input',
                'size'    => 30,
                'eval'    => 'required',
                'default' => '0.0000000000',
            ],
        ],
        'consultant_subvention_limit'  => [
            'exclude' => false,
            'label'   => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_program.consultant_subvention_limit',
            'config'  => [
                'type'    => 'input',
                'size'    => 30,
                'eval'    => 'required',
                'default' => '0.0000000000',
            ],
        ],
        'rkw_fee_per_day_as_limit'     => array(
            'exclude' => false,
            'label'   => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_program.rkw_fee_per_day_as_limit',
            'config'  => array(
                'type'    => 'check',
                'default' => 0,
            ),
        ),
        'miscellaneous'                => [
            'exclude' => false,
            'label'   => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_program.miscellaneous',
            'config'  => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
            ],
        ],
        'funding_factor'               => [
            'exclude' => false,
            'label'   => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_program.funding_factor',
            'config'  => [
                'type'    => 'input',
                'size'    => 30,
                'eval'    => 'double2,required',
                'default' => '1.0',
            ],
        ],
        'institution'                  => [
            'exclude' => false,
            'label'   => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_program.institution',
            'config'  => [
                'type'                => 'select',
                'renderType'          => 'selectSingle',
                'foreign_table'       => 'tx_rkwfeecalculator_domain_model_institution',
                'foreign_table_where' => 'ORDER BY tx_rkwfeecalculator_domain_model_institution.name ASC',
                'minitems'            => 0,
                'maxitems'            => 1,
                'appearance'          => [
                    'collapseAll'                     => 1,
                    'levelLinksPosition'              => 'top',
                    'showSynchronizationLink'         => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink'         => 1,
                ],
            ],
        ],
        'can_start_prematurely'     => array(
            'exclude' => false,
            'label'   => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_program.can_start_prematurely',
            'config'  => array(
                'type'    => 'check',
                'default' => 0,
            ),
        ),
        'consulting' => [
            'exclude' => false,
            'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_program.consulting',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_rkwfeecalculator_domain_model_consulting',
                'foreign_field' => 'support_programme',
                'maxitems'      => 9999,
                'appearance' => [
                    'collapseAll' => 0,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1
                ],
            ],
        ],
        'calculator' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
    ],
];
