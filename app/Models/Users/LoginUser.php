<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginUser extends Model
{
    use HasFactory;

    protected $table = 'users';

    protected $fillable = [
        'email',
        'password',
    ];

    // قم بتعديل هذا الجزء بناءً على احتياجاتك
    protected $hidden = [
        'password',
    ];
}
