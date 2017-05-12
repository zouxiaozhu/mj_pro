<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('success', function ($data) {
            return Response::json(['error_code' => 0, 'data' => $data]);
        });

        Response::macro('error', function ($error_code, $error_message = null, $status = 200, $sprintf = null) {
            $error_message = $error_message ? trans('errors.'.$error_message) : trans('errors.Undefined Error');
            if ($sprintf) {
                $error_message = sprintf($error_message, $sprintf);
            }
            return Response::json(['error_code' => $error_code, 'error_message' => $error_message], $status);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
