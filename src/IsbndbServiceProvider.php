<?php

declare(strict_types=1);

namespace Verbanent\Isbndb\Laravel;

use Illuminate\Support\ServiceProvider;
use Nyholm\Psr7\Factory\Psr17Factory;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\Psr18Client;
use Verbanent\Isbndb\IsbndbClient;

final class IsbndbServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/isbndb.php', 'isbndb');

        $this->app->singleton(IsbndbClient::class, function ($app) {
            $cfg = $app['config']->get('isbndb', []);

            $apiKey  = (string) ($cfg['api_key'] ?? '');
            $timeout = (float) ($cfg['timeout'] ?? 10.0);

            $symfonyHttp = HttpClient::create([
                'timeout' => $timeout,
            ]);

            $psr18 = new Psr18Client($symfonyHttp);
            $psr17 = new Psr17Factory();

            return new IsbndbClient(
                http: $psr18,
                requests: $psr17,
                apiKey: $apiKey,
            );
        });
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/isbndb.php' => config_path('isbndb.php'),
        ], 'isbndb-config');
    }
}
