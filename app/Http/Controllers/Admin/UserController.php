<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {

        $template = "admin.user.user.pages.index";

        $config['seo'] = config('apps.user');

        return view('admin.dashboard.layout', compact(
            'template',
        ));
    }
}
