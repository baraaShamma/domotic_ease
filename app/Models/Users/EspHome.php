<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EspHome extends Model
{
    use HasFactory;
    protected $table = 'esp_home';

    protected $primaryKey = 'esp_home_id';

    protected $fillable = [
        'id_user',
        'id_esp',
    ];

    // تعريف العلاقات بين الجداول
    public function esp()
    {
        return $this->belongsTo(Esp::class, 'id_esp', 'esp_id');
    }

    public function devices()
    {
        return $this->hasMany(Device::class, 'esp_home_id', 'id_esp');
    }
}
