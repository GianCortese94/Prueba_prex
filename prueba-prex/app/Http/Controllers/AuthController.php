<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Configuración de expiración del token (se toma de config/passport.php)
            $expiration = Carbon::now()->addMinutes(config('passport.token_expiration'));

            // Crear el token con la expiración personalizada
            $token = $user->createToken('PruebaPrex')->accessToken;

            return response()->json([
                'message' => 'Login successful',
                'access_token' => $token,
                'token_type' => 'Bearer',
                'expires_at' => $expiration->toDateTimeString(),
            ]);
        }

        return response()->json(['error' => 'Invalid credentials'], 401);
    }
}
