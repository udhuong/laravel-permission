<?php

namespace Udhuong\Permission\Domain\Entities;

use Udhuong\Permission\Domain\ValueObjects\Permission;
use Udhuong\Permission\Domain\ValueObjects\Role;

class AuthUser
{
    public int $userId;
    public string $name;
    public string $username;
    public string $email;

    /**
     * @var Role[]
     */
    public array $roles = [];

    /**
     * @var Permission[]
     */
    public array $permissions = [];
}
