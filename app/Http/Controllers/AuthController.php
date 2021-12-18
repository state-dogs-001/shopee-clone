<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    public function register(Request $request) {
        $fields = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
        ]);

        $token = $user->createToken('myShopee')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function login(Request $request) {
        $fields = $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $fields['email'])->first();
        // Check User email and Pass is match.
        if(!$user || !Hash::check($fields['password'], $user->password)){
            // Error
            return response([
                'success' => false,
                'message' => 'Weong password or email not ready exit.'
            ]);
        }
        //Create Token
        $token = $user->createToken('myShopee')->plainTextToken;
        
        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }
    public function logout(Request $request) {
        // Reach Authentication and find tokens for delet it.
        auth()->user()->tokens()->delete();

        return response([
            'success' => true,
            'message' => 'Log out successfully.'
        ]);
    }
}
