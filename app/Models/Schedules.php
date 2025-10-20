<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Classes;
use App\Models\Subjects;
use App\Models\Teachers;
use App\Models\ClassSubject;
use App\Models\Classroom;
use App\Models\SchoolShift;

class Schedules extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
        'subject_id',
        'class_subject_id', // Giữ lại để tương thích ngược
        'teacher_id',
        'room_id',
        'school_shift_id',
        'day_of_week',
        'schedule_date',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at',
    ];

    // Relationships mới
    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subjects::class, 'subject_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teachers::class, 'teacher_id');
    }


    // Relationships cũ - giữ lại để tương thích ngược
    public function classSubject()
    {
        return $this->belongsTo(ClassSubject::class);
    }

    public function room()
    {
        return $this->belongsTo(Classroom::class, 'room_id');
    }

    public function schoolShift()
    {
        return $this->belongsTo(SchoolShift::class, 'school_shift_id');
    }

    // Alias methods for backward compatibility
    public function school_shift()
    {
        return $this->schoolShift();
    }
}
