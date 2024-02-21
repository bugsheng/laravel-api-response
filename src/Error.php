<?php


namespace  BugSheng\Laravel\ApiResponse;


use Illuminate\Support\Facades\Config;

class Error
{

    public static function getMsg($code)
    {
        $maps = static::getErrs();

        return isset($maps[$code]) ? $maps[$code] : '未知错误';
    }

    public static function getErrs()
    {
        return Config::get('laravel-api-response.error_code', []);
    }
}
