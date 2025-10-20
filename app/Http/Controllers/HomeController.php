<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Roles;

class HomeController extends Controller
{
    public function index() {
        // Lấy tất cả roles từ database
        $roles = Roles::where('status', 'active')
                     ->orderBy('sort_order', 'asc')
                     ->orderBy('name', 'asc')
                     ->get();
        
        return view('home', compact('roles'));
    }
}
