<?php

namespace App\Helpers;

use App\Models\Account;
use App\Models\Roles;

class PermissionHelper
{
    /**
     * Kiểm tra user hiện tại có quyền hay không
     */
    public static function can($permission)
    {
        $userId = session('user_id');
        $userRole = session('user_role');
        
        if (!$userId || !$userRole) {
            return false;
        }

        // Lấy role từ database
        $role = Roles::with('permissions')->find($userRole);
        
        if (!$role) {
            return false;
        }

        // Kiểm tra permission trực tiếp
        $hasPermission = $role->permissions()->where('name', $permission)->exists();
        
        if ($hasPermission) {
            return true;
        }

        // Kiểm tra permission thông qua user_permissions nếu có
        $user = Account::find($userId);
        if ($user && method_exists($user, 'permissions')) {
            $hasUserPermission = $user->permissions()->where('name', $permission)->exists();
            return $hasUserPermission;
        }

        return false;
    }

    /**
     * Kiểm tra user hiện tại có vai trò hay không
     */
    public static function hasRole($roleName)
    {
        $userRole = session('user_role');
        
        if (!$userRole) {
            return false;
        }

        $role = Roles::find($userRole);
        
        if (!$role) {
            return false;
        }

        return $role->name === $roleName;
    }

    /**
     * Kiểm tra user hiện tại có bất kỳ vai trò nào trong danh sách hay không
     */
    public static function hasAnyRole($roles)
    {
        $userRole = session('user_role');
        
        if (!$userRole) {
            return false;
        }

        $role = Roles::find($userRole);
        
        if (!$role) {
            return false;
        }

        return in_array($role->name, $roles);
    }

    /**
     * Kiểm tra user hiện tại có bất kỳ quyền nào trong danh sách hay không
     */
    public static function hasAnyPermission($permissions)
    {
        foreach ($permissions as $permission) {
            if (self::can($permission)) {
                return true;
            }
        }
        
        return false;
    }
}

