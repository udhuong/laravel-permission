<?php

namespace Udhuong\Permission\Domain\Actions;

use Udhuong\LaravelCommon\Domain\Exceptions\AppException;
use Udhuong\Permission\Domain\Exceptions\PermissionException;

class VerifyScopeAction
{
    /**
     * @throws AppException
     * @throws PermissionException
     */
    public function handle(string $action, array $scopes): void
    {
        $config = GetRuleAction::handle($action);
        if (! $config->scopes || ! $scopes || ! array_intersect($config->scopes, $scopes)) {
            throw new PermissionException('Quyền truy cập không hợp lệ.');
        }
    }
}
