<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\EnrollmentController;

Route::prefix('enrollment')->group(function () {
    Route::get('/', [EnrollmentController::class, 'classList'])->name('enrollment');
    Route::get('/index', [EnrollmentController::class, 'index'])->name('enrollment.index');
    Route::get('/edit/{id}', [EnrollmentController::class, 'edit'])->name('enrollment.edit')->where(['id' => '[0-9]+']);
    Route::post('/update/{id}', [EnrollmentController::class, 'update'])->name('enrollment.update')->where(['id' => '[0-9]+']);

    Route::get('/class-list', [EnrollmentController::class, 'classList'])->name('enrollment.class.list');

    Route::post('/import-excel', [EnrollmentController::class, 'import_excel'])->name('import.excel');
    Route::post('/upload-excel', [EnrollmentController::class, 'uploadExcel'])->name('enrollment.upload-excel');
    Route::get('/export/{classId}', [EnrollmentController::class, 'exportExcel'])->name('enrollment.export');

    Route::get('/setTimeEntryPoint', [EnrollmentController::class, 'setTimeEntryPoint'])->name('enrollment.setTimeEntryPoint');

});
