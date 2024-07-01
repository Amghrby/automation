<?php

namespace Amghrby\Automation\Triggers;

use Illuminate\Support\Facades\Log;

class EventTriggerHandler implements TriggerHandlerInterface
{
    public function handle($params)
    {
        Log::info('EventTriggerHandler handles trigger request from database ' . json_encode($params));
        // TODO: Implement handle() method.
    }
}