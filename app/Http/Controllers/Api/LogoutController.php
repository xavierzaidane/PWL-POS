<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class LogoutController extends Controller
{
    public function __invoke(Request $request)
{
    try {
        $token = JWTAuth::getToken();
        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Token is required',
            ], 400);
        }

        JWTAuth::invalidate($token);

        return response()->json([
            'success' => true,
            'message' => 'Logout Berhasil!',
        ]);
        
    } catch (JWTException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to logout, please try again.',
        ], 500);
    }
}
}
