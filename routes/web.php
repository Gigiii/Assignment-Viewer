<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;


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

Route::get('/', function () {
    Cache::flush();
    if (Cache::has('auth_token')) {
        $data = [
        'auth_token' => Cache::get('auth_token'),
        'role' => Cache::get('role'),
        'user_id' => Cache::get('user_id'),
        ];
        return view('home', ['auth_data' => $data]);
    }else{
        return view('login', ['auth_data' => null]);
    }
});

Route::post('/login', function (Request $request) {

    $validatedData = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $response = Http::post('http://127.0.0.1:8000/api/login', [
        'email' => $validatedData['email'],
        'password' => $validatedData['password'],
    ]);

    if ($response->ok()) {
        $data = $response->json();
        Cache::forever('auth_token', $data['auth_token']);
        Cache::forever('role', $data['role']);
        Cache::forever('user_id', $data['user_id']);
        return view('home', ['auth_data' => $data]);
    } else {
        dd('Login failed, please try again');
    }
})->name('login');

Route::get('manage-assignments', function() {

});

Route::get('edit-assignment', function() {

});

Route::get('create-assignment', function() {

});

Route::get('delete-assignment', function() {

});

Route::get('view-assignment', function() {

});

Route::get('submit-assignment', function() {

});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
