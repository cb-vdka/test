<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SchedulesController;

Route::prefix('schedule')->group(function () {
    Route::get('/index', [SchedulesController::class, 'index'])->name('schedule.index');

    Route::get('/create', [SchedulesController::class, 'create'])->name('schedule.create');
    Route::post('/store', [SchedulesController::class, 'store'])->name('schedule.store');

    Route::get('/edit/{id}', [SchedulesController::class, 'edit'])->name('schedule.edit')->where(['id' => '[0-9]+']);
    Route::post('/update/{id}', [SchedulesController::class, 'update'])->name('schedule.update')->where(['id' => '[0-9]+']);

    Route::get('/delete/{id}', [SchedulesController::class, 'delete'])->name('schedule.delete')->where(['id' => '[0-9]+']);
    Route::delete('/destroy/{id}', [SchedulesController::class, 'destroy'])->name('schedule.destroy')->where(['id' => '[0-9]+']);

    Route::get('/export', [SchedulesController::class, 'export'])->name('schedule.export');

});
