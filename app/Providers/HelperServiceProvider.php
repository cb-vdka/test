<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helpers\PermissionHelper;
use App\Helpers\ViewHelper;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
          // Đăng ký helper functions
        if (!function_exists('can')) {
            function can($permission) {
                return PermissionHelper::can($permission);
            }
        }

        if (!function_exists('hasRole')) {
            function hasRole($roleName) {
                return PermissionHelper::hasRole($roleName);
            }
        }

        if (!function_exists('hasAnyRole')) {
            function hasAnyRole($roles) {
                return PermissionHelper::hasAnyRole($roles);
            }
        }

        if (!function_exists('hasAnyPermission')) {
            function hasAnyPermission($permissions) {
                return PermissionHelper::hasAnyPermission($permissions);
            }
        }

        if (!function_exists('canShowMenuItem')) {
            function canShowMenuItem($permission) {
                return ViewHelper::canShowMenuItem($permission);
            }
        }

        if (!function_exists('canShowButton')) {
            function canShowButton($permission) {
                return ViewHelper::canShowButton($permission);
            }
        }

        if (!function_exists('isAdmin')) {
            function isAdmin() {
                return ViewHelper::isAdmin();
            }
        }

        if (!function_exists('isTeacher')) {
            function isTeacher() {
                return ViewHelper::isTeacher();
            }
        }

        if (!function_exists('isStudent')) {
            function isStudent() {
                return ViewHelper::isStudent();
            }
        }

        if (!function_exists('isTrainingOfficer')) {
            function isTrainingOfficer() {
                return ViewHelper::isTrainingOfficer();
            }
        }

        // Toastr helper functions
        if (!function_exists('toastr')) {
            function toastr() {
                return app('toastr');
            }
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

    }
}

