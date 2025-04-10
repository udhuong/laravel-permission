<?php

namespace Udhuong\Permission\Domain\DTOs;

class PermissionDTO
{
    public array $roles = [];

    public array $permissions = [];

    public array $scopes = [];

    public array $usernames = [];
}
