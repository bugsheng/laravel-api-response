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
    public function make(
        string $message = '',
        $data = [],
        int $serverCode = 0,
        int $httpCode = 200,
        array $headers = []
    );

    /**
     * @param mixed  $data
     * @param string $message
     * @param int    $httpCode
     * @param int    $serverCode
     *
     * @return mixed
     */
    public function success($data = [], string $message = '', int $httpCode = 200, int $serverCode = 0);

    /**
     * @param mixed  $data
     * @param string $message
     * @param int    $errCode
     *
     * @return mixed
     */
    public function fail($data = [], string $message = '', int $errCode = 400);

    /**
     * @param string $message
     *
     * @return mixed
     */
    public function message(string $message = '');

    /**
     * @param string $message
     * @param int    $errCode
     *
     * @return mixed
     */
    public function errorMessage(string $message = '', int $errCode = 400);

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
    public function validatorError($data = [], string $message = '表单验证不通过');

    /**
     * @param string $message
     *
     * @return mixed
     */
    public function tooManyAttempts(string $message = '');
}

