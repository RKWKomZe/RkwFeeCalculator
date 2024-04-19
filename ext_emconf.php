<?php

/***************************************************************
 * Extension Manager/Repository config file for ext: "rkw_feecalculator"
 *
 * Auto generated by Extension Builder 2019-05-30
 *
 * Manual updates:
 * Only the data in the array - anything else is removed by next write.
 * "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = [
    'title'            => 'RKW FeeCalculator',
    'description'      => 'Extension for calculating consulting fees and providing support request forms',
    'category'         => 'plugin',
    'author'           => 'Christian Dilger',
    'author_email'     => 'c.dilger@addorange.de',
    'state'            => 'stable',
    'internal'         => '',
    'uploadfolder'     => '0',
    'clearCacheOnLoad' => 0,
    'version'          => '9.5.0',
    'constraints'      => [
        'depends'   => [
            'typo3' => '10.4.0-10.4.99',
            'core_extended' => '10.4.0-12.4.99',
            'fe_register' => '10.4.0-12.4.99',
            'postmaster' => '10.4.0-12.4.99',
            'rkw_basics' => '10.4.0-12.4.99',
        ],
        'conflicts' => [],
        'suggests'  => [],
    ],
];
