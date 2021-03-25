<?php


namespace BugSheng\Laravel\ApiResponse\Contracts;

interface JsonResponseContract
{

    /**
     * @param string $message
     * @param mixed  $data
     * @param int    $serverCode
     * @param int    $httpCode
     * @param array  $headers
     *
     * @return mixed
     */
    public function make($message = '', $data = [], $serverCode = 0, $httpCode = 200, array $headers = []);

    /**
     * @param mixed  $data
     * @param string $message
     *
     * @return mixed
     */
    public function success($data = [], $message = '');

    /**
     * @param mixed  $data
     * @param string $message
     * @param int    $errCode
     *
     * @return mixed
     */
    public function fail($data = [], $message = '', $errCode = 400);

    /**
     * @param string $message
     *
     * @return mixed
     */
    public function message($message = '');

    /**
     * @param string $message
     * @param int    $errCode
     *
     * @return mixed
     */
    public function errorMessage($message = '', $errCode = 400);

    /**
     * @param string $message
     *
     * @return mixed
     */
    public function unauthenticated(string $message = '');

    /**
     * @param string $message
     *
     * @return mixed
     */
    public function missScope(string $message = '');

    /**
     * @param string $message
     *
     * @return mixed
     */
    public function notFound(string $message = '');

    /**
     * @param mixed  $data
     * @param string $message
     *
     * @return mixed
     */
    public function validatorError($data = [], $message = '表单验证不通过');

    /**
     * @param string $message
     *
     * @return mixed
     */
    public function tooManyAttempts(string $message = '');
}

