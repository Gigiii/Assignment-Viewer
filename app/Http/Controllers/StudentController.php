<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cache;

class StudentController extends Controller
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
    
    public function viewAssignmentStudent(){
        $data = $this->checkAuthentication();
        if ($data != null && $data["role"] == "Student") {
            return view('student/view-assignment', ['auth_data' => $data]);
        }else{
            return view('login', ['auth_data' => null]);
        }
    }

    public function viewAssignments(){
        $data = $this->checkAuthentication();
        if ($data != null && $data["role"] == "Student") {
            return view('student/view-assignments', ['auth_data' => $data]);
        }else{
            return view('login', ['auth_data' => null]);
        }
    }


    public function createSubmission(){
        $data = $this->checkAuthentication();
        if ($data != null && $data["role"] == "Student") {
            // Write createSubmission() code here
        }else{
            return view('login', ['auth_data' => null]);
        }
    }

}
