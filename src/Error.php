<?php


namespace  BugSheng\Laravel\ApiResponse;


class Error
{

    public static function getMsg($code)
    {
        $maps = static::getErrs();

        return isset($maps[$code]) ? $maps[$code] : '未知错误';
    }

    public static function getErrs()
    {
        return config('apiresponse.error_code') ?? [];
    }
}
