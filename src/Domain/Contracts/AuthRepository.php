<?php

namespace Udhuong\Permission\Domain\Contracts;

use Udhuong\Permission\Domain\Entities\AuthUser;

interface AuthRepository
{
    public function getUserDetailById(int $userId): ?AuthUser;
}
