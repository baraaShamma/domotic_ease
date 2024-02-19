<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Esp extends Model
{
    use HasFactory;

    protected $table = 'esp'; // اسم الجدول في قاعدة البيانات

    protected $primaryKey = 'esp_id'; // اسم العمود الرئيسي

    protected $fillable = [
        'esp_id',
        'state_esp',
    ];

    public $timestamps = false; // تعطيل الحقول التلقائية created_at و updated_at

    // تحديد حد أقصى لطول esp_id
    protected $maxLength = 20;

    // Mutator للتأكد من أن الطول لا يتجاوز الحد الأقصى
    public function setEspIdAttribute($value)
    {
        $this->attributes['esp_id'] = substr($value, 0, $this->maxLength);
    }
}
