<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentChatController extends Controller
{
    public function index()
    {
        $template = 'student.student_chat.student_chat.pages.index';

        return view('student.dashboard.layout', compact(
            'template',
        ));
    }
}
