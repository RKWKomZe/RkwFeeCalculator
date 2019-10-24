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
    'state'            => 'beta',
    'internal'         => '',
    'uploadfolder'     => '0',
    'createDirs'       => '',
    'clearCacheOnLoad' => 0,
    'version'          => '7.6.9',
    'constraints'      => [
        'depends'   => [
            'typo3' => '7.6.0-7.6.99',
            'rkw_registration' => '8.7.0-8.7.99',
            'rkw_mailer' => '8.7.0-8.7.99',
            'rkw_basics' => '8.7.8-8.7.99',
        ],
        'conflicts' => [],
        'suggests'  => [],
    ],
];
