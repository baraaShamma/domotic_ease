<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Admin\Esp;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    //
    public function addEsp(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
        ]);
        $username = $request->input('username');
        // إنشاء رمز فريد
        $uniqueCode = Str::uuid()->toString();
        // إنشاء esp_id باستخدام اسم المستخدم والرمز الفريد
        $espId = $username . '_' . $uniqueCode;
        // إدراج البيانات في جدول esp
        $admin = Esp::create([
            'esp_id' => $espId,
            'state_esp' => 0,
        ]);
        $responseData = [
            'status' => 'success',
            'data' => [
                'esp_id' => $espId
            ],
        ];
        // يمكنك إرجاع البيانات إلى العميل إذا كنت بحاجة إلى ذلك
        return response()->json($responseData, 201);
    }
    
    public function searchUserByEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
        ]);
        $email = $request->input('email');
        // البحث عن المستخدمين باستخدام LIKE للبريد الإلكتروني

        $users = DB::table('users')->where('email', 'LIKE', '%' . $email . '%')->get(['users_id', 'email']);

        if ($users->isEmpty()) {
            $responseData = [
                'status' => 'error',
                'message' => 'لم يتم العثور على مستخدم باستخدام هذا البريد الإلكتروني.',
            ];

            return response()->json($responseData, 404);
        }

        $responseData = [
            'status' => 'success',
            'data' => $users,
        ];

        return response()->json($responseData, 200);
    }
    public function searchESPById(Request $request)
    {
        $request->validate([
            'esp_id' => 'required|string',
        ]);

        $espId = $request->input('esp_id');

        // البحث عن ESP باستخدام LIKE للـ esp_id
        $esp = DB::table('esp')->where('esp_id', 'LIKE', '%' . $espId . '%')->where('state_esp', 0)->get();

        if ($esp->isEmpty()) {
            $responseData = [
                'status' => 'error',
                'message' => 'لم يتم العثور على ESP باستخدام هذا الـ esp_id.',
            ];

            return response()->json($responseData, 404);
        }

        $responseData = [
            'status' => 'success',
            'data' => $esp,
        ];

        return response()->json($responseData, 200);
    }

    public function addESPtoHome(Request $request)
    {
        $request->validate([
            'id_user' => 'required|integer',
            'id_esp' => 'required|string',
        ]);
        $id_user = $request->input('id_user');
        $id_esp = $request->input('id_esp');

        // إضافة سجل جديد إلى جدول esp_home
        $espHome = DB::table('esp_home')->insert([
            'id_user' => $id_user,
            'id_esp' => $id_esp,
        ]);
          DB::table('esp')->where('esp_id', $id_esp)->update([
            'state_esp' => 1, // تعديل القيمة حسب الحالة المطلوبة
        ]);

        $responseData = [
            'status' => 'success',
            'data' => $espHome,
        ];

        return response()->json($responseData, 201);
    }
}
