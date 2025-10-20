<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CourseController;

Route::prefix('course')->group(function () {
    Route::get('/index', [CourseController::class, 'index'])->name('course.index');

    Route::get('/create', [CourseController::class, 'create'])->name('course.create');
    Route::post('/store', [CourseController::class, 'store'])->name('course.store');
    Route::get('/restore/{id}', [CourseController::class, 'restore'])->name('course.restore')->where(['id' => '[0-9]+']);
    Route::post('/forceDelete/{id}', [CourseController::class, 'forceDelete'])->name('course.forceDelete')->where(['id' => '[0-9]+']);

    Route::get('/edit/{id}', [CourseController::class, 'edit'])->name('course.edit')->where(['id' => '[0-9]+']);
    Route::post('/update/{id}', [CourseController::class, 'update'])->name('course.update')->where(['id' => '[0-9]+']);

    Route::get('/delete/{id}', [CourseController::class, 'delete'])->name('course.delete')->where(['id' => '[0-9]+']);
    Route::delete('/destroy/{id}', [CourseController::class, 'destroy'])->name('course.destroy')->where(['id' => '[0-9]+']);
});
