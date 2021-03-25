<?php


namespace BugSheng\Laravel\ApiResponse;


use BugSheng\Laravel\ApiResponse\Contracts\JsonResponseContract;
use Illuminate\Http\JsonResponse;

class ApiJsonResponse implements JsonResponseContract
{

    /**
     * HTTP 状态码 默认200 成功 400 失败
     *
     * @var int
     */
    protected $httpCode = 200;

    /**
     * 业务服务码 默认 0 成功
     *
     * @var int
     */
    protected $serverCode = 0;

    /**
     * @var mixed
     */
    protected $data;

    /**
     * @var string
     */
    protected $message = '';

    /**
     * @var array
     */
    protected $headers = [];

    /**
     * ApiJsonResponse constructor.
     *
     * @param string $message
     * @param mixed  $data
     * @param int    $serverCode
     * @param int    $httpCode
     * @param array  $headers
     */
    public function __construct($message = '', $data = [], $serverCode = 0, $httpCode = 200, $headers = [])
    {
        $this->setMessage($message);
        $this->setData($data);
        $this->setServerCode($serverCode);
        $this->setHttpCode($httpCode);
        $this->setHeaders($headers);
    }

    /**
     * 获取状态码
     *
     * @return int
     */
    public function getHttpCode()
    {
        return $this->httpCode;
    }

    /**
     * 设置返回状态码
     *
     * @param int $httpCode
     *
     * @return $this
     */
    public function setHttpCode($httpCode = 200)
    {
        $this->httpCode = $httpCode;
        return $this;
    }


    /**
     * 获取状态码
     *
     * @return int
     */
    public function getServerCode()
    {
        return $this->serverCode;
    }

    /**
     * 设置返回状态码
     *
     * @param int $serverCode
     *
     * @return $this
     */
    public function setServerCode($serverCode = 0)
    {
        $this->serverCode = $serverCode;
        return $this;
    }


    /**
     * 获取返回数据
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * 设置数据
     *
     * @param mixed $data
     *
     * @return $this
     */
    public function setData($data = [])
    {
        $this->data = $data;
        return $this;
    }

    /**
     * 获取文字提示
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * 获取文字提示
     *
     * @param string $message
     *
     * @return $this
     */
    public function setMessage($message = '')
    {
        $this->message = $message;
        return $this;
    }

    /**
     * 获取发送数据
     *
     * @return array
     */
    public function getSendData()
    {
        return [
            'code'    => $this->getServerCode(),
            'message' => $this->getMessage(),
            'data'    => $this->getData()
        ];
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * 设置请求头
     *
     * @param array $headers
     *
     * @return $this
     */
    public function setHeaders($headers = [])
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * @param string $message
     * @param mixed  $data
     * @param int    $serverCode
     * @param int    $httpCode
     * @param array  $headers
     *
     * @return ApiJsonResponse
     */
    public function make($message = '', $data = [], $serverCode = 0, $httpCode = 200, array $headers = [])
    {
        return new ApiJsonResponse($message, $data, $serverCode, $httpCode, $headers);
    }

    /**
     * 请求正常
     *
     * @return $this
     */
    public function httpSuccess()
    {
        return $this->setHttpCode(200);
    }

    /**
     * 请求异常
     *
     * @param int $failCode
     *
     * @return $this
     */
    public function httpFail($failCode = 400)
    {
        return $this->setHttpCode($failCode);
    }


    /**
     * @return JsonResponse
     */
    public function sendRespond()
    {
        return new JsonResponse($this->getSendData(), $this->getHttpCode(), $this->headers);
    }

    /**
     * 纯消息提示
     *
     * @param string $message
     *
     * @return JsonResponse
     */
    public function message($message = '')
    {
        return $this->setHttpCode(200)->setData()->setServerCode()->setMessage($message)->sendRespond();
    }

    /**
     * 错误消息提示
     *
     * @param string $message
     * @param int    $errCode
     *
     * @return JsonResponse
     */
    public function errorMessage($message = '', $errCode = 400)
    {
        return $this->setData()
            ->setServerCode($errCode)
            ->setMessage($message ?: Error::getMsg($errCode))
            ->sendRespond();
    }

    /**
     * 成功携带数据返回
     *
     * @param mixed  $data
     * @param string $message
     *
     * @return JsonResponse
     */
    public function success($data = [], $message = '')
    {
        return $this->setHttpCode(200)->setData($data)->setServerCode()->setMessage($message ?: '请求成功')->sendRespond();
    }

    /**
     * 失败携带数据返回
     *
     * @param mixed  $data
     * @param string $message
     * @param int    $errCode
     *
     * @return JsonResponse
     */
    public function fail($data = [], $message = '', $errCode = 400)
    {
        return $this->setData($data)
            ->setServerCode($errCode)
            ->setMessage($message ?: Error::getMsg($errCode))
            ->sendRespond();
    }

    /**
     * 鉴权失败
     *
     * @param string $message
     *
     * @return JsonResponse
     */
    public function unauthenticated(string $message = '')
    {
        // 401 错误
        return $this->setHttpCode(401)->fail([], $message ?: Error::getMsg(401), 401);
    }

    /**
     * 无权限
     *
     * @param string $message
     *
     * @return JsonResponse
     */
    public function missScope(string $message = '')
    {
        // 403 错误
        return $this->setHttpCode(403)->fail([], $message ?: Error::getMsg(403), 403);
    }

    /**
     * 资源未找到
     *
     * @param string $message
     *
     * @return JsonResponse
     */
    public function notFound(string $message = '')
    {
        // 404 错误
        return $this->setHttpCode(404)->fail([], $message ?: Error::getMsg(404), 404);
    }

    /**
     * 表单验证异常
     *
     * @param mixed  $data
     * @param string $message
     *
     * @return JsonResponse
     */
    public function validatorError($data = [], $message = '表单验证不通过')
    {
        // 422 错误
        return $this->setHttpCode(422)->fail($data, $message ?: Error::getMsg(422), 422);
    }

    /**
     * 请求频次过高
     *
     * @param string $message
     *
     * @return JsonResponse
     */
    public function tooManyAttempts(string $message = '')
    {
        // 429 错误
        return $this->setHttpCode(429)->fail([], $message ?: Error::getMsg(429), 429);
    }
}
