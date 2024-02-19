<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeesTask extends Model
{
    use HasFactory;
    protected $table = 'employees_tasks';
    protected $primaryKey = 'employees_tasks_id';
    public $timestamps = false;

    // تعريف العلاقة مع جدول الـ User
    public function user()
    {
        return $this->belongsTo(\App\Models\Employee\User::class, 'id_user');
    }

    // تعريف العلاقة مع جدول الـ ESP
    public function esp()
    {
        return $this->belongsTo(\App\Models\Employee\Esp::class, 'id_esp');
    }
}
