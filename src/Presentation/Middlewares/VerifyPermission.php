<?php

namespace Udhuong\Permission\Presentation\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Laravel\Octane\Exceptions\DdException;
use Throwable;
use Udhuong\LaravelCommon\Domain\Exceptions\AppException;
use Udhuong\LaravelCommon\Presentation\Http\Response\Responder;
use Udhuong\Permission\Domain\Actions\VerifyPermissionAction;
use Udhuong\Permission\Domain\Actions\VerifyScopeAction;
use Udhuong\Permission\Domain\Contracts\AuthRepository;
use Firebase\JWT\JWT;

class VerifyPermission
{
    public function __construct(
        private readonly AuthRepository $authRepository,
        private readonly VerifyPermissionAction $verifyPermissionAction,
        private readonly VerifyScopeAction $verifyScopeAction,
    ) {
    }

    /**
     * Kiểm tra phân quyền khi người dùng xác thực qua api token
     * Nhờ là có 1 middleware cho việc xác thực và lấy thông tin user rồi, vào đến đây là user đã được xác thực
     * ví dụ với laravel passport sẽ có middleware auth:api ở trước sau đến middleware này 'verify.permission'
     *
     * @param Request $request
     * @param Closure $next
     * @param string $type
     * @return mixed
     * @throws AppException
     * @throws DdException
     * @throws Throwable
     */
    public function handle(Request $request, Closure $next, string $type): mixed
    {
        $action = $this->getActionName($request);
        $token = $request->bearerToken();
        $publicKey = file_get_contents(storage_path('oauth-public.key'));

        try {
            switch ($type) {
                case 'auth':
                    $authUser = $this->authRepository->getUserDetailById(auth()->id());
                    if ($authUser === null) {
                        throw new AppException('Không xác định được người dùng.');
                    }
                    $this->verifyPermissionAction->handle($action, $authUser);
                    break;
                case 'direct':
                    // Chỗ này chưa ổn lắm, cần verify thêm
                    $decoded = JWT::decode($token, new \Firebase\JWT\Key($publicKey, 'RS256')); //Giải mã full payload kèm verify chữ ký luôn.
                    $this->verifyScopeAction->handle($action, $decoded->scopes ?? []);
                    break;
                default:
                    throw new AppException('Phương thức xác thực không hợp lệ.');
            }
            return $next($request);
        } catch (Throwable $throwable) {
            return Responder::failWithException($throwable);
        }
    }

    /**
     * Lấy action của route hiện tại. Được dùng để xác định quyền truy cập người dùng
     *
     * @param Request $request
     * @return string
     * @throws AppException
     */
    private function getActionName(Request $request): string
    {
        $route = $request->route();
        if (!$route) {
            throw new AppException('Không xác định được route.');
        }

        return $route->getActionName();
    }
}
