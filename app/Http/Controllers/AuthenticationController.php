<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\MessageBag;
use Cache;

class AuthenticationController extends Controller
{
    public function checkAuthentication(){
        if (Cache::has('auth_token')) {
            $data = [
            'auth_token' => Cache::get('auth_token'),
            'role' => Cache::get('role'),
            'user_id' => Cache::get('user_id'),
            'name' => Cache::get('name'),
            ];
            return $data;
        }else{
            return null;
        }
    }

    public function verifyAuthenticationHome(){
        $data = $this->checkAuthentication();
        if ($data != null) {
            if ($data['role'] == 'Professor'){
                return view('professor/home', ['auth_data' => $data]);
            }else{
                return view('student/home', ['auth_data' => $data]);
            }
        }else{
            return view('login', ['auth_data' => null]);
        }
    }

    public function login(Request $request){
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
            Cache::forever('name', $data['name']);
            return redirect()->route("home");
        } else {
            $errors = new MessageBag(['password' => ['Incorrect Credentials, Please Try again']]);
            return redirect()->back()->withErrors($errors)->withInput($request->except('password'));

        }
    }

    public function logout(){
        Cache::flush();
        return view('login', ['auth_data' => null]);
    }
}
