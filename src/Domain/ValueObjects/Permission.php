<?php

namespace Udhuong\Permission\Domain\ValueObjects;

enum Permission: string
{
    case USER_CREATE = 'user_create';
    case USER_VIEW = 'user_view';
    case USER_UPDATE = 'user_update';
    case USER_DELETE = 'user_delete';
    case USER_ASSIGN = 'user_assign';
    case POST_CREATE = 'post_create';
    case POST_VIEW = 'post_view';
    case POST_UPDATE = 'post_update';
    case POST_DELETE = 'post_delete';
    case POST_PUBLISH = 'post_publish';

    public function getLabel(): string
    {
        return match ($this) {
            self::USER_CREATE => 'Tạo người dùng mới',
            self::USER_VIEW => 'Xem danh sách người dùng',
            self::USER_UPDATE => 'Cập nhật thông tin người dùng',
            self::USER_DELETE => 'Xoá người dùng',
            self::USER_ASSIGN => 'Gán vai trò cho người dùng',
            self::POST_CREATE => 'Tạo bài viết mới',
            self::POST_VIEW => 'Xem bài viết',
            self::POST_UPDATE => 'Chỉnh sửa bài viết',
            self::POST_DELETE => 'Xoá bài viết',
            self::POST_PUBLISH => 'Xuất bản bài viết',
        };
    }
}
