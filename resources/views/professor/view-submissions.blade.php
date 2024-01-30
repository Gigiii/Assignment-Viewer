@extends('layouts.layout')

@section('content')
    @if ($auth_data != Null)
        <div class="row mb-4">
        <div class="col-md-6 col-sm-12">
            <h1>Submissions for {{ $assignment_name }}</h1>
            <span>
                        Amount of Submmissions: {{ $submission_count }} / {{ $student_count }}
            </span>
        </div>
            <form method="get" class="col-md-6 col-sm-12 d-inline-block text-end" action="{{ route('view-assignment') }}">
            @csrf
            <input type="hidden" name="course_id" value="{{ $course_id }}">
            <input type="hidden" name="course_name" value="{{ $course_name }}">
            <input type="hidden" name="assignment_name" value="{{ $assignment_name }}">
            <input type="hidden" name="assignment_id" value="{{ $submissions_data[0]['assignmentId'] }}">
            <button type="submit" class="btn btn-secondary py-2 fs-5" style="width:25%;">< Go Back</button>
            </form>
        </div>
        <div class="row py-3 justify-content-center">
            @foreach ($submissions_data as $submission)
                <div class="col-md-3 d-flex flex-column my-4">
                    <div class="course-img col-3 mx-auto d-flex justify-content-center">
                        <img src="{{ asset('storage/images/assignments/'. $photo_location) }}" alt="Course Image" class="img-fluid">
                    </div>
                    <h3 class="text-center">{{ $submission['student']['firstName'] . ' ' . $submission['student']['lastName'] }}</h3>
                    <span class="text-center fs-5 pb-2 text-success">Submitted at {{ $submission['submissionDate'] }}</span>
                    <div class="text-center">
                        <form method="get" action="{{ route('view-submission') }}">
                            @csrf
                            <input type="hidden" name="course_id" value="{{ $course_id }}">
                            <input type="hidden" name="course_name" value="{{ $course_name }}">        
                            <input type="hidden" name="submission_count" value="{{ $submission_count }}">
                            <input type="hidden" name="student_count" value="{{ $student_count }}">
                            <input type="hidden" name="assignment_name" value="{{ $assignment_name }}">
                            <input type="hidden" name="assignment_id" value="{{ $submission['assignmentId'] }}">
                            <input type="hidden" name="submission_id" value=" {{ $submission['id'] }}">
                            <input type="hidden" name="photo_location" value="{{ $photo_location }}">
                            <button type="submit" class="btn btn-secondary" style="width:50%;">View Submission</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <script>
        window.location.href = "{{ route('login') }}";
        </script>
    @endif
@endsection