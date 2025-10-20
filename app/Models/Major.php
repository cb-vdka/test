<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Stmt\Class_;

class Major extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'code',
        'name',
        'standard',
        'status'
    ];

    public function subjects()
    {
        return $this->hasMany(Subjects::class, 'major_id');
    }

    // Bảng majors có course_id của bảng course, liên kết để lấy name của bảng courses
    public function course()
    {
        return $this->belongsTo(Courses::class, 'course_id');
    }

    public function classes()
    {
        return $this->hasMany(Classes::class);
    }

    public function scopegetMajor($query){
        return $query->orderBy('created_at', 'DESC')->get();
    }
}
