<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subjects extends Model
{
    use HasFactory;

    protected $fillable = [
        'major_id',
        'subject_type_id',
        'course_id',
        'code',
        'name',
        'credit_num',
        'total_class_session',
        'status',
        'created_at',
        'updated_at',
    ];

    public function classes()
    {
        return $this->hasMany(Classes::class, 'subject_id');
    }

    public function course()
    {
        return $this->belongsTo(Courses::class, 'course_id');
    }

    // no custom mutator needed; using correct column name

    public function major()
    {
        return $this->belongsTo(Major::class, 'major_id');
    }
}
