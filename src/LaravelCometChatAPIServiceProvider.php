<?php

namespace DigitalIndoorsmen\LaravelCometChatAPI;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class LaravelCometChatAPIServiceProvider extends BaseServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('cometchat', function () {

            return new CometChat();
        });
        $this->app->make(CometChat::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Publishes the configuration file when 'vendor:publish' is run
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/config/cometchat.php' => config_path('cometchat.php'),
            ], 'config');
        }
    }
}
