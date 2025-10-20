<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teachers;
use Illuminate\Http\Request;

class TeacherTimeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $teacherCode = $request->input('teacher_code');

        // Khởi tạo truy vấn cho giảng viên
        $query = Teachers::query()
            ->withCount(['schedules as total_school_shifts' => function ($query) use ($startDate, $endDate) {
                if ($startDate && $endDate) {
                    $query->whereBetween('start_date', [$startDate, $endDate]);
                }
            }]);

        // Thêm điều kiện tìm kiếm nếu có
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                  ->orWhere('code', 'like', '%' . $search . '%');
        }

        // Thêm điều kiện lọc theo thời gian nếu có
        if ($startDate && $endDate) {
            $query->whereHas('schedules', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate]);
            });
        }

        // Thêm điều kiện lọc theo mã giảng viên nếu có
        if ($teacherCode) {
            $query->where('code', $teacherCode);
        }

        $teachers = $query->paginate(10);

        // Tính số giờ dạy dựa trên số ca học (mỗi ca học là 2 giờ)
        foreach ($teachers as $teacher) {
            // Tính tổng số giờ dạy trong khoảng thời gian lọc
            $totalHours = $teacher->total_school_shifts * 2;
            $teacher->teaching_hours = $totalHours;
        }

        return view('admin.dashboard.layout', [
            'template' => 'admin.teacher.teachertime.pages.index',
            'teachers' => $teachers,
            'search' => $search,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'teacherCode' => $teacherCode,
        ]);
    }
}


