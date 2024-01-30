<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cache;
use Http;
use GuzzleHttp\Client;

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
    
    public function viewAssignmentStudent(Request $request){
        $data = $this->checkAuthentication();
        if ($data != null && $data["role"] == "Student") {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $data['auth_token'],
            ])->get('http://127.0.0.1:8000/api/assignment/showAssignment/' . $request->input('assignment_id'));
            if($response->ok()){
                $assignment_data = $response->json();
                $submissionResponse = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $data['auth_token'],
                ])->get('http://127.0.0.1:8000/api/submission/checkSubmission/'. Cache::get("user_id") . '/' . $request->input('assignment_id'));
                if($submissionResponse->ok()){
                    return view('student/view-assignment', ['auth_data' => $data,  'assignment_data' => $assignment_data, 'submission' => $submissionResponse->json(), 'course_id' => $request->course_id, 'course_name' => $request->course_name]);
                }else{
                    return $submissionResponse;
                }
            }
        }else{
            return view('login', ['auth_data' => null]);
        }
    }

    public function viewAssignments(Request $request){
        $data = $this->checkAuthentication();
        if ($data != null && $data['role'] == "Student") {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $data['auth_token'],
            ])->get('http://127.0.0.1:8000/api/assignment/showAssignments/' . $request->input('course_id'));
            if ($response->ok()) {
                $assignment_data = $response->json();
                    return view('student/view-assignments', ['auth_data' => $data, 'assignment_data' => $assignment_data, 'course_id' => $request->input('course_id'), 'course_name' => $request->input('course_name')]);
            }else{
                return $response;
            }
        }else{
            return view('login', ['auth_data' => null]);
        }
    }


    public function createSubmissionForm(Request $request){
        $data = $this->checkAuthentication();
        if ($data != null && $data['role'] == 'Student') {
            return view('student/create-submission', [
                'auth_data' => $data,
                'course_name' => $request->course_name,
                'course_id' => $request->course_id,
                'assignment_id' => $request->assignment_id
            ]);

        }else{
            return view('login', ['auth_data' => null]);
        } 
    }

    public function createSubmission(Request $request){
        $data = $this->checkAuthentication();
        if ($data != null && $data['role'] == 'Student') {
            $fileLocations = [];
            $dataArray = $request->except('attachments', 'course_name', 'course_id');
            $attachments = $request->file('attachments');
            foreach ($attachments as $attachment) {
                $uniqueName = time() . '_' . $attachment->getClientOriginalName();
                $path = $attachment->storeAs('public/attachments/submission', $uniqueName);
                array_push($fileLocations, $uniqueName);
            }
            $dataArray['fileLocations'] = $fileLocations;
            $dataArray['status'] = 0;
            $client = new Client(['base_uri' => 'http://127.0.0.1:8000']);

                $response =  $client->request('POST', '/api/submission/createSubmission/' . $request->assignment_id, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $data['auth_token'],
                        'Accept' => 'application/json',
                    ],
                    'form_params' => $dataArray
                ]);
                $statusCode = $response->getStatusCode();
                if ($statusCode == 200){
                    return redirect()->route('view-assignment-student', [
                        'course_id' => $request->course_id,
                        'assignment_id' => $request->assignment_id,
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

}
