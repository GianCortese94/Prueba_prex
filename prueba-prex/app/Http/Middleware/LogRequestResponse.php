<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\RequestLog;
use Illuminate\Support\Facades\Auth;

class LogRequestResponse
{
    public function handle(Request $request, Closure $next)
    {
        $excludedRoutes = [
            'api/login',
        ];

        // No se guarda registros del login para no registar contraseñas ni tokens de acceso
        if (in_array($request->path(), $excludedRoutes)) {
            return $next($request);
        }

        $requestBody = $request->all();

        $response = $next($request);

        $userId = Auth::check() ? Auth::id() : null;

        $ipAddress = $request->ip();

        $responseBody = json_decode($response->getContent(), true);

        RequestLog::create([
            'user_id' => $userId,
            'service' => $request->url(),
            'request_body' => $requestBody,
            'http_status' => $response->status(),
            'response_body' => $responseBody,
            'ip_address' => $ipAddress,
        ]);

        return $response;
    }
}
