<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrainingOfficer\AccountController as TrainingOfficerAccountController;

Route::prefix('training_officer_account')->group(function () {
    Route::get('/index', [TrainingOfficerAccountController::class, 'index'])->name('training_officer_account.index');

    Route::get('/create', [TrainingOfficerAccountController::class, 'create'])->name('training_officer_account.create');
    Route::post('/store', [TrainingOfficerAccountController::class, 'store'])->name('training_officer_account.store');

    Route::get('/edit/{id}', [TrainingOfficerAccountController::class, 'edit'])->name('training_officer_account.edit')->where(['id' => '[0-9]+']);
    Route::match(['put', 'post'], '/update/{id}', [TrainingOfficerAccountController::class, 'update'])->name('training_officer_account.update')->where(['id' => '[0-9]+']);


    Route::get('/delete/{id}', [TrainingOfficerAccountController::class, 'delete'])->name('training_officer_account.delete')->where(['id' => '[0-9]+']);
    Route::delete('/destroy/{id}', [TrainingOfficerAccountController::class, 'destroy'])->name('training_officer_account.destroy')->where(['id' => '[0-9]+']);
    Route::post('/{id}/restore', [TrainingOfficerAccountController::class, 'restore'])->name('training_officer_account.restore');
    Route::delete('/{id}/force-delete', [TrainingOfficerAccountController::class, 'forceDelete'])->name('training_officer_account.forceDelete');
    
    Route::get('/export', [TrainingOfficerAccountController::class, 'export'])->name('training_officer_account.export');
});
