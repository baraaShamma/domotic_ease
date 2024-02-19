<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterUser extends Model
{
    public $timestamps = false;
    protected $table = 'users';
    protected $fillable = [
                'first_name',
                'middle_name',
                'last_name',
                'email',
                'password',
                'phone',
                
            ];
            protected $hidden = [
                'password',
                
            ];
        
        }
