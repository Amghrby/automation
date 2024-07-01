<?php

namespace Amghrby\Automation\Actions;

interface ActionHandlerInterface
{
    public function handle($model, $params);
}