<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TeachingSchedule;
use App\Http\Controllers\Admin\ClassesController;
use App\Http\Middleware\CheckPermission;

Route::prefix('teaching_schedule')->group(function () {
    Route::get('/index', [TeachingSchedule::class, 'index'])
        ->middleware([CheckPermission::class . ':schedule.view'])
        ->name('teaching_schedule.index');
    
    Route::get('/create', [TeachingSchedule::class, 'create'])
        ->middleware([CheckPermission::class . ':schedule.create'])
        ->name('teaching_schedule.create');
    Route::post('/store', [TeachingSchedule::class, 'store'])
        ->middleware([CheckPermission::class . ':schedule.create'])
        ->name('teaching_schedule.store');
    Route::post('/prefill-date', [TeachingSchedule::class, 'prefillDate'])
        ->middleware([CheckPermission::class . ':schedule.create'])
        ->name('teaching_schedule.prefill_date');
    
    Route::get('/edit/{id}', [TeachingSchedule::class, 'edit'])
        ->middleware([CheckPermission::class . ':schedule.edit'])
        ->name('teaching_schedule.edit')->where(['id' => '[0-9]+']);
    Route::put('/update/{id}', [TeachingSchedule::class, 'update'])
        ->middleware([CheckPermission::class . ':schedule.edit'])
        ->name('teaching_schedule.update')->where(['id' => '[0-9]+']);
    
    Route::get('/delete/{id}', [TeachingSchedule::class, 'delete'])
        ->middleware([CheckPermission::class . ':schedule.delete'])
        ->name('teaching_schedule.delete')->where(['id' => '[0-9]+']);
    
    Route::get('/export', [TeachingSchedule::class, 'export'])
        ->middleware([CheckPermission::class . ':schedule.view'])
        ->name('teaching_schedule.export');
});
