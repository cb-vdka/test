<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\FacultyController;

Route::prefix('faculty')->group(function () {
    Route::get('/index', [FacultyController::class, 'index'])->name('faculty.index');
    
    Route::get('/create', [FacultyController::class, 'create'])->name('faculty.create');
    Route::post('/store', [FacultyController::class, 'store'])->name('faculty.store');
    
    Route::get('/edit/{id}', [FacultyController::class, 'edit'])->name('faculty.edit')->where(['id' => '[0-9]+']);
    Route::match(['put', 'post'], '/update/{id}', [FacultyController::class, 'update'])->name('faculty.update')->where(['id' => '[0-9]+']);
    
    Route::delete('/destroy/{id}', [FacultyController::class, 'destroy'])->name('faculty.destroy')->where(['id' => '[0-9]+']);
});
