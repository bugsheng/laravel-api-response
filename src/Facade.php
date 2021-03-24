<?php


namespace BugSheng\Laravel\ApiResponse;


use BugSheng\Laravel\ApiResponse\Contracts\JsonResponseContract;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade as LaravelFacade;

/**
 * Class ApiJsonResponse
 *
 * @package App\Libs\Response\Facades
 *
 * @method static \BugSheng\Laravel\ApiResponse\ApiJsonResponse make($message = '', array|Collection $data = [], $serverCode = 0, $httpCode = 200, array $headers = [])
 * @method static \Illuminate\Http\JsonResponse success(array|Collection $data = [], string $message = '')
 * @method static \Illuminate\Http\JsonResponse fail(array|Collection  $data = [], string $message = '', int $errCode = 100000)
 * @method static \Illuminate\Http\JsonResponse message(string $message = '')
 * @method static \Illuminate\Http\JsonResponse errorMessage(string $message = '', int $errCode = 400)
 * @method static \Illuminate\Http\JsonResponse unauthenticated(string $message = '')
 * @method static \Illuminate\Http\JsonResponse missScope(string $message = '')
 * @method static \Illuminate\Http\JsonResponse notFound(string $message = '')
 * @method static \Illuminate\Http\JsonResponse validatorError(array|Collection $data = [], $message = '表单验证不通过')
 * @method static \Illuminate\Http\JsonResponse tooManyAttempts(string $message = '')
 *
 * @see     \BugSheng\Laravel\ApiResponse\Contracts\JsonResponseContract
 */
class Facade extends LaravelFacade
{

    protected static function getFacadeAccessor()
    {
        return JsonResponseContract::class;
    }

}
