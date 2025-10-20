<?php

use App\Http\Controllers\Admin\ScanCardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\TeacherDateController;
use App\Http\Controllers\Admin\TeacherTimeController;
use App\Http\Controllers\Admin\TeachingMaterialController;
use App\Models\TeachingMaterial;

Route::prefix('teacher')->group(function () {
    Route::get('/index', [TeacherController::class, 'index'])->name('teacher.index');
    Route::get('/day', [TeacherDateController::class, 'index'])->name('teacher.day');
    Route::get('/create', [TeacherController::class, 'create'])->name('teacher.create');
    Route::post('/store', [TeacherController::class, 'store'])->name('teacher.store');

    Route::get('/edit/{id}', [TeacherController::class, 'edit'])->name('teacher.edit')->where(['id' => '[0-9]+']);
    Route::post('/update/{id}', [TeacherController::class, 'update'])->name('teacher.update')->where(['id' => '[0-9]+']);

    Route::get('/delete/{id}', [TeacherController::class, 'delete'])->name('teacher.delete')->where(['id' => '[0-9]+']);
    Route::delete('/destroy/{id}', [TeacherController::class, 'destroy'])->name('teacher.destroy')->where(['id' => '[0-9]+']);

    Route::get('/majors-by-course', [TeacherController::class, 'getMajorsByCourse'])->name('teacher.majors.by.course');
    Route::get('/excel-export', [TeacherDateController::class, 'export'])->name('export');
    Route::get('/teaching-materials', [TeachingMaterialController::class, 'index'])->name('materials.index');
    Route::get('/teaching-materials/{teachingMaterial}', [TeachingMaterialController::class, 'show'])->name('materials.show');


    Route::get('/create-materials', [TeachingMaterialController::class, 'create'])->name('teacher.create-materials');
    Route::post('/store-materials', [TeachingMaterialController::class, 'store'])->name('teacher.store-materials');
    Route::get('/materials/{id}/edit',[TeachingMaterialController::class, 'edit'])->name('materials.edit')->where(['id'=>'[0-9]+']);
    Route::post('/materials/{id}/update',[TeachingMaterialController::class, 'update'])->name('materials.update')->where(['id'=>'[0-9]+']);
    Route::delete('/materials/{id}', [TeachingMaterialController::class, 'destroy'])->name('teacher.materials.destroy')->where(['id' => '[0-9]+']);
    Route::get('/scanteacher', [ScanCardController::class, 'index'])->name('teacher.scan');
    Route::get('/scanteacher-create', [ScanCardController::class, 'create'])->name('teacher.add');
    Route::post('/scanstore', [ScanCardController::class, 'store'])->name('scan.store');
    Route::post('scansave', [ScanCardController::class, 'save'])->name('scan.save');
    Route::delete('user-info{id}', [ScanCardController::class, 'destroy'])->name('user-info.destroy');
    Route::get('user-info/{id}', [ScanCardController::class, 'show'])->name('user-info.show');

});
