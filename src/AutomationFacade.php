<?php

namespace Amghrby\Automation;

use Illuminate\Support\Facades\Facade;


class AutomationFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'automation';
    }
}
