<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class CheckJwtToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->cookie('access-token');

        if (!$token) {
            // return response()->json(['error' => 'Token not provided'], 401);
            return redirect(env('AUTH_LOGIN_DOMAIN').'?redirect='.env('APP_URL'));
        }

        try {
            // ini untuk verifikasi token
            $checkToken = JWTAuth::setToken($token)->check();
            // $payload = JWTAuth::setToken($token)->getPayload();
            // return $checkToken;
            if((bool)$checkToken){
                return $next($request);
            }else{
            return redirect(env('AUTH_LOGIN_DOMAIN').'?redirect='.$request->url());
            }
        } catch (TokenInvalidException $e) {
            return redirect(env('AUTH_LOGIN_DOMAIN').'?redirect='.$request->url());
            // return response()->json(['error' => 'Token is invalid'], 401);
        } catch (TokenExpiredException $e) {
            return redirect(env('AUTH_LOGIN_DOMAIN').'?redirect='.$request->url());
            // return response()->json(['error' => 'Token has expired'], 401);
        } catch (JWTException $e) {
            return redirect(env('AUTH_LOGIN_DOMAIN').'?redirect='.$request->url());
            // return response()->json(['error' => 'Could not parse token'], 401);
        } 
    }
}
