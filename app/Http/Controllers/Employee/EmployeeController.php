<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee\Employee;
use App\Models\Employee\EmployeesTask;
use Illuminate\Support\Facades\DB;
use App\Models\Employee\Room;
use App\Models\Employee\EspHome;
use App\Models\Employee\Device;
use App\Models\Employee\EspPinsInput;
use App\Models\Employee\EspPinsOutPut;

class EmployeeController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $employee = Employee::where('email', $request->email)->first();

        if ($employee && password_verify($request->password, $employee->password)) {
            $responseData = [
                'status' => 'success',
                'data' => [
                    'employee_id' => $employee->employees_id,
                    'username' => $employee->username,
                    'email' => $employee->email,
                    // يمكنك تضمين المزيد من البيانات إذا لزم الأمر
                ],
                'message' => 'تم تسجيل الدخول بنجاح.',
            ];
        } else {
            $responseData = [
                'status' => 'error',
                'message' => 'فشل تسجيل الدخول. برجاء التحقق من البريد الإلكتروني وكلمة المرور.',
            ];
        }

        return response()->json($responseData);
    }
    public function getEmployeeTasks(Request $request)
    {
        $id_employees = $request->input('id_employees');

        $tasks = EmployeesTask::with(['user:users_id,first_name,last_name,phone,address'])
            ->where('id_employees', $id_employees)
            ->get();
        if ($tasks->isEmpty()) {
            return response()->json(['status' => 'success', 'data' => []]);
            // return response()->json(['message' => 'لا توجد مهام للموظف.']);؟
        }
        $response = [
            'status' => 'success',
            'data' => $tasks
        ];

        return response()->json($response);
    }


    public function addRoom(Request $request)
    {
        // يجب أن يكون الطلب يحتوي على id_user و room_name
        $id_user = $request->input('id_user');
        $room_name = $request->input('room_name');

        // قم بإنشاء غرفة جديدة
        $room = Room::create([
            'room_name' => $room_name,
            'id_user' => $id_user,
        ]);

        // قم بإرجاع الرد بعد إضافة الغرفة بنجاح
        return response()->json(['status' => 'success', 'data' => $room], 201);
    }
    public function getUserRooms(Request $request)
    {
        $id_user = $request->input('id_user');

        try {
            $userRooms = Room::where('id_user', $id_user)->get();

            return response()->json([
                'status' => 'success',
                'data' => $userRooms,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'حدث خطأ أثناء جلب الغرف.',
            ], 500);
        }
    }
    public function getUserIdEsp(Request $request)
    {
        try {
            $id_user = $request->input('id_user');
            $userEsps = EspHome::where('id_user', $request->id_user)->get();

            if ($userEsps->isNotEmpty()) {
                $espsData = $userEsps->map(function ($userEsp) {
                    return [
                        'esp_home_id' => $userEsp->esp_home_id,
                        'id_esp' => $userEsp->id_esp,
                    ];
                });

                return response()->json([
                    'status' => 'success',
                    'data' => $espsData,
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'لا توجد بيانات EspHome لهذا المستخدم.',
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'حدث خطأ أثناء جلب id_esp.',
            ], 500);
        }
    }

    public function getAvailablePinsInput(Request $request)
    {
        // التحقق مما إذا كانت القيمة موجودة في الـ request
        if ($request->has('espid')) {
            $espid = $request->input('espid');

            // جلب قائمة الـ pin_number_input المستخدمة لهذا الـ esp
            $usedPins = Device::where('id_esp', $espid)->pluck('pin_number_input');

            // الحصول على الـ pin_number_input التي لم تُستخدم بعد
            $availablePins = EspPinsInput::whereNotIn('pin_number_input', $usedPins)->get();

            // تنسيق الناتج كما هو مطلوب
            $response = [
                'status' => 'success',
                'data' => $availablePins,
            ];

            return response()->json($response);
        } else {
            // في حالة عدم توفر قيمة espid في الطلب
            $response = [
                'status' => 'error',
                'message' => 'يجب توفير espid في الطلب',
            ];

            return response()->json($response, 400);
        }
    }
    public function getAvailablePinsOutPut(Request $request)
    {
        // التحقق مما إذا كانت القيمة موجودة في الـ request
        if ($request->has('espid')) {
            $espid = $request->input('espid');

            // جلب قائمة الـ pin_number_input المستخدمة لهذا الـ esp
            $usedPins = Device::where('id_esp', $espid)->pluck('pin_number_output');

            // الحصول على الـ pin_number_input التي لم تُستخدم بعد
            $availablePins = EspPinsOutPut::whereNotIn('pin_number_output', $usedPins)->get();

            // تنسيق الناتج كما هو مطلوب
            $response = [
                'status' => 'success',
                'data' => $availablePins,
            ];

            return response()->json($response);
        } else {
            // في حالة عدم توفر قيمة espid في الطلب
            $response = [
                'status' => 'error',
                'message' => 'يجب توفير espid في الطلب',
            ];

            return response()->json($response, 400);
        }
    }

    public function addDevice(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'pin_number_input' => 'required|integer',
                'device_name' => 'required|string',
                'pin_number_output' => 'required|integer',
                'id_esp' => 'required|exists:esp_home,esp_home_id',
                'id_room' => 'required|exists:rooms,room_id',
            ]);

            Device::create([
                'pin_number_input' => $validatedData['pin_number_input'],
                'device_name' => $validatedData['device_name'],
                'pin_number_output' => $validatedData['pin_number_output'],
                'state' => 0,  // القيمة الافتراضية لـ state
                'id_esp' => $validatedData['id_esp'],
                'id_room' => $validatedData['id_room'],
            ]);

            // $device->creat();

            return response()->json([
                'status' => 'success',
                'message' => 'تمت إضافة الجهاز بنجاح',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
