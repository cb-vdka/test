<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Roles;
use App\Models\User;

class Permission extends Model
{
        use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'display_name',
        'description',
    ];
}
