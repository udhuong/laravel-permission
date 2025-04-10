<?php

namespace Udhuong\Permission\Infrastructure\Repositories;

use App\Models\User;
use Udhuong\Permission\Domain\Contracts\AuthRepository;
use Udhuong\Permission\Domain\Entities\AuthUser;
use Udhuong\Permission\Domain\ValueObjects\Permission;
use Udhuong\Permission\Domain\ValueObjects\Role;

class AuthRepositoryImpl implements AuthRepository
{
    /**
     * Lấy thông tin chi tiết của người dùng bằng id
     */
    public function getUserDetailById(int $userId): ?AuthUser
    {
        $user = User::query()->where('id', $userId)->first();
        if ($user === null) {
            return null;
        }

        $authUser = new AuthUser;
        $authUser->userId = $user->id;
        $authUser->name = $user->name;
        $authUser->username = $user->username;
        $authUser->email = $user->email;
        $authUser->roles = $user->roles()->pluck('name')
            ->map(fn ($item) => Role::tryFrom($item))
            ->filter(fn ($item) => $item !== null)
            ->toArray();
        $authUser->permissions = $user->getAllPermissions()->pluck('name')
            ->map(fn ($item) => Permission::tryFrom($item))
            ->filter(fn ($item) => $item !== null)
            ->toArray();

        return $authUser;
    }
}
