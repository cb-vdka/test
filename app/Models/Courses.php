<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Courses extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'name',
        'training_level',
        'major_name',
        'major_code',
        'description',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function subjects()
    {
        return $this->hasMany(Subjects::class, 'course_id');
    }

    public function creator()
    {
        return $this->belongsTo(Account::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(Account::class, 'updated_by');
    }

    public function deleter()
    {
        return $this->belongsTo(Account::class, 'deleted_by');
    }

    public function major()
    {
        return $this->hasMany(Major::class, 'course_id');
    }
}
