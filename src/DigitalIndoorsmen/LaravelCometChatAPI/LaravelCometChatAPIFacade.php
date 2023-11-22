<?php

namespace DigitalIndoorsmen\LaravelCometChatAPI;

use Illuminate\Support\Facades\Facade;

/**
 * Class LaravelCometChatAPIFacade
 */
class LaravelCometChatAPIFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'cometchat';
    }
}
