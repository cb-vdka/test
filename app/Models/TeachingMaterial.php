<?php

namespace App\Models;

use App\Models\TrainingOfficer\TrainingOfficerAccount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeachingMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'officer_id',
        'course_id',
        'title',
        'description',
        'file_path',
    ];

    public function officer()
    {
        return $this->belongsTo(TrainingOfficerAccount::class, 'officer_id');
    }

    public function course()
    {
        return $this->belongsTo(Courses::class, 'course_id');
    }
}

