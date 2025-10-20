<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Teacher\TeachingScheduleController;
use App\Http\Controllers\Teacher\EnrollmentStudentController as TeacherEnrollmentStudentController;
use App\Http\Controllers\Teacher\EnrollmentController as TeacherEnrollmentController;
use App\Http\Middleware\Authentication;

Route::prefix('/teacher')->middleware(['web', Authentication::class])->group(function () {
    // Kiểm tra role teacher trong controller
    Route::get('/teaching_schedule/index', [TeachingScheduleController::class, 'index'])->name('teacher.teaching_schedule.index');
    Route::get('/teaching_schedule/debug', [TeachingScheduleController::class, 'debug'])->name('teacher.teaching_schedule.debug');
    Route::get('/teaching_schedule/show/{id}', [TeachingScheduleController::class, 'show'])->name('teacher.teaching_schedule.show');
    
    // Teacher score pages (copy of admin, filtered for teacher)
    Route::get('/enrollment_student/index', [TeacherEnrollmentStudentController::class, 'index'])->name('teacher.enrollment_student.index');
    Route::post('/enrollment_student/upload-score-sheet', [TeacherEnrollmentStudentController::class, 'uploadScoreSheet'])->name('teacher.enrollment_student.upload_score_sheet');
    Route::post('/enrollment_student/upload-pl-hdtl1-file', [TeacherEnrollmentStudentController::class, 'uploadPlHdtl1File'])->name('teacher.enrollment_student.upload_pl_hdtl1_file');
    Route::post('/enrollment_student/upload-pl-hdtl2-file', [TeacherEnrollmentStudentController::class, 'uploadPlHdtl2File'])->name('teacher.enrollment_student.upload_pl_hdtl2_file');
    
    // Score Sheet Management
    Route::post('/enrollment_student/toggle-status/{id}', [TeacherEnrollmentStudentController::class, 'toggleStatus'])->name('teacher.enrollment_student.toggle_status');
    Route::delete('/enrollment_student/delete-score-sheet/{id}', [TeacherEnrollmentStudentController::class, 'deleteScoreSheet'])->name('teacher.enrollment_student.delete_score_sheet');
    Route::put('/enrollment_student/update-score-sheet/{id}', [TeacherEnrollmentStudentController::class, 'updateScoreSheet'])->name('teacher.enrollment_student.update_score_sheet');
    Route::post('/enrollment_student/update-score-sheet/{id}', [TeacherEnrollmentStudentController::class, 'updateScoreSheet'])->name('teacher.enrollment_student.update_score_sheet_post');
    
    // PL HĐTL1 Management
    Route::post('/enrollment_student/toggle-pl-hdtl1-status/{id}', [TeacherEnrollmentStudentController::class, 'togglePlHdtl1Status'])->name('teacher.enrollment_student.toggle_pl_hdtl1_status');
    Route::delete('/enrollment_student/delete-pl-hdtl1-file/{id}', [TeacherEnrollmentStudentController::class, 'deletePlHdtl1File'])->name('teacher.enrollment_student.delete_pl_hdtl1_file');
    Route::put('/enrollment_student/update-pl-hdtl1-file/{id}', [TeacherEnrollmentStudentController::class, 'updatePlHdtl1File'])->name('teacher.enrollment_student.update_pl_hdtl1_file');
    Route::post('/enrollment_student/update-pl-hdtl1-file/{id}', [TeacherEnrollmentStudentController::class, 'updatePlHdtl1File'])->name('teacher.enrollment_student.update_pl_hdtl1_file_post');
    Route::get('/enrollment_student/download-pl-hdtl1-file/{id}', [TeacherEnrollmentStudentController::class, 'downloadPlHdtl1File'])->name('teacher.enrollment_student.download_pl_hdtl1_file');
    
// PL HĐTL2 Management
Route::post('/enrollment_student/toggle-pl-hdtl2-status/{id}', [TeacherEnrollmentStudentController::class, 'togglePlHdtl2Status'])->name('teacher.enrollment_student.toggle_pl_hdtl2_status');
Route::delete('/enrollment_student/delete-pl-hdtl2-file/{id}', [TeacherEnrollmentStudentController::class, 'deletePlHdtl2File'])->name('teacher.enrollment_student.delete_pl_hdtl2_file');
Route::put('/enrollment_student/update-pl-hdtl2-file/{id}', [TeacherEnrollmentStudentController::class, 'updatePlHdtl2File'])->name('teacher.enrollment_student.update_pl_hdtl2_file');
Route::get('/enrollment_student/pl-hdtl2-table', [TeacherEnrollmentStudentController::class, 'getPlHdtl2Table'])->name('teacher.enrollment_student.pl_hdtl2_table');

// AJAX Table Reload Routes
Route::get('/enrollment_student/pl-hdtl1-table', [TeacherEnrollmentStudentController::class, 'getPlHdtl1Table'])->name('teacher.enrollment_student.pl_hdtl1_table');
    
    Route::get('/enrollment/class-list', [TeacherEnrollmentController::class, 'classList'])->name('teacher.enrollment.class.list');
    Route::get('/enrollment/index', [TeacherEnrollmentController::class, 'index'])->name('teacher.enrollment.index');
    // Catalogue style page (table wrapper) similar to admin
    Route::get('/enrollment/catalogue', [TeacherEnrollmentController::class, 'index'])->name('teacher.enrollment.catalogue');
    
    // Các route khác bị chặn cho teacher
    Route::get('/teaching_schedule/create', [TeachingScheduleController::class, 'create'])->name('teacher.teaching_schedule.create');
    Route::post('/teaching_schedule/store', [TeachingScheduleController::class, 'store'])->name('teacher.teaching_schedule.store');
    Route::get('/teaching_schedule/edit/{id}', [TeachingScheduleController::class, 'edit'])->name('teacher.teaching_schedule.edit');
    Route::put('/teaching_schedule/update/{id}', [TeachingScheduleController::class, 'update'])->name('teacher.teaching_schedule.update');
    Route::get('/teaching_schedule/delete/{id}', [TeachingScheduleController::class, 'destroy'])->name('teacher.teaching_schedule.destroy');
});
