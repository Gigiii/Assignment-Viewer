<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cache;
use Http;
use GuzzleHttp\Client;
use Illuminate\Support\MessageBag;

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

    public function getAssignments(Request $request){
        $data = $this->checkAuthentication();
        if ($data != null && $data['role'] == "Professor") {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $data['auth_token'],
            ])->get('http://127.0.0.1:8000/api/assignment/showAssignments/' . $request->input('course_id'));
            if ($response->ok()) {
                $assignment_data = $response->json();
                    return view('professor/manage-assignments', ['auth_data' => $data, 'assignment_data' => $assignment_data, 'course_id' => $request->input('course_id'), 'course_name' => $request->course_name]);
            }else{
                return $response;
            }
        }else{
            return view('login', ['auth_data' => null]);
        }
    }

    public function viewAssignment(Request $request){
        $data = $this->checkAuthentication();
        if ($data != null && $data['role'] == "Professor") {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $data['auth_token'],
            ])->get('http://127.0.0.1:8000/api/assignment/showAssignment/' . $request->input('assignment_id'));
            if ($response->ok()) {
                $assignment_data = $response->json();
                return view('professor/view-assignment', 
                [
                    'auth_data' => $data,
                    'assignment_data' => $assignment_data, 
                    'course_name' => $request->course_name,
                    'course_id' => $request->course_id
                ]);
            }else{
                return $response;
            }
        }else{
            return view('login', ['auth_data' => null]);
        }
    }

    public function viewSubmissions(Request $request){
        $data = $this->checkAuthentication();
        if ($data != null && $data['role'] == "Professor") {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $data['auth_token'],
            ])->get('http://127.0.0.1:8000/api/submission/showSubmissions/' . $request->input('assignment_id'));
            if ($response->ok()) {
                $submissions_data = $response->json();
                return view('professor/view-submissions', 
                [
                    'auth_data' => $data,
                    'submissions_data' => $submissions_data, 
                    'student_count' => $request->student_count,
                    'submission_count' => $request->submission_count,
                    'course_name' => $request->course_name,
                    'course_id' => $request->course_id,
                    'photo_location' => $request->photo_location,
                    'assignment_name' => $request->assignment_name,
                ]);
            }else{
                return $response;
            }
        }else{
            return view('login', ['auth_data' => null]);
        }
    }
    
    public function viewSubmission(Request $request){
        $data = $this->checkAuthentication();
        if ($data != null && $data['role'] == "Professor") {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $data['auth_token'],
            ])->get('http://127.0.0.1:8000/api/submission/showSubmission/'. Cache::get('user_id') . '/' . $request->input('assignment_id'));
            if ($response->ok()) {
                $submission_data = $response->json();
                return view('professor/view-submission', 
                [
                    'auth_data' => $data,
                    'submission_data' => $submission_data, 
                    'assignment_name' => $request->assignment_name,
                    'assignment_id' => $request->assignment_id,
                    'submission_count' => $request->submission_count,
                    'student_count' => $request->student_count,
                    'photo_location' => $request->photo_location,
                    'course_name' => $request->course_name,
                    'course_id' => $request->course_id
                ]);
            }else{
                return $response;
            }
        }else{
            return view('login', ['auth_data' => null]);
        }
    }

    public function changeGrade(Request $request){
        $data = $this->checkAuthentication();
        if ($data != null && $data['role'] == 'Professor') {
            $response = Http::asForm()->withHeaders([
                'Authorization' => 'Bearer ' . $data['auth_token'],
            ])->patch('http://127.0.0.1:8000/api/submission/gradeSubmission/' . $request['submission_id'], ['grade' => $request['grade']]);
            if ($response->ok()) {
                return redirect()->route('view-submission', [
                    'assignment_id' => $request->assignment_id,
                    'assignment_name' => $request->assignment_name,
                    'student_count' => $request->student_count,
                    'submission_count' => $request->submission_count,
                    'photo_location' => $request->photo_location,
                    'course_name' => $request->course_name,
                    'course_id' => $request->course_id
                ]);
            }else{
                return $response;
            }
        }else{
            return view('login', ['auth_data' => null]);
        }
    }

    public function createAssignmentForm(Request $request){
        $data = $this->checkAuthentication();
        if ($data != null && $data['role'] == 'Professor') {
            return view('professor/create-assignment', [
                'auth_data' => $data,
                'course_name' => $request->course_name,
                'course_id' => $request->course_id 
            ]);

        }else{
            return view('login', ['auth_data' => null]);
        } 
    }

    public function createAssignment(Request $request){
        $data = $this->checkAuthentication();
        if ($data != null && $data['role'] == 'Professor') {
            
            $fileLocations = [];
            $dataArray = $request->except('photo-upload', 'attachments', 'course_name');
            $dataArray['professorId'] = $data['user_id'];
            $image = $request->file('photo-upload');
            $pictureLocation = time() . '_' . $image->getClientOriginalName();
            $picture = $image->storeAs('public/images/assignments', $pictureLocation);
            $attachments = $request->file('attachments');
            foreach ($attachments as $attachment) {
                $uniqueName = time() . '_' . $attachment->getClientOriginalName();
                $path = $attachment->storeAs('public/attachments/assignment', $uniqueName);
                array_push($fileLocations, $uniqueName);
            }
            $dataArray['fileLocations'] = $fileLocations;
            $dataArray['pictureLocation'] = $pictureLocation;
            $dataArray['status'] = 0;
            $dataArray['courseId'] = $request->course_id;
            $client = new Client(['base_uri' => 'http://127.0.0.1:8000']);

                $response =  $client->request('POST', '/api/assignment/createAssignment', [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $data['auth_token'],
                        'Accept' => 'application/json',
                    ],
                    'form_params' => $dataArray
                ]);
                $statusCode = $response->getStatusCode();
                if ($statusCode == 200){
                    return redirect()->route('manage-assignments', [
                        'course_id' => $request->course_id,
                        'course_name' => $request->course_name
                    ]);
                }else{
                    $body = $response->getBody()->getContents();
                    return ['status' => $statusCode, 'body' => $body];
                }
        }else{
            return view('login', ['auth_data' => null]);
        } 
    }


    public function editAssignmentForm(Request $request){
        $data = $this->checkAuthentication();
        if ($data != null && $data['role'] == 'Professor') {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $data['auth_token'],
            ])->get('http://127.0.0.1:8000/api/assignment/showAssignment/' . $request->input('assignment_id'));
            if ($response->ok()) {
                $assignment_data = $response->json();
                return view('professor/edit-assignment', [
                    'auth_data' => $data,
                    'assignment_data' => $assignment_data,
                    'course_name' => $request->course_name,
                    'course_id' => $request->course_id,

                ]);
            }else{
                return $response;
            }
            
        }else{
            return view('login', ['auth_data' => null]);
        } 
    }
    
    public function editAssignment(Request $request){
        $data = $this->checkAuthentication();
        if ($data != null && $data['role'] == 'Professor') {
            $fileLocations = [];
            $dataArray = $request->except('photo-upload', 'attachments', 'course_name', 'assignment_id');
            $dataArray['professorId'] = $data['user_id'];
            if ($request->hasFile('photo-upload')) {
                $image = $request->file('photo-upload');
                $pictureLocation = time() . '_' . $image->getClientOriginalName();
                $picture = $image->storeAs('public/images/assignments', $pictureLocation);
                $dataArray['pictureLocation'] = $pictureLocation;
            }
            if ($request->hasFile('attachments')) {
                $attachments = $request->file('attachments');
                foreach ($attachments as $attachment) {
                    $uniqueName = time() . '_' . $attachment->getClientOriginalName();
                    $path = $attachment->storeAs('public/attachments/assignment', $uniqueName);
                    array_push($fileLocations, $uniqueName);
                }
                $dataArray['fileLocations'] = $fileLocations;
            }
            $dataArray['status'] = 0;
            $client = new Client(['base_uri' => 'http://127.0.0.1:8000']);

                $response =  $client->request('PATCH', '/api/assignment/updateAssignment/' . $request->assignment_id, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $data['auth_token'],
                        'Accept' => 'application/json',
                    ],
                    'form_params' => $dataArray
                ]);
                $statusCode = $response->getStatusCode();
                
                if ($statusCode == 200){
                    return redirect()->route('manage-assignments', [
                        'course_id' => $request->course_id,
                        'course_name' => $request->course_name
                    ]);
                }else{
                    $body = $response->getBody()->getContents();
                    return ['status' => $statusCode, 'body' => $body];
                }
        }else{
            return view('login', ['auth_data' => null]);
        } 
    }

    public function deleteAssignmentAttachment(Request $request){
        $data = $this->checkAuthentication();
        if ($data != null && $data['role'] == 'Professor') {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $data['auth_token'],
            ])->delete('http://127.0.0.1:8000/api/assignment/deleteAttachment/' . $request->input('attachment_id'));
            if($response->ok()){
                return redirect()->route('edit-assignment-form', [
                    'course_name' => $request->course_name,
                    'course_id' => $request->course_id,
                    'assignment_id' => $request->assignment_id,
                ]);
            }else{
                return $response;
            }
        }else{
            return view('login', ['auth_data' => null]);
        } 
    }


    public function deleteAssignment(Request $request){
        $data = $this->checkAuthentication();
        if ($data != null && $data['role'] == 'Professor') {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $data['auth_token'],
            ])->delete('http://127.0.0.1:8000/api/assignment/deleteAssignment/' . $request->input('assignment_id'));
            if($response->ok()){
                return redirect()->route('manage-assignments', [
                    'course_name' => $request->course_name,
                    'course_id' => $request->course_id
                ]);
            }else{
                return $response;
            }
        }else{
            return view('login', ['auth_data' => null]);
        } 
    }
}
