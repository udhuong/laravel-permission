<?php

namespace Udhuong\Permission\Domain\ValueObjects;

enum Role: string
{
    case ADMIN = 'admin';
    case MODERATOR = 'moderator';
    case EDITOR = 'editor';
    case USER = 'user';

    public function getLabel(): string
    {
        return match ($this) {
            self::ADMIN => 'Quản trị viên',
            self::MODERATOR => 'Quản lý',
            self::EDITOR => 'Người soạn thỏa',
            self::USER => 'Người dùng thường',
        };
    }
}
