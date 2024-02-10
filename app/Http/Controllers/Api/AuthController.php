<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                response()->json(['status' => 'Unauthorised'], 401);
            }

            $token = $user->createToken(Hash::make($request->password.$request->email))->plainTextToken;
            return response()->json(['token' => $token, 'user_id' => $user->id], 200);
        }

        return response()->json(['error' => 'Invalid Crendentials'], 401);
    }
}
