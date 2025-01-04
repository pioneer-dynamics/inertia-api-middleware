<?php

namespace App\Providers;

use Inertia\Support\Header;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class InertiaApiServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->addIsApiMacroToRequest();
    }

    private function addIsApiMacroToRequest()
    {
        $request = app(Request::class);

        $request->macro('isApi', function () use ($request) {
            return $request->routeIs('api.*');
        });

        $request->macro('isInertia', function () use ($request) {
            return !$request->routeIs('api.*') && $request->header(Header::INERTIA);
        });

        $request->macro('isNormal', function () use ($request) {
            return !$request->routeIs('api.*') && !$request->header(Header::INERTIA);
        });
    }
}
