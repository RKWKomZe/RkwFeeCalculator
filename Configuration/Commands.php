<?php

return [
    'rkw_feecalculator:fileCleanup' => [
        'class' => \RKW\RkwFeecalculator\Command\FileCleanupCommand::class,
        'schedulable' => true,
    ],
    'rkw_feecalculator:security' => [
        'class' => \RKW\RkwFeecalculator\Command\SecurityCommand::class,
        'schedulable' => true,
    ],
];
