<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classes extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'name',
        'major_id',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at',
    ];

    protected $table = 'classes';

    public function major()
    {
        return $this->belongsTo(Major::class, 'major_id');
    }

    public function subject()
    {
        return $this->hasOne(Subjects::class, 'id', 'subject_id'); // Adjust the column names as per your database structure
    }

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }
}
