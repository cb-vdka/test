<?php

namespace App\Http\Controllers\Admin;

use App\Exports\TeachersExport;
use App\Http\Controllers\Controller;
use App\Models\Schedules;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class TeacherDateController extends Controller
{
    public function index(Request $request)
    {
        // Get the search query, date filters, and shift filter
        $search = $request->input('search');
        $shift = $request->input('shift');
    
        // Get the first and last day of the current month
        $currentMonthStart = Carbon::now()->startOfMonth()->toDateString();
        $currentMonthEnd = Carbon::now()->endOfMonth()->toDateString();
    
        // Use current month as default if no dates are provided
        $startDate = $request->input('start_date', $currentMonthStart);
        $endDate = $request->input('end_date', $currentMonthEnd);
    
        // Base query to get teachers with their respective number of sessions and shifts
        $teachersQuery = Schedules::select('class_subjects.teacher_id', 'teachers.name', 'teachers.code')
            ->selectRaw('COUNT(schedules.id) as total_sessions')
            ->selectRaw('COUNT(schedules.school_shift_id) as total_shifts')
            ->join('class_subjects', 'schedules.class_subject_id', '=', 'class_subjects.id')
            ->join('teachers', 'class_subjects.teacher_id', '=', 'teachers.id');
    
        // Apply search filter if a search query is provided
        if ($search) {
            $teachersQuery->where(function ($query) use ($search) {
                $query->where('teachers.name', 'like', '%' . $search . '%')
                      ->orWhere('teachers.code', 'like', '%' . $search . '%');
            });
        }
    
        // Apply date filters
        $teachersQuery->whereBetween('class_subjects.start_date', [$startDate, $endDate])
                      ->whereBetween('class_subjects.end_date', [$startDate, $endDate]);
    
        // Apply shift filter if provided
        if ($shift) {
            $teachersQuery->where('schedules.school_shift_id', $shift);
        }
    
        // Group by teacher ID and fetch data
        $teachers = $teachersQuery->groupBy('class_subjects.teacher_id', 'teachers.name', 'teachers.code')->get();
    
        // Pass the data to the view
        return view('admin.dashboard.layout', [
            'template' => 'admin.teacher.teacherday.pages.index',
            'teachers' => $teachers,
            'search' => $search,
            'shift' => $shift ?? '',
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }
    
    public function export(Request $request)
    {
        // Pass the request object to the export class to access filtering parameters
        return Excel::download(new TeachersExport($request), 'teachers.xlsx');
    }
    
}
