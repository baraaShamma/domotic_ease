<?php

namespace App\Models\secondaryUsers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecondaryRoom extends Model
{
    use HasFactory;
    protected $table = 'secondary_rooms';
    protected $primaryKey = 'secondary_rooms_id';
    protected $fillable = ['id_secondary_user', 'id_room'];
    public $timestamps = false;

}
