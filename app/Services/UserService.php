<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserService
{
    public function register($request)
    {
        $validator = Validator::make(['email' => $request->email, 'password' => $request->password, 'password_confirmation' => $request->cPassword, 'name' => $request->name], [
            'email' => 'required|email|unique:users',
            'name' => 'required',
            'password' => 'required|min:8|confirmed'
        ]);

        if ($validator->fails()) {
            return ['status' => false, 'messages' => $validator->messages()];
        }
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'name' => $request->name,
        ]);
        $token = $user->createToken($request->deviceName)->plainTextToken;
        return ['status' => true, 'token' => $token, 'user' => $user];
    }


    public function login($request)
    {
        $validator = Validator::make(['email' => $request->email, 'password' => $request->password], [
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        if ($validator->fails()) {
            return ['status' => false, 'messages' => $validator->messages()];
        }

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return ['status' => false, 'messages' => ['email' => ["Sorry, we couldn't find this email. Please register !!!"]]];
        }

        if (Hash::check($request->password, $user->password)) {
            $token = $user->createToken($request->deviceName)->plainTextToken;
            return ['status' => true, 'token' => $token, 'user' => $user];
        }

        return ['status' => false, 'messages' => ['password' => ['Incorrect Password!!!']]];
    }
}
