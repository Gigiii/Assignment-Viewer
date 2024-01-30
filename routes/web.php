<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ViewController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ProfessorController;

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

Route::get('/', [AuthenticationController::class, 'verifyAuthenticationHome'])
->name("home");

Route::post('/login', [AuthenticationController::class, 'login'])
->name("login");

Route::get('/logout', [AuthenticationController::class, 'logout'])
->name("logout");

Route::get('manage-assignments', [ProfessorController::class, 'getAssignments'])
->name("manage-assignments");

Route::get('edit-assignment', [ProfessorController::class, 'editAssignment'])
->name("edit-assignment");

Route::get('create-assignment-form', [ProfessorController::class, 'createAssignmentForm'])
->name("create-assignment-form");

Route::post('create-assignment', [ProfessorController::class, 'createAssignment'])
->name("create-assignment");

Route::get('create-submission-form', [StudentController::class, 'createSubmissionForm'])
->name("create-submission-form");

Route::post('create-submission', [StudentController::class, 'createSubmission'])
->name("create-submission");

Route::patch('grade-submission', [ProfessorController::class, 'changeGrade'])
->name("grade-submission");

Route::get('edit-assignment-form', [ProfessorController::class, 'editAssignmentForm'])
->name("edit-assignment-form");

Route::patch('edit-assignment', [ProfessorController::class, 'editAssignment'])
->name("edit-assignment");

Route::delete('delete-assignment', [ProfessorController::class, 'deleteAssignment'])
->name("delete-assignment");

Route::delete('delete-attachment', [ProfessorController::class, 'deleteAssignmentAttachment'])
->name("delete-attachment");

Route::get('view-assignment', [ProfessorController::class, 'viewAssignment'])
->name("view-assignment");

Route::get('view-assignment-student', [StudentController::class, 'viewAssignmentStudent'])
->name("view-assignment-student");

Route::get('view-assignments', [StudentController::class, 'viewAssignments'])
->name("view-assignments");

Route::get('view-submissions', [ProfessorController::class, 'viewsubmissions'])
->name("view-submissions");

Route::get('view-submission', [ProfessorController::class, 'viewsubmission'])
->name("view-submission");

