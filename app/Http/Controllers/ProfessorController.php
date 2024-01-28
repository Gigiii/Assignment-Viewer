<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cache;

class ProfessorController extends Controller
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

    public function getCourses(){

    }

    public function getAssignments(){
        $data = $this->checkAuthentication();
        if ($data != null && $data['role'] == "Professor") {
            return view('professor/manage-assignments', ['auth_data' => $data]);
        }else{
            return view('login', ['auth_data' => null]);
        }
    }

    public function viewAssignment(){
        $data = $this->checkAuthentication();
        if ($data != null && $data['role'] == "Professor") {
            return view('professor/view-assignment', ['auth_data' => $data]);
        }else{
            return view('login', ['auth_data' => null]);
        }
    }

    public function viewSubmissions(){
        $data = $this->checkAuthentication();
        if ($data != null && $data['role'] == "Professor") {
            return view('professor/view-submissions', ['auth_data' => $data]);
        }else{
            return view('login', ['auth_data' => null]);
        }
    }
    
    public function viewSubmission(){
        $data = $this->checkAuthentication();
        if ($data != null && $data['role'] == "Professor") {
            return view('professor/view-submission', ['auth_data' => $data]);
        }else{
            return view('login', ['auth_data' => null]);
        }
    }

    public function changeGrade(){
        $data = $this->checkAuthentication();
        if ($data != null && $data['role'] == 'Professor') {
            // Write gradeSubmission() code here
        }else{
            return view('login', ['auth_data' => null]);
        }
    }

    public function createAssignmentForm(){
        $data = $this->checkAuthentication();
        if ($data != null && $data['role'] == 'Professor') {
            // Write createAssignment() code here
            return view('professor/create-assignment', ['auth_data' => $data]);

        }else{
            return view('login', ['auth_data' => null]);
        } 
    }

    public function createAssignment(){
        $data = $this->checkAuthentication();
        if ($data != null && $data['role'] == 'Professor') {
            // Write data insertion into API code here
            return view('professor/create-assignment', ['auth_data' => $data]);

        }else{
            return view('login', ['auth_data' => null]);
        } 
    }


    public function editAssignmentForm(){
        $data = $this->checkAuthentication();
        if ($data != null && $data['role'] == 'Professor') {
            // Write editAssignment() code here
            return view('professor/edit-assignment', ['auth_data' => $data]);

        }else{
            return view('login', ['auth_data' => null]);
        } 
    }

    public function editAssignment(){
        $data = $this->checkAuthentication();
        if ($data != null && $data['role'] == 'Professor') {
            // Write data insertion into API code here
            return view('professor/edit-assignment', ['auth_data' => $data]);

        }else{
            return view('login', ['auth_data' => null]);
        } 
    }

    public function deleteAssignment(){
        $data = $this->checkAuthentication();
        if ($data != null && $data['role'] == 'Professor') {
            // Write deleteAssignment() code here
        }else{
            return view('login', ['auth_data' => null]);
        } 
    }
}
