<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Middleware\Authentication;
use Illuminate\Support\Facades\Log;

Route::prefix('/wp-admin')->middleware(Authentication::class)->group(function () {
    Route::get('/trang-chu', [DashboardController::class, 'index'])->name('dashboard.index');

    // Proxy route: map /wp-admin/teacher/teaching_schedule/index to teacher route
    Route::get('/teacher/teaching_schedule/index', function () {
        return redirect()->route('teacher.teaching_schedule.index');
    })->name('wpadmin.teacher.teaching_schedule.index');

    $routeFiles = [
        'admin/user.php',
        'admin/student.php',
        'admin/subject.php',
        'admin/class.php',
        'admin/teacher.php',
        'admin/course.php',
        'admin/account.php',
        'admin/office.php',
        'admin/faculty.php',
        'admin/division.php',
        'admin/schedule.php',
        'admin/school_shift.php',
        'admin/classroom.php',
        'admin/teaching_schedule.php',
        'admin/enrollment.php',
        'admin/enrollment_student.php',
        'admin/student_chat.php',
        'admin/subject_register.php',
        'admin/training_officer_account.php',
        'admin/training_officer_chat.php',
        'admin/permissions.php',
    ];

    foreach ($routeFiles as $routeFile) {
        $filePath = __DIR__ . '/' . $routeFile;
        if (file_exists($filePath)) {
            require $filePath;
        } else {
            Log::error("Route không tồn tại: " . $filePath);
        }
    }
});
