<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EspPinsOutPut extends Model
{
    use HasFactory;
    
    protected $table = 'esp_pins_output';
    protected $primaryKey = 'pin_number_output';
    
    protected $fillable = ['pin_number_output'];

}
