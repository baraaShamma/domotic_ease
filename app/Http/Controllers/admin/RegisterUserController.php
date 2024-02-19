<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Admin\RegisterUser;
use Illuminate\Support\Facades\Hash;

class RegisterUserController extends Controller
{
    function registerUser(Request $request){
        try {
            $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6',
                'phone' => 'required',
            ]);
    
            $user = RegisterUser::create([
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
            ]);
    
            $responseData = [
                'status' => 'success',
                'data' => [
                    'first_name' => $user->first_name,
                    'middle_name' => $user->middle_name,
                    'last_name' => $user->last_name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'id' => $user->id,
                ],
            ];
    
            return response()->json($responseData, 201);
        } catch (\Exception $e) {
            // حالة الفشل
            $responseData = [
                'status' => 'failure',
                'message' => 'فشل في إضافة المستخدم. يرجى التحقق من البيانات المدخلة.',
            ];
    
            return response()->json($responseData, 400);
        }
    }
    
}
