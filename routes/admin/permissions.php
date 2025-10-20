<?php

use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;

// Routes cho quản lý permissions
Route::resource('permissions', PermissionController::class)->names([
    'index' => 'permissions.index',
    'create' => 'permissions.create',
    'store' => 'permissions.store',
    'show' => 'permissions.show',
    'edit' => 'permissions.edit',
    'update' => 'permissions.update',
    'destroy' => 'permissions.destroy',
]);

// Routes cho quản lý roles
Route::resource('roles', RoleController::class)->names([
    'index' => 'roles.index',
    'create' => 'roles.create',
    'store' => 'roles.store',
    'show' => 'roles.show',
    'edit' => 'roles.edit',
    'update' => 'roles.update',
    'destroy' => 'roles.destroy',
]);

// Routes đặc biệt cho permissions
Route::post('permissions/{permission}/restore', [PermissionController::class, 'restore'])
    ->name('permissions.restore');

Route::get('permissions/roles/{role}/permissions', [PermissionController::class, 'rolePermissions'])
    ->name('permissions.role-permissions');

Route::put('permissions/roles/{role}/permissions', [PermissionController::class, 'updateRolePermissions'])
    ->name('permissions.update-role-permissions');

Route::get('permissions/users/{account}/permissions', [PermissionController::class, 'userPermissions'])
    ->name('permissions.user-permissions');

Route::put('permissions/users/{account}/permissions', [PermissionController::class, 'updateUserPermissions'])
    ->name('permissions.update-user-permissions');

// Routes đặc biệt cho roles
Route::post('roles/{role}/restore', [RoleController::class, 'restore'])
    ->name('roles.restore');
