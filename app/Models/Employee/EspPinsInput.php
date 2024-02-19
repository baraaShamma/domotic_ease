<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EspPinsInput extends Model
{
    use HasFactory;
    protected $table = 'esp_pins_input';
    protected $primaryKey = 'pin_number_input';
    
    protected $fillable = ['pin_number_input'];
}
