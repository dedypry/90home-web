<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        URL::macro('alternateHasCorrectSignature', function (Request $request, $absolute = true, array $ignoreQuery = []) {
            $ignoreQuery[] = 'signature';

            $absoluteUrl = url($request->path());
            $url = $absolute ? $absoluteUrl : '/' . $request->path();

            $queryString = collect(explode('&', (string) $request->server->get('QUERY_STRING')))
                ->reject(fn($parameter) => in_array(Str::before($parameter, '='), $ignoreQuery))
                ->join('&');

            $original = rtrim($url . '?' . $queryString, '?');

            $key = config('app.key');
            if (empty($key)) {
                throw new \RuntimeException('Application key is not set.');
            }

            $signature = hash_hmac('sha256', $original, $key);
            return hash_equals($signature, (string) $request->query('signature', ''));
        });

        URL::macro('alternateHasValidSignature', function (Request $request, $absolute = true, array $ignoreQuery = []) {
            return URL::alternateHasCorrectSignature($request, $absolute, $ignoreQuery)
                && URL::signatureHasNotExpired($request);
        });

        Request::macro('hasValidSignature', function ($absolute = true, array $ignoreQuery = []) {
            return URL::alternateHasValidSignature($this, $absolute, $ignoreQuery);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
