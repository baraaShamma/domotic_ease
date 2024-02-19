<?php

namespace App\Http\Controllers\Esp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Esps\EspHome;
use App\Models\Esps\Device;
class EspController extends Controller
{
    public function getDevicesByEspId(Request $request)
    {
        try {
            $id_esp = $request->input('id_esp');

            $espHome = EspHome::where('id_esp', $id_esp)->first();
            // $state_esp = Esp::where('esp_id', $id_esp)->first("state_esp");
            if ($espHome) {
                $devices = $espHome->devices;
               $state_esp = $espHome->esp;
                return response()->json([
                    'status' => 'success',
                    'id_esp'=>$id_esp,
                   'state_esp'=>$state_esp,
                    'data' => $devices,
                ], 200);
            }
        else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'ESP not found.',
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
//     public function updateDeviceState(Request $request)
// {
//     // تحقق من وجود device_id في الطلب
//     if (!$request->has('device_id')) {
//         return response()->json(['status' => 'error', 'message' => 'device_id is required'], 400);
//     }

//     // استخراج قيمة device_id من الطلب
//     $device_id = $request->input('device_id');
//     $device_state= $request->input('device_state');

//     // ابحث عن الجهاز باستخدام النموذج Device
//     $device = Device::find($device_id);

//     // تحقق من وجود الجهاز
//     if (!$device) {
//         return response()->json(['status' => 'error', 'message' => 'Device not found'], 404);
//     }

//     // قم بتحديث قيمة state
//     // $device->state = $device->state == 0 ? 1 : 0;
//     if($device->state==0){
//         if($device_state==1){
//             $device->state=1;
//             $device->save();
//             return response()->json(['status' => 'success', 'message' => 'Device state updated successfully']);
//         }
//     }
//     if($device->state==1){
//         if($device_state==0){
//             $device->state=0;
//             $device->save();
//             return response()->json(['status' => 'success', 'message' => 'Device state updated successfully']);
//         }
//     }
    

//     // استجابة بنجاح
// }



public function updateDeviceState(Request $request)
{
    $request->validate([
        'id_esp' => 'required|string',
        'pin_number_output' => 'required|integer',
        'state' => 'required|integer',
    ]);

    $idEsp = $request->input('id_esp');
    $pinNumberOutput = $request->input('pin_number_output');
    $newState = $request->input('state');

    // التحقق مما إذا كان هناك سجل في جدول esp_home
    $espHome = EspHome::where('id_esp', $idEsp)->first();

    if ($espHome) {
        // التحقق مما إذا كان هناك سجل في جدول الأجهزة
        $device = $espHome->devices()->where('pin_number_output', $pinNumberOutput)->first();

        if ($device) {
            // التحقق مما إذا كانت الحالة في الجدول مختلفة عن الحالة الجديدة
            if ($device->state != $newState) {
                // قم بتحديث الحالة في الجدول إلى الحالة الجديدة
                $device->state = $newState;
                $device->save();
            }

            return response()->json(['status' => 'success', 'message' => 'تم تحديث حالة الجهاز بنجاح'], 200);
        }
    }

    return response()->json(['status' => 'error', 'message' => 'لم يتم العثور على الجهاز أو الـ id_esp'], 404);
}

public function getEspHomeId(Request $request)
{
    $request->validate([
        'id_esp' => 'required|string', // قم بتحديد القاعدة المناسبة لل id_esp
    ]);

    $idEsp = $request->input('id_esp');
    
    $espHome = EspHome::where('id_esp', $idEsp)->first();

    if ($espHome) {
        return response()->json(['status' => 'success', 'esp_home_id' => $espHome->esp_home_id]);
    } else {
        return response()->json(['status' => 'error', 'message' => 'Esp not found'], 404);
    }
}

}
