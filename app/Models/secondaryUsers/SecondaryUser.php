<?php

namespace App\Models\secondaryUsers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecondaryUser extends Model
{
    use HasFactory;
    protected $table = 'secondary_users';
    protected $primaryKey = 'secondary_users_id';
    protected $fillable = ['name', 'username', 'password', 'id_user'];
    public $timestamps = false;
    public static $rules = [
        'name' => 'required|string|max:200',
        'username' => 'required|string|max:100',
        'password' => 'required|string|max:255',
        'id_user' => 'required|integer',
    ];

}
