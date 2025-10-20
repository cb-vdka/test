<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SubjectRegistrationController;

Route::prefix('subject_register')->group(function () {
    Route::get('/get_course', [SubjectRegistrationController::class, 'getCourse'])->name('get.course');
    Route::get('/get_subject/{id}', [SubjectRegistrationController::class, 'getSubject'])->name('get.subject');
    Route::get('/get_class/{id}', [SubjectRegistrationController::class, 'getClass'])->name('get.class');
    Route::post('/insert_class', [SubjectRegistrationController::class, 'handleInsertClassData'])->name('insert.class');
});