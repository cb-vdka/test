<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\EnrollmentStudentController;

Route::prefix('enrollment_student')->group(function () {
    Route::get('/index', [EnrollmentStudentController::class, 'index'])->name('enrollment_student.index');
    Route::get('/download-score-sheet/{id}', [EnrollmentStudentController::class, 'downloadScoreSheet'])->name('enrollment_student.download_score_sheet');
    Route::post('/update-score-sheet/{id}', [EnrollmentStudentController::class, 'updateScoreSheet'])->name('enrollment_student.update_score_sheet');
    Route::post('/upload-score-sheet', [EnrollmentStudentController::class, 'uploadScoreSheet'])->name('enrollment_student.upload_score_sheet');
    Route::post('/toggle-status/{id}', [EnrollmentStudentController::class, 'toggleStatus'])->name('enrollment_student.toggle_status');
    Route::delete('/delete-score-sheet/{id}', [EnrollmentStudentController::class, 'deleteScoreSheet'])->name('enrollment_student.delete_score_sheet');
    
    // PL HĐTL1 Routes
    Route::post('/upload-pl-hdtl1-file', [EnrollmentStudentController::class, 'uploadPlHdtl1File'])->name('enrollment_student.upload_pl_hdtl1_file');
    Route::get('/download-pl-hdtl1-file/{id}', [EnrollmentStudentController::class, 'downloadPlHdtl1File'])->name('enrollment_student.download_pl_hdtl1_file');
    Route::post('/update-pl-hdtl1-file/{id}', [EnrollmentStudentController::class, 'updatePlHdtl1File'])->name('enrollment_student.update_pl_hdtl1_file');
    Route::post('/toggle-pl-hdtl1-status/{id}', [EnrollmentStudentController::class, 'togglePlHdtl1Status'])->name('enrollment_student.toggle_pl_hdtl1_status');
    Route::delete('/delete-pl-hdtl1-file/{id}', [EnrollmentStudentController::class, 'deletePlHdtl1File'])->name('enrollment_student.delete_pl_hdtl1_file');
    
    // PL HĐTL2 Routes
    Route::post('/upload-pl-hdtl2-file', [EnrollmentStudentController::class, 'uploadPlHdtl2File'])->name('enrollment_student.upload_pl_hdtl2_file');
    Route::get('/download-pl-hdtl2-file/{id}', [EnrollmentStudentController::class, 'downloadPlHdtl2File'])->name('enrollment_student.download_pl_hdtl2_file');
    Route::post('/update-pl-hdtl2-file/{id}', [EnrollmentStudentController::class, 'updatePlHdtl2File'])->name('enrollment_student.update_pl_hdtl2_file');
    Route::post('/toggle-pl-hdtl2-status/{id}', [EnrollmentStudentController::class, 'togglePlHdtl2Status'])->name('enrollment_student.toggle_pl_hdtl2_status');
    Route::delete('/delete-pl-hdtl2-file/{id}', [EnrollmentStudentController::class, 'deletePlHdtl2File'])->name('enrollment_student.delete_pl_hdtl2_file');
    
    // Test route để debug
    Route::post('/test-update/{id}', function(Request $request, $id) {
        return response()->json([
            'success' => true,
            'message' => 'Test route working',
            'id' => $id,
            'data' => $request->all(),
            'file' => $request->hasFile('file') ? 'File present' : 'No file'
        ]);
    })->name('enrollment_student.test_update');
    
    // Test route đơn giản nhất
    Route::post('/simple-test/{id}', function($id) {
        return response()->json(['test' => 'success', 'id' => $id]);
    })->name('enrollment_student.simple_test');
    
});
