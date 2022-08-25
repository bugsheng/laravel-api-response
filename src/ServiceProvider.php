<?php


namespace BugSheng\Laravel\ApiResponse;

use BugSheng\Laravel\ApiResponse\Contracts\JsonResponseContract;
use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Laravel\Lumen\Application as LumenApplication;

class ServiceProvider extends LaravelServiceProvider
{

    public function boot()
    {
        Response::macro('success', function ($data = [], $message = '', $headers = [], $options = 0) {
            $sendData = [
                'code'    => 0,
                'message' => $message,
                'data'    => $data
            ];
            return Response::json($sendData, 200, $headers, $options);
        });

        Response::macro('fail',
            function ($message = '', $data = [], $serverCode = 400, $httpCode = 200, $headers = [], $options = 0) {
                $sendData = [
                    'code'    => $serverCode,
                    'message' => $message,
                    'data'    => $data
                ];
                return Response::json($sendData, $httpCode, $headers, $options);
            });

        Response::macro('msg', function ($message = '', $headers = [], $options = 0) {
            $sendData = [
                'code'    => 0,
                'message' => $message,
                'data'    => []
            ];
            return Response::json($sendData, 200, $headers, $options);
        });

        Response::macro('errMsg',
            function ($message = '', $serverCode = 400, $httpCode = 200, $headers = [], $options = 0) {
                $sendData = [
                    'code'    => $serverCode,
                    'message' => $message,
                    'data'    => []
                ];
                return Response::json($sendData, $httpCode, $headers, $options);
            });
    }

    /**
     * Setup the config.
     */
    protected function setupConfig()
    {
        $source = realpath(__DIR__ . '/../config/apiresponse.php');

        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('apiresponse.php')], 'laravel-api-response');
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('apiresponse');
        }

        $this->mergeConfigFrom($source, 'apiresponse');
    }

    public function register()
    {

        $this->setupConfig();

        $this->app->singleton(JsonResponseContract::class, function ($app) {
            return new ApiJsonResponse();
        });

        $this->app->alias(Facade::class, 'ApiRes');
    }



}
