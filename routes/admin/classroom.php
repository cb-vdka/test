<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ClassroomController;

Route::prefix('classroom')->group(function () {
    Route::get('/index', [ClassroomController::class, 'index'])->name('classroom.index');
    Route::get('/create', [ClassroomController::class, 'create'])->name('classroom.create');
    Route::post('/store', [ClassroomController::class, 'store'])->name('classroom.store');
    Route::get('/edit/{id}', [ClassroomController::class, 'edit'])->name('classroom.edit')->where(['id' => '[0-9]+']);
    Route::post('/update/{id}', [ClassroomController::class, 'update'])->name('classroom.update')->where(['id' => '[0-9]+']);
    Route::delete('/destroy/{id}', [ClassroomController::class, 'destroy'])->name('classroom.destroy')->where(['id' => '[0-9]+']);
});
