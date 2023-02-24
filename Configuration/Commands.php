<?php

return [
    'rkw_feecalculator:send' => [
        'class' => \RKW\RkwFeecalculator\Command\CleanupCommand::class,
        'schedulable' => true,
    ],
    'rkw_feecalculator:security' => [
        'class' => \RKW\RkwFeecalculator\Command\SecurityCommand::class,
        'schedulable' => true,
    ],
];
