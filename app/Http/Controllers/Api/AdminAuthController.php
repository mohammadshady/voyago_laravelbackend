<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;


class AdminAuthController extends Controller
{
    
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = auth('admin')->attempt($credentials)) {
            return response()->json(['status' => 'failure' ,'error' => 'Invalid Credentials'], 401);
        }

        $admin = Admin::where('email', $request->email)->first();

        return response()->json([
            'status' => 'success',
            'admin' => $admin,
            'token' => $token
        ]);
    }

    
    public function logout(Request $request)
    {
        auth('admin')->logout(); 
        return response()->json(['message' => 'Logged out successfully']);
    }


    public function changePassword(Request $request)
    {
        /** @var \App\Models\Admin $admin */

        $admin = auth()->user(); 

        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        if (!Hash::check($request->current_password, $admin->password)) {
            return response()->json(['status' => 'failure','current_password' => 'Current password is incorrect'], 200);
        }

        if($validator->fails()){
            return response()->json(['status' => 'failure confirm','confirm_password' => 'The new password field confirmation does not match'], 200);
        }

    

        $admin->password = $request->new_password;
        $admin->save();

        //to login with new password
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['status' => 'success','message' => 'Password changed successfully']);
    }

}
