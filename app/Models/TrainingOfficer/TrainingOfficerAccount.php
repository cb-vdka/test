<?php

namespace App\Models\TrainingOfficer;

use App\Models\Roles;
use App\Models\Office;
use App\Models\Faculty;
use App\Models\Division;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class TrainingOfficerAccount extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'hometown',
        'office_id',
        'faculty_id',
        'division_id',
        'OTP',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at',
    ];
    protected $dates = ['deleted_at'];
    
    public function role()
    {
        return $this->belongsTo(Roles::class);
    }

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}
