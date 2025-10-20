<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Chats extends Model
{
    use HasFactory;

    public $table = 'chats';

    protected $data;

    protected $fillable = [
        'student_id',
        'role_id',
        'reply_to',
        'message',
        'is_reply',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at',
    ];

    public function getChatDetail($id)
    {
        $data = Chats::where('student_id', $id)
            ->orWhere('reply_to', $id)
            ->get();

        return $data;
    }

    public function getChatDetailByStudent()
    {
        $data = Chats::get();

        return $data;
    }

    public function getAllChat($searchItem = null)
    {
        $data = Chats::select('chats.student_id', 'chats.message', 'chats.created_at', 'students.name', DB::raw('COUNT(unread_chats.id) as unread_count'))
            ->join('students', 'chats.student_id', '=', 'students.id')
            ->leftJoin('chats as last_messages', function ($join) {
                $join->on('chats.student_id', '=', 'last_messages.student_id')
                    ->on('chats.created_at', '<', 'last_messages.created_at');
            })
            ->leftJoin('chats as unread_chats', function ($join) {
                $join->on('chats.student_id', '=', 'unread_chats.student_id')
                    ->where('unread_chats.is_reply', '=', 0);
            })
            ->whereNull('last_messages.student_id')
            ->groupBy('chats.student_id', 'students.name', 'chats.message', 'chats.created_at')
            ->orderBy('chats.created_at', 'desc');

        if (!empty($searchItem)) {
            $data->where('students.name', 'LIKE', '%' . $searchItem . '%');
        }

        return $data
            ->get();
    }

    public function sendMessage($student_id = null, $message, $role_id, $reply_to = null)
    {
        return Chats::create([
            'student_id' => $student_id,
            'message' => $message,
            'role_id' => $role_id,
            'reply_to' => $reply_to,
            'created_at' => now(),
        ]);
    }

    public function updateNotification($student_id, $data)
    {
        return Chats::where('student_id', $student_id)
            ->update($data);
    }

    public function student()
    {
        return $this->belongsTo(Students::class, 'student_id');
    }
}
