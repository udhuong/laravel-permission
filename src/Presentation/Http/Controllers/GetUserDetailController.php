<?php

namespace Udhuong\Permission\Presentation\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Udhuong\LaravelCommon\Presentation\Http\Controllers\Controller;
use Udhuong\LaravelCommon\Presentation\Http\Response\Responder;

class GetUserDetailController extends Controller
{
    public function handle(Request $request): JsonResponse
    {
        $user = User::find($request->get('user_id'));

        return Responder::success(
            $user,
            'Lấy thông tin người dùng thành công.'
        );
    }
}
