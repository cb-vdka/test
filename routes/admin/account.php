<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Middleware\CheckPermission;

Route::prefix('account')->group(function () {
    Route::get('/index', [AccountController::class, 'index'])
        ->middleware([CheckPermission::class . ':account.view'])
        ->name('account.index');

    Route::get('/create', [AccountController::class, 'create'])
        ->middleware([CheckPermission::class . ':account.create'])
        ->name('account.create');
    Route::post('/store', [AccountController::class, 'store'])
        ->middleware([CheckPermission::class . ':account.create'])
        ->name('account.store');

    Route::get('/edit/{id}', [AccountController::class, 'edit'])
        ->middleware([CheckPermission::class . ':account.edit'])
        ->name('account.edit')->where(['id' => '[0-9]+']);
    Route::post('/update', [AccountController::class, 'update'])
        ->middleware([CheckPermission::class . ':account.edit'])
        ->name('account.update');

    Route::post('/trash/{id}', [AccountController::class, 'trash'])
        ->middleware([CheckPermission::class . ':account.delete'])
        ->name('account.trash')->where(['id' => '[0-9]+']);

    Route::post('/restore/{id}', [AccountController::class, 'restore'])
        ->middleware([CheckPermission::class . ':account.edit'])
        ->name('account.restore')->where(['id' => '[0-9]+']);

    Route::post('/delete/{id}', [AccountController::class, 'delete'])
        ->middleware([CheckPermission::class . ':account.delete'])
        ->name('account.delete')->where(['id' => '[0-9]+']);
    
    Route::get('/export', [AccountController::class, 'export'])
        ->middleware([CheckPermission::class . ':account.export'])
        ->name('account.export');
});
