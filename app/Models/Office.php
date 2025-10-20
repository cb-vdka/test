<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TrainingOfficer\TrainingOfficerAccount;

class Office extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'status',
    ];

    public function trainingOfficerAccounts()
    {
        return $this->hasMany(TrainingOfficerAccount::class, 'office_id');
    }
}
