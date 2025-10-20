<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\StudentController;

Route::prefix('student')->group(function () {
    Route::get('/index', [StudentController::class, 'index'])->name('student.index');

    Route::get('/create', [StudentController::class, 'create'])->name('student.create');

    Route::post('/store', [StudentController::class, 'store'])->name('student.store');

    Route::get('/edit/{id}', [StudentController::class, 'edit'])->name('student.edit')->where(['id' => '[0-9]+']);

    Route::post('/update', [StudentController::class, 'update'])->name('student.update');

    Route::post('/trash/{id}', [StudentController::class, 'trash'])->name('student.trash')->where(['id' => '[0-9]+']);

    Route::post('/restore/{id}', [StudentController::class, 'restore'])->name('student.restore')->where(['id' => '[0-9]+']);

    Route::post('/delete/{id}', [StudentController::class, 'delete'])->name('student.delete')->where(['id' => '[0-9]+']);
});