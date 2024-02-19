<?php

namespace App\Models\Esps;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;
    protected $table = 'devices';
    protected $primaryKey = 'device_id';
    public $timestamps = false;

}
