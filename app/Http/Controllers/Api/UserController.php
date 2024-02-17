<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function Registration(RegistrationRequest $request)
    {
        User::create($request->validated());

        return response()->json([
            'status' => true,
            'message' => 'User regestration complete'
        ]);
    }

    

    public function Login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if(!empty($user))
        {
            if(Hash::check($request->password, $user->password))
            {
                $token = $user->createToken('Token')->plainTextToken;
                return response()->json([
                    'status' => true,
                    'message' => 'Login successful.',
                    'token' => $token
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Invalid password.'
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Invalid login data.'
        ]);
    }

    public function profile()
    {
        $data = Auth::user();

        return response()->json([
            'status' => true,
            'message' => 'Profile data',
            'user' => $data
        ]);
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();

        return response()->json([
            'status' => true,
            'message' => 'User logged out.'
        ]);
    }
}
