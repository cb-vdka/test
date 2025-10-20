<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DivisionController;

Route::prefix('division')->group(function () {
    Route::get('/index', [DivisionController::class, 'index'])->name('division.index');
    
    Route::get('/create', [DivisionController::class, 'create'])->name('division.create');
    Route::post('/store', [DivisionController::class, 'store'])->name('division.store');
    
    Route::get('/edit/{id}', [DivisionController::class, 'edit'])->name('division.edit')->where(['id' => '[0-9]+']);
    Route::match(['put', 'post'], '/update/{id}', [DivisionController::class, 'update'])->name('division.update')->where(['id' => '[0-9]+']);
    
    Route::delete('/destroy/{id}', [DivisionController::class, 'destroy'])->name('division.destroy')->where(['id' => '[0-9]+']);
});
