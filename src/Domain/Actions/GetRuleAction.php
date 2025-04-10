<?php

namespace Udhuong\Permission\Domain\Actions;

use Udhuong\LaravelCommon\Domain\Exceptions\AppException;
use Udhuong\Permission\Domain\Config\PermissionRule;
use Udhuong\Permission\Domain\DTOs\PermissionDTO;

class GetRuleAction
{
    /**
     * Lấy thông tin quyền của controller
     *
     * @throws AppException
     */
    public static function handle(string $action): PermissionDTO
    {
        $segments = explode('@', $action, 2);
        $controllerName = $segments[0] ?? '';
        $actionName = $segments[1] ?? '';
        if (! $controllerName || ! $actionName) {
            throw new AppException('Không xác định được controller hoặc action.');
        }

        $dto = new PermissionDTO;

        $rules = PermissionRule::RULES[$controllerName] ?? [];
        if (! $rules) {
            return $dto;
        }

        // Nếu không có thiết lập cụ thể theo actionName thì lấy theo cấu hình chung là *
        $roles = $rules['roles'][$actionName] ?? $rules['roles']['*'] ?? [];
        $permissions = $rules['permissions'][$actionName] ?? $rules['permissions']['*'] ?? [];
        $scopes = $rules['scopes'][$actionName] ?? $rules['scopes']['*'] ?? [];
        $usernames = $rules['usernames'][$actionName] ?? $rules['usernames']['*'] ?? [];

        $dto->roles = $roles;
        $dto->permissions = $permissions;
        $dto->scopes = $scopes;
        $dto->usernames = [...$usernames, ...PermissionRule::USERNAME_WHITE_LIST];

        return $dto;
    }
}
