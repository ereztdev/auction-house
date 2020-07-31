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
        Response::macro('api_success', function ($value, $message) {
            return Response::json([
                'success' => true,
                'message' => $message,
                'data' => $value,
            ], 200);
        });
        Response::macro('api_fail', function ($value, $message) {
            return Response::json([
                'success' => false,
                'message' => $message,
                'data' => $value,
            ], 401);
        });
    }
}
