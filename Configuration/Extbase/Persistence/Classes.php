<?php
declare(strict_types = 1);

return [
    \RKW\RkwFeecalculator\Domain\Model\BackendUser::class => [
        'tableName' => 'be_users',
    ],
    \RKW\RkwFeecalculator\Domain\Model\FrontendUser::class => [
        'tableName' => 'fe_users',
    ],
    \RKW\RkwFeecalculator\Domain\Model\File::class => [
        'tableName' => 'sys_file',
    ],
    \RKW\RkwFeecalculator\Domain\Model\FileReference::class => [
        'tableName' => 'sys_file_reference',
        'properties' => [
            'file' => [
                'fieldName' => 'uid_local'
            ],
        ],
    ],
];
