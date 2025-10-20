<?php

use App\Helpers\RouteLoader;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Middleware\Authentication;


Route::prefix('wp-admin')->middleware(Authentication::class)->group(function () {
    Route::get('/trang-chu', [DashboardController::class, 'index'])->name('dashboard.index');
    
    // Routes cho quản lý phân quyền (chỉ admin)
    Route::prefix('admin')->name('admin.')->group(function () {
        require __DIR__ . '/permissions.php';
    });
    
    RouteLoader::load(__DIR__, "/");
});
