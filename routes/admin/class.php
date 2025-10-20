<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ClassesController;
use App\Http\Controllers\Admin\ClassController;

// AJAX helpers for classes
Route::prefix('classes')->group(function () {
    Route::get('/by-major', [ClassesController::class, 'byMajor'])->name('classes.by_major');
});

// CRUD routes for Class management (lop hoc)
Route::prefix('class')->group(function () {
    Route::get('/index', [ClassController::class, 'index'])->name('class.index');
    Route::get('/create', [ClassController::class, 'create'])->name('class.create');
    Route::post('/store', [ClassController::class, 'store'])->name('class.store');
    Route::get('/edit/{id}', [ClassController::class, 'edit'])->name('class.edit')->where(['id' => '[0-9]+']);
    Route::post('/update/{id}', [ClassController::class, 'update'])->name('class.update')->where(['id' => '[0-9]+']);
    Route::delete('/destroy/{id}', [ClassController::class, 'destroy'])->name('class.destroy')->where(['id' => '[0-9]+']);
    Route::post('/restore/{id}', [ClassController::class, 'restore'])->name('class.restore')->where(['id' => '[0-9]+']);
    Route::delete('/force-delete/{id}', [ClassController::class, 'forceDelete'])->name('class.force_delete')->where(['id' => '[0-9]+']);

    // Add students to class
    Route::get('/{id}/students/add', [ClassController::class, 'addStudents'])->name('class.add_students')->where(['id' => '[0-9]+']);
    Route::post('/{id}/students/store', [ClassController::class, 'storeStudents'])->name('class.store_students')->where(['id' => '[0-9]+']);
});

