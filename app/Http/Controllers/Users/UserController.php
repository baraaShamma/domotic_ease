<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Users\LoginUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Users\Room;
use App\Models\Users\Device;
use App\Models\secondaryUsers\SecondaryUser;
use Illuminate\Support\Facades\Hash;
use App\Models\secondaryUsers\SecondaryRoom;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $responseData = [
                'status' => 'success',
                'data' => [
                    'users_id' => $user->users_id ,
                    'first_name_en' => $user->first_name_en,
                    'first_name_ar' => $user->first_name_ar,
                    'middle_name_en' => $user->middle_name_en,
                    'middle_name_ar' => $user->middle_name_ar,
                    'last_name_en' => $user->last_name_en,
                    'last_name_ar' => $user->last_name_ar,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'type_user' => $user->type_user,
                    // إذا كنت بحاجة إلى المزيد من المعلومات، قم بإضافتها هنا
                ],
            ];

            return response()->json($responseData, 200);
        } else {
            $responseData = [
                'status' => 'error',
                'message' => 'الايميل أو كلمة المرور غير صحيحة.',
            ];

            return response()->json($responseData, 401);
        }
    }
    public function getUserRooms(Request $request)
    {
        $request->validate([
            'users_id' => 'required|integer',
        ]);

        $userId = $request->input('users_id');
        $rooms =Room::where
            ('rooms.id_user', $userId)  
              ->select('room_id', 'room_name','image')
            ->get();

        $responseData = [
            'status' => 'success',
            'data' => $rooms,
        ];

        return response()->json($responseData, 200);
    }

    public function getDeviceRooms(Request $request)
    {
        $request->validate([
            'id_room' => 'required|integer',
        ]);
        $id_room  = $request->input('id_room');
        $device = Device::where('id_room', $id_room )->with('esp_home')
            ->get();
        $responseData = [
            'status' => 'success',
            'data' => $device,
        ];

        return response()->json($responseData, 200);
    }
    public function updateDeviceState(Request $request)
{
    // تحقق من وجود device_id في الطلب
    if (!$request->has('device_id')) {
        return response()->json(['status' => 'error', 'message' => 'device_id is required'], 400);
    }

    // استخراج قيمة device_id من الطلب
    $device_id = $request->input('device_id');
    $device_state= $request->input('device_state');

    // ابحث عن الجهاز باستخدام النموذج Device
    $device = Device::find($device_id);

    // تحقق من وجود الجهاز
    if (!$device) {
        return response()->json(['status' => 'error', 'message' => 'Device not found'], 404);
    }

    // قم بتحديث قيمة state
    // $device->state = $device->state == 0 ? 1 : 0;
    if($device->state==0){
        if($device_state==1){
            $device->state=1;
            $device->save();
            return response()->json(['status' => 'success', 'message' => 'Device state updated successfully']);
        }
    }
    if($device->state==1){
        if($device_state==0){
            $device->state=0;
            $device->save();
            return response()->json(['status' => 'success', 'message' => 'Device state updated successfully']);
        }
    }
    

    // استجابة بنجاح
}



    public function addSecondaryUser(Request $request)
    {
        // تحقق من صحة الطلب
        $request->validate(SecondaryUser::$rules);

        // استخراج بيانات الطلب
        $data = $request->only('name', 'username', 'password', 'id_user');

        // التحقق من وجود اسم المستخدم مسبقًا
        if (SecondaryUser::where('username', $data['username'])->exists()) {
            return response()->json([
                'status' => 'error',
                'message' => 'اسم المستخدم موجود مسبقاً'
            ], 400);
        }

        // تجزئة كلمة المرور
        $data['password'] = Hash::make($data['password']);

        // إنشاء مستخدم ثانوي جديد
        $user = SecondaryUser::create($data);

        // إرسال رسالة نجاح مع بيانات المستخدم الثانوي الجديد
        return response()->json([
            'status' => 'success',
            'data' => $user
        ], 201);
    }
    public function addSecondaryRoom(Request $request)
    {
        // تحقق من صحة الطلب
        $request->validate([
            'id_secondary_user' => 'required|integer',
            'id_room' => 'required|integer',
        ]);

        // استخراج بيانات الطلب
        $data = $request->only('id_secondary_user', 'id_room');

        // إضافة الغرفة الثانوية
        $room = SecondaryRoom::create($data);

        // إرسال رسالة نجاح مع بيانات الغرفة الثانوية الجديدة
        return response()->json([
            'status' => 'success',
            'data' => $room
        ], 201);
    }
    
public function getUserDetails(Request $request)
{
    $request->validate([
        'id_user' => 'required|integer',
    ]);

    $id_user = $request->input('id_user');

    $userDetails = SecondaryUser::where('id_user', $id_user)
        ->get(['secondary_users_id','name', 'username']);

    if ($userDetails->isEmpty()) {
        return response()->json(['status' => 'error', 'message' => 'No user found with the provided ID'], 404);
    }

    return response()->json(['status' => 'success', 'data' => $userDetails], 200);
}
}
