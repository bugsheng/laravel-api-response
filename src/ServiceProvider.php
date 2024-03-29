<?php


namespace BugSheng\Laravel\ApiResponse;

use BugSheng\Laravel\ApiResponse\Contracts\JsonResponseContract;
use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Laravel\Lumen\Application as LumenApplication;

class ServiceProvider extends LaravelServiceProvider
{

    public function boot()
    {
        Response::macro('success', function ($data = [], $message = '', $headers = [], $options = 0) {
            $sendData = [
                'request_id' => Request::instance()->requestId ?? '',
                'code'    => 0,
                'message' => $message,
                'data'    => $data ?: new \stdClass()
            ];
            return new JsonResponse($sendData, 200, $headers, $options);
        });

        Response::macro('fail',
            function ($message = '', $data = [], $serverCode = 400, $httpCode = 200, $headers = [], $options = 0) {
                $sendData = [
                    'request_id' => Request::instance()->requestId ?? '',
                    'code'    => $serverCode,
                    'message' => $message,
                    'data'    => $data ?: new \stdClass()
                ];
                return new JsonResponse($sendData, $httpCode, $headers, $options);
            });

        Response::macro('msg', function ($message = '', $headers = [], $options = 0) {
            $sendData = [
                'request_id' => Request::instance()->requestId ?? '',
                'code'    => 0,
                'message' => $message,
                'data'    => new \stdClass()
            ];
            return new JsonResponse($sendData, 200, $headers, $options);
        });

        Response::macro('errMsg',
            function ($message = '', $serverCode = 400, $httpCode = 200, $headers = [], $options = 0) {
                $sendData = [
                    'request_id' => Request::instance()->requestId ?? '',
                    'code'    => $serverCode,
                    'message' => $message,
                    'data'    => new \stdClass()
                ];
                return new JsonResponse($sendData, $httpCode, $headers, $options);
            });
    }

    /**
     * Setup the config.
     */
    protected function setupConfig()
    {
        $source = realpath(__DIR__ . '/../config/laravel-api-response.php');

        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('laravel-api-response.php')], 'laravel-api-response');
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('laravel-api-response');
        }

        $this->mergeConfigFrom($source, 'laravel-api-response');
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
