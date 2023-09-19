<?php

namespace DigitalIndoorsmen\LaravelCometChatAPI;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class LaravelCometChatAPIServiceProvider extends BaseServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('cometchat', function () {

            return new CometChat();
        });
        $this->app->make(CometChat::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $this->publishes([
            __DIR__.'/config/cometchat-api.php' => config_path('cometchat-api.php'),
        ], 'config');
    }
}
