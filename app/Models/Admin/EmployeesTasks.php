<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeesTasks extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'employees_tasks';
    protected $primaryKey = 'employees_tasks_id';

    protected $fillable = ['id_user', 'id_esp', 'id_employees'];
}
