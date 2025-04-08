<?php

namespace Udhuong\Permission\Domain\Config;

use Udhuong\Permission\Domain\ValueObjects\Permission;
use Udhuong\Permission\Domain\ValueObjects\Role;
use Udhuong\Permission\Presentation\Http\Controllers\GetUserDetailController;

class PermissionRule
{
    public const array USERNAME_WHITE_LIST = [
        'huongud1',
    ];

    public const array URI_WHITE_LIST = [
        '/up',
    ];

    public const array RULES = [
        'Test' => [
            'roles' => [
                '*' => [
                    Role::ADMIN
                ],
                'handle' => [
                    Role::ADMIN
                ],
                'handle2' => [
                    Role::ADMIN,
                    Role::MODERATOR,
                ],
            ],
            'permissions' => [
                'handle' => [
                    Permission::USER_CREATE
                ],
                'handle2' => [
                    Permission::USER_CREATE,
                    Permission::USER_VIEW,
                ],
            ],
            'scopes' => [
                'handle' => ['os:nvbc.smart-locker.access']
            ],
            'usernames' => [
                'handle' => ['huongud1']
            ],
        ],
        GetUserDetailController::class => [
            'roles' => [
                'handle' => [
                    Role::ADMIN,
                    Role::MODERATOR,
                ],
            ],
            'permissions' => [
                'handle' => [
                    Permission::USER_VIEW
                ],
            ],
        ]
    ];
}
