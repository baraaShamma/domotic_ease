<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;
    protected $table = 'devices';
    protected $primaryKey = 'device_id';
    public $timestamps = false;

    protected $fillable = ['pin_number_input', 'device_name', 'pin_number_output', 'state', 'id_esp', 'id_room'];
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'id_room');
    }   public function esp_home()
    {
        return $this->belongsTo(Room::class, 'esp_home_id', 'id_esp');
    }
}
