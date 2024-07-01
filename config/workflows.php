<?php

return [
    'observed_models' => [
        // Add the fully qualified class names of the models you want to observe
        App\Models\User::class,
        // App\Models\AnotherModel::class,
    ],
    'triggers' => [
        'event' => \Amghrby\Automation\Triggers\EventTriggerHandler::class,
        'date' => \Amghrby\Automation\Triggers\DateTriggerHandler::class,
        // Add more triggers here
    ],
    'actions' => [
        'dynamic_update' => \Amghrby\Automation\Actions\DynamicUpdateActionHandler::class,
        'dynamic_notify' => \Amghrby\Automation\Actions\DynamicNotifyActionHandler::class,
        // Add more actions here
    ],
];
