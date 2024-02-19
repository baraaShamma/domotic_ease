<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Employee extends Model
{
    use HasFactory;
    protected $table = 'employees';
    public $timestamps = false;

    protected $fillable = [
        'username', 'email', 'password', 'token',
    ];

    // إعداد ال token تلقائيًا قبل حفظ السجل
    public static function boot()
    {
        parent::boot();

        static::creating(function ($employee) {
            $employee->token = Str::random(16);
        });
    }
}
