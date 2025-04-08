<?php
namespace Udhuong\Permission\Presentation\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Udhuong\LaravelCommon\Presentation\Http\Controllers\Controller;
use Udhuong\LaravelCommon\Presentation\Http\Response\Responder;

class GetUserDetailController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function handle(Request $request): JsonResponse
    {
        return Responder::success(
            $request->user(),
            'Lấy thông tin người dùng thành công.'
        );
    }
}
