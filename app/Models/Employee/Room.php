<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $table = 'rooms';
    protected $primaryKey = 'room_id';
    protected $fillable = ['room_name', 'id_user'];
    public $timestamps = false;

    // تعريف العلاقة بين Room و User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'users_id');
    }
}
