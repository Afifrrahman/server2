<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class TokenController extends Controller
{
    public function verifyToken(Request $request)
    {
        $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYXBpL2F1dGgvbG9naW4iLCJpYXQiOjE3Mjc0MDU4ODUsImV4cCI6MTcyNzQwOTQ4NSwibmJmIjoxNzI3NDA1ODg1LCJqdGkiOiIyUFo3cE54dU5aZ3Zhd1ZuIiwic3ViIjoiMjEiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.Fs_6V4r-nE5RvALcilA2dupdXR2TcHEBWNGvOeOshVk"; // ini untuk mengambil token dari header

        // return $token;

        // $token = $request->bearerToken();
        if (!$token) {
            return response()->json(['error' => 'Token not provided'], 401);
        }

        try {
            // ini untuk verifikasi token
            $checkToken = JWTAuth::setToken($token)->check();
            // $payload = JWTAuth::setToken($token)->getPayload();
            return $checkToken;
        } catch (TokenInvalidException $e) {
            return response()->json(['error' => 'Token is invalid'], 401);
        } catch (TokenExpiredException $e) {
            return response()->json(['error' => 'Token has expired'], 401);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not parse token'], 401);
        }

        return redirect()->route('home'); 
    }
}
