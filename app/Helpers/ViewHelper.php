<?php

namespace App\Helpers;

use App\Helpers\PermissionHelper;

class ViewHelper
{
    /**
     * Kiểm tra và hiển thị menu item nếu user có quyền
     */
    public static function canShowMenuItem($permission)
    {
        return PermissionHelper::can($permission);
    }

    /**
     * Kiểm tra và hiển thị button nếu user có quyền
     */
    public static function canShowButton($permission)
    {
        return PermissionHelper::can($permission);
    }

    /**
     * Kiểm tra và hiển thị form field nếu user có quyền
     */
    public static function canShowField($permission)
    {
        return PermissionHelper::can($permission);
    }

    /**
     * Kiểm tra và hiển thị action button nếu user có quyền
     */
    public static function canShowAction($permission)
    {
        return PermissionHelper::can($permission);
    }

    /**
     * Kiểm tra user có phải admin không
     */
    public static function isAdmin()
    {
        return PermissionHelper::hasRole('Admin');
    }

    /**
     * Kiểm tra user có phải teacher không
     */
    public static function isTeacher()
    {
        return PermissionHelper::hasRole('Teacher');
    }

    /**
     * Kiểm tra user có phải student không
     */
    public static function isStudent()
    {
        return PermissionHelper::hasRole('Student');
    }

    /**
     * Kiểm tra user có phải training officer không
     */
    public static function isTrainingOfficer()
    {
        return PermissionHelper::hasRole('Training Officer');
    }
}

