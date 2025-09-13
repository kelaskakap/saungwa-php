<?php

namespace Kelaskakap\SaungwaPhp\Laravel;

use Illuminate\Support\ServiceProvider;
use Kelaskakap\SaungwaPhp\Config;
use Kelaskakap\SaungwaPhp\Http\GuzzleHttpClient;
use Kelaskakap\SaungwaPhp\SaungwaClient;
use Saungwa\Contracts\HttpClientInterface;

class SaungwaServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/saungwa.php', 'saungwa');

        $this->app->singleton(SaungwaClient::class, function ($app)
        {
            $cfg = $app['config']['saungwa'];
            $config = new Config($cfg['appkey'], $cfg['authkey'], $cfg['base_uri'] ?? 'https://app.saungwa.com/api', $cfg['sandbox'] ?? false);

            // create Guzzle wrapper that conforms to our interface
            $http = new GuzzleHttpClient($config->getBaseUri(), $cfg['guzzle'] ?? []);
            return new SaungwaClient($config, $http);
        });

        // optional alias
        $this->app->alias(SaungwaClient::class, 'saungwa.client');
    }

    public function boot()
    {
        if ($this->app->runningInConsole())
        {
            $this->publishes([
                __DIR__ . '/../config/saungwa.php' => config_path('saungwa.php'),
            ], 'config');
        }
    }
}
