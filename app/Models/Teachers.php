<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teachers extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'name', 'image', 'email', 'phone', 'address', 'current_address',
        'gender', 'date_of_birth', 'qualifications', 'cccd_front', 'cccd_back',
        'bio', 'course_id', 'major_id', 'role_id', 'created_by', 'created_at',
        'updated_by', 'updated_at', 'deleted_by', 'deleted_at', 'OTP',
    ];

    public function role()
    {
        return $this->belongsTo(Roles::class);
    }

    public function course()
    {
        return $this->belongsTo(Courses::class, 'course_id');
    }

    public function major()
    {
        return $this->belongsTo(Major::class, 'major_id');
    }
    public function teachingMaterials()
    {
        return $this->hasMany(TeachingMaterial::class);
    }
}
