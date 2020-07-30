<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class APIResponseType extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('api_success', function ($value) {
            return Response::json([
                'success' => true,
                'data' => $value,
            ], 201);
        });
        Response::macro('api_fail', function ($value) {
            return Response::json([
                'success' => false,
                'data' => $value,
            ], 401);
        });
    }
}
