<?php

namespace App\Http\Controllers\TrainingOfficer;

use App\Http\Controllers\Controller;
use App\Models\Chats;
use App\Models\Students;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    protected $province;

    public function __construct()
    {
        $this->province = new Chats();
    }

    public function index()
    {
        $template = 'training_officer.chat.chat.pages.index';

        return view('training_officer.dashboard.layout', compact(
            'template',
        ));
    }

    public function updateNotification(Request $request)
    {
        $checkStudent = Students::find($request->student_id);

        $this->province->updateNotification($checkStudent->id, ['is_reply' => 1]);

        $request->session()->put('user_chat_id', $checkStudent->id);

        $request->session()->put('user_chat_name', $checkStudent->name);

        return redirect()->route('training_officer_chat.detail', $request->student_id);
    }

    public function detail()
    {
        $template = 'training_officer.chat.chat.pages.detail';

        return view('training_officer.dashboard.layout', compact(
            'template',
        ));
    }
}
