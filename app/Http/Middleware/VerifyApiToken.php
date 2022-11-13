<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use \Firebase\JWT\JWT;
use App\Models\AuthToken;
use Firebase\JWT\Key;

class VerifyApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    public function handle(Request $request, Closure $next)
    {
        if (!$request->header('x-auth-token')) {
            return response()->json([
                'status' => 'error',
                'messages' => 'Invalid request.'
            ]);
        } else {
            try {
                $token = $request->header('x-auth-token');

                $decode = JWT::decode($token, new Key(env('JWT_KEY'), env('JWT_ALGO')));
                if (time() > $decode->expire_time) {

                    //delete expired token
                    Authtoken::where('token', $token)->delete();

                    return response()->json([
                        'status' => 'error',
                        'messages' => 'Token expired'
                    ]);
                } else {
                    $findToken = Authtoken::where('token', $token);
                    if ($findToken->exists()) {
                        return $next($request);
                    } else {
                        return response()->json([
                            'status' => 'error',
                            'messages' => 'Token not found'
                        ]);
                    }
                }
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'messages' => $e->getMessage()
                ]);
            }
        }
        return $next($request);
    }
}
