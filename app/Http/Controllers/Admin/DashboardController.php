<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Account;
use App\Models\Students;
use App\Models\Teachers;
use App\Models\TrainingOfficer\TrainingOfficerAccount;

use App\Models\Classes;  // Assuming your model is named Classes
use App\Models\Classroom;
use App\Models\Courses;
use App\Models\Major;
use App\Models\Subjects;
use App\Models\Office;
use App\Models\Faculty;
use App\Models\Division;

class DashboardController extends Controller
{
    public function index()
    {
        // Count accounts from each table
        $adminCount = Account::count();
        $studentCount = Students::count();
        $teacherCount = Teachers::count();
        $trainingOfficerCount = TrainingOfficerAccount::count();
        
        // Total number of all accounts
        $totalAccounts = $adminCount + $studentCount + $teacherCount + $trainingOfficerCount;

        // Count educational entities
        $classesCount = Classes::count();  // Using Classes as the model name
        $classroomsCount = Classroom::count();
        $coursesCount = Courses::count();
        $majorsCount = Major::count();
        $subjectsCount = Subjects::count();
        
        // Count new department structure
        $officesCount = Office::count();
        $facultiesCount = Faculty::count();
        $divisionsCount = Division::count();
        
        // Biểu đồ tròn
        $data = [$adminCount, $trainingOfficerCount, $studentCount, $teacherCount,];
        $labels = ['Quản trị viên', 'Cán bộ', 'Học viên', 'Giáo viên',];

        $template = 'admin.dashboard.pages.index';

        return view('admin.dashboard.layout', compact(
            'template', 
            'data', 
            'labels',
            'adminCount', 
            'studentCount', 
            'teacherCount', 
            'trainingOfficerCount',
            'totalAccounts',

            'classesCount',
            'classroomsCount',
            'coursesCount',
            'majorsCount',
            'subjectsCount',
            'officesCount',
            'facultiesCount',
            'divisionsCount'
        ));
    }

    
}