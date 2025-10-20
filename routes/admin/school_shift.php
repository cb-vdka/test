<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SchoolShiftController;

Route::prefix('school_shift')->group(function () {
    Route::get('/index', [SchoolShiftController::class, 'index'])->name('school_shift.index');
    Route::get('/create', [SchoolShiftController::class, 'create'])->name('school_shift.create');
    Route::post('/store', [SchoolShiftController::class, 'store'])->name('school_shift.store');
    Route::get('/edit/{id}', [SchoolShiftController::class, 'edit'])->name('school_shift.edit')->where(['id' => '[0-9]+']);
    Route::post('/update/{id}', [SchoolShiftController::class, 'update'])->name('school_shift.update')->where(['id' => '[0-9]+']);
    Route::delete('/destroy/{id}', [SchoolShiftController::class, 'destroy'])->name('school_shift.destroy')->where(['id' => '[0-9]+']);
});
