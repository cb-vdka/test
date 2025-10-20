<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Classes;

class ClassesController extends Controller
{
    public function byMajor(Request $request)
    {
        $majorId = $request->query('major_id');
        if (!$majorId) {
            return response()->json([], 200);
        }
        $classes = Classes::where('major_id', $majorId)
            ->select('id','name')
            ->orderBy('name')
            ->get();
        return response()->json($classes);
    }
}


