<?php

namespace DigitalIndoorsmen\LaravelCometChatAPI;

use Illuminate\Support\Facades\Facade;

/**
 * Class LaravelCometChatAPIFacade
 *
 * @package DigitalIndoorsmen\LaravelCometChatAPI
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

