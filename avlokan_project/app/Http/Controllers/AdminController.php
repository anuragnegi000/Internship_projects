<?php

namespace App\Http\Controllers;

use App\Models\AdminToken;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Admin;
use App\Models\Models\JWTtoken;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
// use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;



class AdminController extends Controller
{
    // ...

    public function adminregister(Request $request)
    {
        $admin = Admin::create([
            'name' => $request->name,
            'age' => $request->age,
            'email' => $request->email,
            'password' => $request->password,
            'number' => $request->number,
            'city'=>$request->city,
            'pincode'=>$request->pincode,
            'state'=>$request->state,
            'country'=>$request->country,
        ]);

            return response()->json(['admin' => $admin]);
    }








    public function adminlog(Request $request)
{
    $number = $request->input('number');

    // Check if the number exists in the database
    $numberExists = Admin::where('number', $number)->exists();

    if ($numberExists) {
        return response()->json(['success' => true, 'message' => 'Number exists in the database']);
    } else {
        return response()->json(['success' => false, 'message' => 'Number does not exist in the database']);
    }
}








public function checkotp(Request $request)
    {
        $otp = $request->input('password');

        $passExists = Admin::where('password', $otp)->exists();

        if ($passExists) {
            $admin = Admin::where('password', $otp)->first();
            $token = Auth::guard('admin-api')->login($admin);

            // Store the token in the database
            $adminToken = AdminToken::create([
                'admin_id' => $admin->id,
                'token' => $token,
            ]);

            return response()->json([
                'success' => true,
                'token_type' => 'bearer',
                'message' => 'Password is correct',
                'access_token' => $token,
                'expires_in' => JWTAuth::factory()->getTTL() * 60,
            ]);
        } else {
            return response()->json(['success' => false, 'message' => 'Password does not match']);
        }
    }









    public function profile(Request $request)
    {
        $number = $request->input('number');
        $password = $request->input('password');

        // Verify the JWT token from the request header
        try {
            $token = $request->header('Authorization');
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized in exception'], 401);
        }

        // Retrieve the user based on the number and OTP
        $user = Admin::where('number', $number)->where('password', $password)->first();

        // Check if the user exists
        if ($user) {
            // Return the user details
            return response()->json(['user' => $user]);
        } else {
            return response()->json(['error' => 'User not found'], 404);
        }
    }





    public function update(Request $request)
    {
        {
            try{
            // Verify the JWT token from the request header
            $token = $request->bearerToken();
        $user = JWTAuth::parseToken()->authenticate($token);

        // Check if the user exists
        if (!$user) {
            return response()->json(['error' => 'Unauthorized in user details'], 401);
        }

        // Validate the request data
        $request->validate([
            'phone_number' => 'required|string|max:15|unique:users,phone_number,' . $user->id,
        ]);

        // Update the user's phone number
        $user->phone_number = $request->phone_number;
        $user->save();
    }
    catch(\Exception $e){
        return response()->json(['error'=>'Unauthorized in exception'],303);
    }
        return response()->json(['message' => 'Phone number updated successfully']);
        }
    }










    protected function responsedWithToken($token)
    {
        return response()->json([
            'access_token'=>$token,
            'token_type'=>'bearer',
            'expires_in'=>JWTAuth::auth()->factory()->getTTL()*60
        ]);
    }


    // public function adminlog(Request $request)
    // {
    //     $admin = Admin::create([

    //     ])
    // }

    }

