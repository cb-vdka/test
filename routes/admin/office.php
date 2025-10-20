<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\OfficeController;

Route::prefix('office')->group(function () {
    Route::get('/index', [OfficeController::class, 'index'])->name('office.index');
    
    Route::get('/create', [OfficeController::class, 'create'])->name('office.create');
    Route::post('/store', [OfficeController::class, 'store'])->name('office.store');
    
    Route::get('/edit/{id}', [OfficeController::class, 'edit'])->name('office.edit')->where(['id' => '[0-9]+']);
    Route::match(['put', 'post'], '/update/{id}', [OfficeController::class, 'update'])->name('office.update')->where(['id' => '[0-9]+']);
    
    Route::delete('/destroy/{id}', [OfficeController::class, 'destroy'])->name('office.destroy')->where(['id' => '[0-9]+']);
});
