<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TokenController;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/verify-token', [TokenController::class, 'verifyToken']);

// routes/web.php
Route::middleware(['jwtAuth'])->group(function () {
    Route::get('/home', function (Request $request) {
        $token = $request->cookie('access-token');
            $payload = JWTAuth::setToken($token)->getPayload();
        $payload = $payload->toArray();

        // $data = $authService->getData('institusi_id');
        // $data = $authService->getData('user_id');

        return view('home', [
            'payload' => $payload
        ]); 
    })->name('home'); 

    Route::get('/', function () {
        return view('welcome');
    });
});

Route::get('/callback/{token}', function ($token) {
    // cookie('access-token', $request->token);
    return redirect(route('home'))->withCookie('access-token',$token);
});


Route::get('/logout', function () {
    // cookie('access-token', $request->token);
    return redirect(route('home'))->withoutCookie('access-token');
});


