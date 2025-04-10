<?php

namespace Udhuong\Permission\Domain\Actions;

use Udhuong\LaravelCommon\Domain\Exceptions\AppException;
use Udhuong\Permission\Domain\DTOs\PermissionDTO;
use Udhuong\Permission\Domain\Entities\AuthUser;
use Udhuong\Permission\Domain\Exceptions\PermissionException;

class VerifyPermissionAction
{
    /**
     * Xác thực quyền người dùng
     * Thứ tự ưu tiên check
     * 1. Check username
     * 2. Check role
     * 3. Check permission
     *
     * @throws AppException
     */
    public function handle(string $action, AuthUser $user): void
    {
        $config = GetRuleAction::handle($action);

        if ($this->checkUsername($config, $user)) {
            return;
        }

        if ($this->checkRole($config, $user)) {
            return;
        }

        if ($this->checkPermission($config, $user)) {
            return;
        }

        throw new PermissionException('Bạn không có quyền truy cập.');
    }

    private function checkUsername(PermissionDTO $config, AuthUser $user): bool
    {
        return in_array($user->username, $config->usernames, true);
    }

    private function checkRole(PermissionDTO $config, AuthUser $user): bool
    {
        // Không có role nào coi như không có quyền
        if (! $user->roles) {
            return false;
        }

        // Không có role nào trong config coi như không truy cập được
        if (! $config->roles) {
            return false;
        }

        // Chỉ cần có dấu * trong roles hiểu là ai cũng truy cập được
        if (in_array('*', $config->roles, true)) {
            return true;
        }

        // Chỉ cần 1 role config 1 role của user trùng nhau là được phép truy cập
        return array_intersect(
            array_map(static fn ($role) => $role->name, $user->roles),
            array_map(static fn ($role) => $role->name, $config->roles)
        ) !== [];
    }

    private function checkPermission(PermissionDTO $config, AuthUser $user): bool
    {
        // Không có role nào coi như không có quyền
        if (! $user->permissions) {
            return false;
        }

        // Không có role nào trong config coi như không truy cập được
        if (! $config->permissions) {
            return false;
        }

        // Chỉ cần có dấu * trong $this->permissions hiểu là ai cũng truy cập được
        if (in_array('*', $config->permissions, true)) {
            return true;
        }

        // Chỉ cần 1 role config 1 role của user trùng nhau là được phép truy cập
        return array_intersect(
            array_map(static fn ($permission) => $permission->name, $user->permissions),
            array_map(static fn ($permission) => $permission->name, $config->permissions)
        ) !== [];
    }
}
