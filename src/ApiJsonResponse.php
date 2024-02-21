<?php


namespace BugSheng\Laravel\ApiResponse;


use BugSheng\Laravel\ApiResponse\Contracts\JsonResponseContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;

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

    protected $requestId = '';

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
    public function __construct(
        string $message = '',
        $data = [],
        int $serverCode = 0,
        int $httpCode = 200,
        array $headers = []
    ) {
        $this->setMessage($message);
        $this->setData($data);
        $this->setServerCode($serverCode);
        $this->setHttpCode($httpCode);
        $this->setHeaders($headers);
        $this->setRequestId();
    }

    /**
     * 获取状态码
     *
     * @return int
     */
    public function getHttpCode(): int
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
    public function setHttpCode(int $httpCode = 200): ApiJsonResponse
    {
        $this->httpCode = $httpCode;
        return $this;
    }


    /**
     * 获取状态码
     *
     * @return int
     */
    public function getServerCode(): int
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
    public function setServerCode(int $serverCode = 0): ApiJsonResponse
    {
        $this->serverCode = $serverCode;
        return $this;
    }

    /**
     * 获取请求id
     *
     * @return string
     */
    public function getRequestId(): string
    {
        return $this->requestId;
    }

    /**
     * 获取请求id
     */
    public function setRequestId(): ApiJsonResponse
    {
        $this->requestId = Request::instance()->requestId ?? '';
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
    public function setData($data = []): ApiJsonResponse
    {
        $this->data = $data ?: new \stdClass();
        return $this;
    }

    /**
     * 获取文字提示
     *
     * @return string
     */
    public function getMessage(): string
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
    public function setMessage(string $message = ''): ApiJsonResponse
    {
        $this->message = $message;
        return $this;
    }

    /**
     * 获取发送数据
     *
     * @return array
     */
    public function getSendData(): array
    {
        return [
            'request_id' => $this->getRequestId(),
            'code'       => $this->getServerCode(),
            'message'    => $this->getMessage(),
            'data'       => $this->getData()
        ];
    }

    /**
     * @return array
     */
    public function getHeaders(): array
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
    public function setHeaders(array $headers = []): ApiJsonResponse
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
    public function make(
        string $message = '',
        $data = [],
        int $serverCode = 0,
        int $httpCode = 200,
        array $headers = []
    ): ApiJsonResponse {
        return new ApiJsonResponse($message, $data, $serverCode, $httpCode, $headers);
    }

    /**
     * 请求正常
     *
     * @return $this
     */
    public function httpSuccess(int $successCode = 200): ApiJsonResponse
    {
        return $this->setHttpCode($successCode);
    }

    /**
     * 请求异常
     *
     * @param int $failCode
     *
     * @return $this
     */
    public function httpFail(int $failCode = 400): ApiJsonResponse
    {
        return $this->setHttpCode($failCode);
    }


    /**
     * @return JsonResponse
     */
    public function sendRespond(): JsonResponse
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
    public function message(string $message = ''): JsonResponse
    {
        return $this->setData()->setServerCode()->setMessage($message)->sendRespond();
    }

    /**
     * 错误消息提示
     *
     * @param string $message
     * @param int    $errCode
     *
     * @return JsonResponse
     */
    public function errorMessage(string $message = '', int $errCode = 400): JsonResponse
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
     * @param int    $httpCode
     * @param int    $serverCode
     *
     * @return JsonResponse
     */
    public function success($data = [], string $message = '请求成功', int $httpCode = 200, int $serverCode = 0): JsonResponse
    {
        return $this->setHttpCode($httpCode)
            ->setData($data)
            ->setServerCode($serverCode)
            ->setMessage($message)
            ->sendRespond();
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
    public function fail($data = [], string $message = '', int $errCode = 400): JsonResponse
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
    public function unauthenticated(string $message = ''): JsonResponse
    {
        // 401 错误
        return $this->fail([], $message ?: Error::getMsg(401), 401);
    }

    /**
     * 无权限
     *
     * @param string $message
     *
     * @return JsonResponse
     */
    public function missScope(string $message = ''): JsonResponse
    {
        // 403 错误
        return $this->fail([], $message ?: Error::getMsg(403), 403);
    }

    /**
     * 资源未找到
     *
     * @param string $message
     *
     * @return JsonResponse
     */
    public function notFound(string $message = ''): JsonResponse
    {
        // 404 错误
        return $this->fail([], $message ?: Error::getMsg(404), 404);
    }

    /**
     * 表单验证异常
     *
     * @param mixed  $data
     * @param string $message
     *
     * @return JsonResponse
     */
    public function validatorError($data = [], string $message = '表单验证不通过'): JsonResponse
    {
        // 422 错误
        return $this->fail($data, $message ?: Error::getMsg(422), 422);
    }

    /**
     * 请求频次过高
     *
     * @param string $message
     *
     * @return JsonResponse
     */
    public function tooManyAttempts(string $message = ''): JsonResponse
    {
        // 429 错误
        return $this->fail([], $message ?: Error::getMsg(429), 429);
    }
}
