<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Employee;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin\EmployeesTasks;
class AdminEmployeeController extends Controller
{
    //
    public function addEmployee(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'email' => 'required|email|unique:employees',
            'password' => 'required|min:6',
        ]);

        // Create a new employee record
        $employee = Employee::create([
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        $responseData = [
            'status' => 'success',
            'data' => $employee,
            'message' => 'تمت إضافة الموظف بنجاح.',
        ];

        return response()->json($responseData, 201);
    }
    public function addTask(Request $request)
    {
        // التحقق من البيانات المدخلة من قبل المستخدم
        $request->validate([
            'id_employees' => 'required|exists:employees,employees_id',
            'id_user' => 'required|exists:users,users_id',
        ]);

        // إنشاء مهمة جديدة باستخدام النموذج
        $task = new EmployeesTasks;
        $task->id_employees = $request->input('id_employees');
        $task->id_user = $request->input('id_user');

        // حفظ المهمة في قاعدة البيانات
        $task->save();

        return response()->json(['message' => 'تمت إضافة المهمة بنجاح.']);
    }
}
