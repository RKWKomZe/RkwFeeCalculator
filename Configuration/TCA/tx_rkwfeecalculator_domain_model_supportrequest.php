<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest',
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
        ],
        'searchFields' => 'name, founderName, address, zip, city, foundation_date, intended_foundation_date, citizenship, birthdate, foundation_location, sales, balance, employees_count, manager, single_representative, pre_tax_deduction, business_purpose, insolvency_proceedings, chamber, company_shares, principal_bank, bic, iban, contact_person_name, contact_person_phone, contact_person_fax, contact_person_mobile, contact_person_email, pre_foundation_employment, pre_foundation_self_employment, consulting_days, consulting_date_from, consulting_date_to, consulting_content, consultant_type, consultant_company, consultant_name1, consultant1_accreditation_number, consultant_name2, consultant2_accreditation_number, consultant_fee, consultant_phone, consultant_email, premature_start, send_documents, bafa_support, de_minimis, support_programme, consulting, company_type',
        'iconfile' => 'EXT:rkw_feecalculator/Resources/Public/Icons/tx_rkwfeecalculator_domain_model_supportrequest.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, name, founderName, address, zip, city, foundation_date, intended_foundation_date, citizenship, birthdate, foundation_location, sales, balance, employees_count, manager, single_representative, pre_tax_deduction, business_purpose, insolvency_proceedings, chamber, company_shares, principal_bank, bic, iban, contact_person_name, contact_person_phone, contact_person_fax, contact_person_mobile, contact_person_email, pre_foundation_employment, pre_foundation_self_employment, consulting_days, consulting_date_from, consulting_date_to, consulting_content, consultant_type, consultant_company, consultant_name1, consultant1_accreditation_number, consultant_name2, consultant2_accreditation_number, consultant_fee, consultant_phone, consultant_email, premature_start, send_documents, bafa_support, de_minimis, support_programme, consulting, company_type',
    ],
    'types' => [
        '1' => [
            'showitem' => '
            sys_language_uid, l10n_parent, l10n_diffsource, hidden, 
            support_programme, name, founderName, address, zip, city, foundation_date, intended_foundation_date, citizenship, birthdate, foundation_location, company_type, balance, sales, employees_count, manager, single_representative, pre_tax_deduction, business_purpose, insolvency_proceedings, chamber, company_shares, principal_bank, bic, iban, contact_person_name, contact_person_phone, contact_person_fax, contact_person_mobile, contact_person_email, pre_foundation_employment, pre_foundation_self_employment, 
            
             --div--;LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.tab.consultation,
            consulting, consulting_days, consulting_date_from, consulting_date_to, consulting_content, 
            
             --div--;LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.tab.consultant,
            consultant_type, consultant_company, consultant_name1, consultant1_accreditation_number, consultant_name2, consultant2_accreditation_number, consultant_fee, consultant_phone, consultant_email, 
            
            --div--;LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.tab.misc,
            premature_start, send_documents, bafa_support, de_minimis 
            '
        ],
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
                'foreign_table' => 'tx_rkwfeecalculator_domain_model_supportrequest',
                'foreign_table_where' => 'AND tx_rkwfeecalculator_domain_model_supportrequest.pid=###CURRENT_PID### AND tx_rkwfeecalculator_domain_model_supportrequest.sys_language_uid IN (-1,0)',
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

        'support_programme' => [
            'exclude' => false,
            'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.supportProgramme',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_rkwfeecalculator_domain_model_program',
                'minitems' => 1,
                'maxitems' => 1,
            ],
        ],
	    'name' => [
            'exclude' => false,
	        'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.name',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim,required'
			],
	    ],
        'founder_name' => [
            'exclude' => false,
            'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.founderName',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ],
        ],
	    'address' => [
            'exclude' => false,
	        'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.address',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim,required'
			],
	    ],
	    'zip' => [
            'exclude' => false,
	        'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.zip',
	        'config' => [
			    'type' => 'input',
			    'size' => 4,
			    'eval' => 'int,required'
			]
	    ],
	    'city' => [
            'exclude' => false,
	        'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.city',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim,required'
			],
	    ],
	    'foundation_date' => [
            'exclude' => false,
	        'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.foundationDate',
            'config' => [
                'type' => 'input',
                'size' => 13,
                'max' => 20,
                'eval' => 'datetime, required',
                'checkbox' => 0,
                'default' => 0,
            ],
	    ],
        'intended_foundation_date' => [
            'exclude' => false,
            'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.intendedFoundationDate',
            'config' => [
                'type' => 'input',
                'size' => 13,
                'max' => 20,
                'eval' => 'datetime, required',
                'checkbox' => 0,
                'default' => 0,
            ],
        ],
        'citizenship' => [
            'exclude' => false,
            'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.citizenship',
            'config' => [
                'type' => 'input',
                'size' => 30,
//			    'eval' => 'trim,required'
            ],
        ],
        'birthdate' => [
            'exclude' => false,
            'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.birthdate',
            'config' => [
                'type' => 'input',
                'size' => 13,
                'max' => 20,
                'eval' => 'datetime',
                'checkbox' => 0,
                'default' => 0,
            ],
        ],
        'foundation_location' => [
            'exclude' => false,
            'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.foundationLocation',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ],
        ],
        'company_type' => [
            'exclude' => false,
            'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.companyType',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_rkwbasics_domain_model_companytype',
            ],
        ],
        'balance' => [
            'exclude' => false,
            'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.balance',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'sales' => [
            'exclude' => false,
	        'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.sales',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'employees_count' => [
            'exclude' => false,
	        'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.employeesCount',
	        'config' => [
			    'type' => 'input',
			    'size' => 4,
			    'eval' => 'int'
			]
	    ],
	    'manager' => [
            'exclude' => false,
	        'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.manager',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim,required'
			],
	    ],
	    'single_representative' => [
            'exclude' => false,
	        'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.singleRepresentative',
            'config'  => array(
                'type'    => 'check',
                'default' => 0,
            ),
	    ],
	    'pre_tax_deduction' => [
	        'exclude' => false,
	        'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.preTaxDeduction',
            'config'  => array(
                'type'    => 'check',
                'default' => 0,
            ),
	    ],
	    'business_purpose' => [
            'exclude' => false,
	        'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.businessPurpose',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim,required'
			],
	    ],
        'insolvency_proceedings' => [
            'exclude' => false,
            'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.insolvencyProceedings',
            'config'  => array(
                'type'    => 'check',
                'default' => 0,
            ),
        ],
        'chamber' => [
            'exclude' => false,
            'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.chamber',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 0,
                'items' => [
                    ['LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.general.pleaseChoose', 0],
                    ['LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.chamber.1', 1],
                    ['LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.chamber.2', 2],
                    ['LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.chamber.3', 3],
                ]
            ]
        ],
	    'company_shares' => [
            'exclude' => false,
	        'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.companyShares',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim,required'
			],
	    ],
	    'principal_bank' => [
            'exclude' => false,
	        'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.principalBank',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'bic' => [
            'exclude' => false,
	        'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.bic',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'iban' => [
            'exclude' => false,
	        'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.iban',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
        'contact_person_name' => [
            'exclude' => false,
            'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.contactPersonName',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ],
        ],
	    'contact_person_phone' => [
            'exclude' => false,
	        'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.contactPersonPhone',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim,required'
			],
	    ],
	    'contact_person_fax' => [
            'exclude' => false,
	        'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.contactPersonFax',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
        'contact_person_mobile' => [
            'exclude' => false,
            'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.contactPersonMobile',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
	    'contact_person_email' => [
            'exclude' => false,
	        'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.contactPersonEmail',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim,required'
			],
	    ],
	    'pre_foundation_employment' => [
            'exclude' => false,
	        'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.preFoundationEmployment',
	        'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 0,
                'items' => [
                    ['LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.general.pleaseChoose', 0],
                    ['LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.preFoundationEmployment.employed', 1],
                    ['LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.preFoundationEmployment.unemployed', 2],
                    ['LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.preFoundationEmployment.in_education', 3],
                    ['LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.preFoundationEmployment.self_employed', 4],
                ]
			]
	    ],
	    'pre_foundation_self_employment' => [
            'exclude' => false,
	        'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.preFoundationSelfEmployment',
	        'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 0,
                'items' => [
                    ['LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.general.pleaseChoose', 0],
                    ['LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.preFoundationSelfEmployment.no', 1],
                    ['LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.preFoundationSelfEmployment.part_time', 2],
                    ['LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.preFoundationSelfEmployment.full_time', 3],
                    ['LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.preFoundationSelfEmployment.shareholder', 4],
                ]
			]
	    ],
        'consulting' => [
            'exclude' => false,
            'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_program.consulting',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_rkwfeecalculator_domain_model_consulting',
            ],
        ],
        'consulting_days' => [
            'exclude' => false,
            'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.consultingDays',
            'config' => [
                'type' => 'input',
                'size' => 13,
                'eval' => 'trim'
            ],
        ],
	    'consulting_date_from' => [
            'exclude' => false,
	        'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.consultingDateFrom',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ],
	    ],
	    'consulting_date_to' => [
            'exclude' => false,
	        'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.consultingDateTo',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ],
	    ],
	    'consulting_content' => [
            'exclude' => false,
	        'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.consultingContent',
	        'config' => [
			    'type' => 'text',
			    'cols' => 40,
			    'rows' => 15,
			    'eval' => 'trim,required'
			]
	    ],
        'consultant_type' => [
            'exclude' => false,
	        'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.consultantType',
	        'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 0,
                'items' => [
                    ['LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.general.pleaseChoose', 0],
                    ['LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.consultantType.1', 1],
                    ['LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.consultantType.2', 2],
                    ['LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.consultantType.3', 3],
                ],
                'eval' => 'required'
			]
	    ],
	    'consultant_company' => [
            'exclude' => false,
	        'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.consultantCompany',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'consultant_name1' => [
            'exclude' => false,
	        'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.consultantName1',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
        'consultant1_accreditation_number' => [
            'exclude' => false,
            'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.consultant1AccreditationNumber',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
	    'consultant_name2' => [
            'exclude' => false,
	        'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.consultantName2',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'consultant2_accreditation_number' => [
            'exclude' => false,
	        'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.consultant2AccreditationNumber',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'consultant_fee' => [
            'exclude' => false,
	        'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.consultantFee',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'consultant_phone' => [
            'exclude' => false,
	        'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.consultantPhone',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'consultant_email' => [
            'exclude' => false,
	        'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.consultantEmail',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'premature_start' => [
            'exclude' => false,
	        'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.prematureStart',
            'config'  => array(
                'type'    => 'check',
                'default' => 0,
            ),
	    ],
	    'send_documents' => [
            'exclude' => false,
	        'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.sendDocuments',
	        'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 0,
                'items' => [
                    ['LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.general.pleaseChoose', 0],
                    ['LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.sendDocuments.1', 1],
                    ['LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.sendDocuments.2', 2],
                ]
			]
	    ],
        'bafa_support' => [
            'exclude' => false,
            'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.bafaSupport',
            'config'  => array(
                'type'    => 'check',
                'default' => 0,
            ),
        ],
        'de_minimis' => [
            'exclude' => false,
            'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.deMinimis',
            'config'  => array(
                'type'    => 'check',
                'default' => 0,
            ),
        ],
        'privacy' => [
            'exclude' => false,
            'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.privacy',
            'config' => [
                'type' => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
                    ]
                ],
            ],
        ],
        'terms' => [
            'exclude' => false,
            'label' => 'LLL:EXT:rkw_feecalculator/Resources/Private/Language/locallang_db.xlf:tx_rkwfeecalculator_domain_model_supportrequest.terms',
            'config' => [
                'type' => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
                    ]
                ],
            ],
        ],
    ],
];
