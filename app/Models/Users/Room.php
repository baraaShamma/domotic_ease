<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $table = 'rooms';
    protected $primaryKey = 'room_id';
    public $timestamps = false;

    // تعريف العلاقة بين Room و User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'users_id');
    }
}
