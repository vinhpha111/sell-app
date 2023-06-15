<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Store;
use App\Http\Requests\SignUpRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function signUp(SignUpRequest $request)
    {
        $user = User::where('phone', $request->phone)->first();
        if (!$user) {
            $user = User::create([
                'phone' => $request->phone,
                'sms_code_verify' => rand(0, 999999),
                'status' => User::STATUS['verifying']
            ]);
            $store = Store::create([
                'name' => $request->name,
                'owner_id' => $user->id
            ]);
            $user->update(['default_store_id' => $store->id]);
        } else {
            $user->update([
                'sms_code_verify' => rand(0, 999999)
            ]);
        }
        // will send otp sms in here
        return response()->json([
            'message' => __('messages.has_send_otp_login')
        ]);
    }

    public function checkExistUser(Request $request)
    {
        $request->validate([
            'phone' => ["required", "regex:/^(0[3|5|7|8|9])+([0-9]{8})$/"]
        ]);
        $user = User::where('phone', $request->phone)->first();
        if (!$user) {
            return response()->json([
                'message' => __('messages.not_found')
            ], Response::HTTP_NOT_FOUND);
        }
        return response()->json([
            'message' => __('messages.exist')
        ]);
    }

    public function loginOtp(Request $request)
    {
        $request->validate([
            'phone' => ["required", "regex:/^(0[3|5|7|8|9])+([0-9]{8})$/"],
            'code' => ['required', "string", "size:6"]
        ]);
        $user = User::where('phone', $request->phone)->where('sms_code_verify', $request->code)->first();
        if (!$user) {
            return response()->json([
                'message' => __('messages.login_otp_faild')
            ], Response::HTTP_FORBIDDEN);
        }
        $user->update([
            'sms_code_verify' => null,
            'phone_verified_at' => now(),
            'status' => User::STATUS['active']
        ]);
        return response()->json([
            'message' => __('messages.login_success'),
            'token' => $user->createToken(User::TOKEN_NAME)->plainTextToken,
            'user' => new UserResource($user)
        ]);
    }

    public function getUserInfo(Request $request)
    {
        return response()->json([
            'user' => new UserResource($request->user())
        ]);
    }
}
