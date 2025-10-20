<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'date_of_birth',
        'age',
        'gender',
        'id_number',
        'nationality',
        'home',
        'address',
        'province',
        'district',
        'ward',
        'street',
        'doe', // Date of Expiration
    ];

    protected $dates = ['date_of_birth', 'doe'];
}
