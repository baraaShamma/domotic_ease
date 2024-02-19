<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Esp extends Model
{
    use HasFactory;
    protected $table = 'esp';
    protected $primaryKey = 'esp_id';
    public $timestamps = false;
}
