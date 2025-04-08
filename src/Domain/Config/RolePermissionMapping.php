<?php

namespace Udhuong\Permission\Domain\Config;

use Udhuong\Permission\Domain\ValueObjects\Permission;
use Udhuong\Permission\Domain\ValueObjects\Role;

class RolePermissionMapping
{
    /**
     * Get the mapping of roles to permissions.
     *
     * @return array
     */
    public static function getData(): array
    {
        return [
            [
                'role' => Role::ADMIN,
                'permissions' => [],
            ],
            [
                'role' => Role::MODERATOR,
                'permissions' => [
                    Permission::USER_CREATE,
                    Permission::USER_VIEW,
                    Permission::USER_UPDATE,
                    Permission::USER_DELETE,
                    Permission::USER_ASSIGN,
                ],
            ],
            [
                'role' => Role::EDITOR,
                'permissions' => [
                    Permission::POST_CREATE,
                    Permission::POST_VIEW,
                    Permission::POST_UPDATE,
                    Permission::POST_DELETE,
                    Permission::POST_PUBLISH,
                ],
            ]
        ];
    }
}
