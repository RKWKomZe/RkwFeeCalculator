<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_program',
        'label' => 'name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'sortby' => 'sorting',
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
        'searchFields' => 'name,formula,responsible_institution,company_age,possible_days_min,possible_days_max,conditions,content,rkw_fee_per_day,miscellaneous,institution',
        'iconfile' => 'EXT:rkw_feecalculator/Resources/Public/Icons/tx_rkwfeecalculator_domain_model_program.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, name, formula, responsible_institution, company_age, possible_days_min, possible_days_max, conditions, content, rkw_fee_per_day, miscellaneous, institution',
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, name, formula, responsible_institution, company_age, possible_days_min, possible_days_max, conditions, content, rkw_fee_per_day, miscellaneous, institution, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
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
                'foreign_table' => 'tx_rkwfeecalculator_domain_model_program',
                'foreign_table_where' => 'AND tx_rkwfeecalculator_domain_model_program.pid=###CURRENT_PID### AND tx_rkwfeecalculator_domain_model_program.sys_language_uid IN (-1,0)',
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
        'name' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_program.name',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim,required'
			],
	    ],
	    'formula' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_program.formula',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'responsible_institution' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_program.responsible_institution',
	        'config' => [
			    'type' => 'select',
			    'renderType' => 'selectSingle',
			    'items' => [
			        ['-- Label --', 0],
			    ],
			    'size' => 1,
			    'maxitems' => 1,
			    'eval' => 'required'
			],
	    ],
	    'company_age' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_program.company_age',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim,required'
			],
	    ],
	    'possible_days_min' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_program.possible_days_min',
	        'config' => [
			    'type' => 'input',
			    'size' => 4,
			    'eval' => 'int,required'
			]
	    ],
	    'possible_days_max' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_program.possible_days_max',
	        'config' => [
			    'type' => 'input',
			    'size' => 4,
			    'eval' => 'int,required'
			]
	    ],
	    'conditions' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_program.conditions',
	        'config' => [
			    'type' => 'text',
			    'cols' => 40,
			    'rows' => 15,
			    'eval' => 'trim,required'
			]
	    ],
	    'content' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_program.content',
	        'config' => [
			    'type' => 'text',
			    'cols' => 40,
			    'rows' => 15,
			    'eval' => 'trim,required'
			]
	    ],
	    'rkw_fee_per_day' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_program.rkw_fee_per_day',
	        'config' => [
			    'type' => 'input',
			    'size' => 4,
			    'eval' => 'int,required'
			]
	    ],
	    'miscellaneous' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_program.miscellaneous',
	        'config' => [
			    'type' => 'text',
			    'cols' => 40,
			    'rows' => 15,
			    'eval' => 'trim'
			]
	    ],
	    'institution' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_program.institution',
	        'config' => [
			    'type' => 'inline',
			    'foreign_table' => 'tx_rkwfeecalculator_domain_model_institution',
			    'minitems' => 0,
			    'maxitems' => 1,
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
