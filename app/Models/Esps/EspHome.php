<?php

namespace App\Models\Esps;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EspHome extends Model
{
    use HasFactory;
    protected $table = 'esp_home';
    protected $primaryKey = 'esp_home_id';
    public $timestamps = false;

    // تحديد العلاقة بين جدولي esp_home و devices
    public function devices()
    {
        return $this->hasMany(Device::class, 'id_esp', 'esp_home_id');
    }
    public function esp()
    {
        return $this->hasMany(Esp::class, 'esp_id', 'id_esp')->select("state_esp");
    }
}
