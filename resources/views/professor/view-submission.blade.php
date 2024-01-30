@extends('layouts.layout')

@section('content')
    @if ($auth_data != Null)

        <div class="row mb-2">
            <div class="col-md-4">
                <div class="course-img col-4 mx-auto d-flex justify-content-center">
                    <img src="{{ asset('storage/images/assignments/'. $photo_location) }}" alt="Course Image" class="img-fluid">
                </div>
                <div class="col-12 py-2">
                    <form method="POST" class="col-md-8" action="{{ route('grade-submission') }}?_method=PATCH">
                        @csrf
                        <input type="hidden" name="course_id" value="{{ $course_id }}">
                        <input type="hidden" name="course_name" value="{{ $course_name }}">        
                        <input type="hidden" name="assignment_id" value="{{ $submission_data["assignmentId"] }}">
                        <input type="hidden" name="assignment_name" value="{{ $assignment_name }}">    
                        <input type="hidden" name="submission_id" value="{{ $submission_data["id"] }}">
                        <input type="hidden" name="submission_count" value="{{ $submission_count }}">
                        <input type="hidden" name="student_count" value="{{ $student_count }}">    
                        <input type="hidden" name="photo_location" value="{{ $photo_location }}">
                        <input type="hidden" name="max_grade" value="{{ $max_grade }}">
                        <label for="grade">Grade Amount:</label>
                        <input type="number" name="grade" id="grade" placeholder="{{ $submission_data["grade"] . '/' . $max_grade }}" max="{{ $max_grade }}" min="0" class="d-inline-block" style="width:20%;">
                        <button type="submit" class="btn btn-dark" style="width:20%;">Edit</button>
                    </form>
                </div>
                <div class="col-12 py-2">
                    <span>
                        Deadline: {{ $submission_data["submissionDate"]}}
                    </span>
                </div>
                <div class="col-12 py-2">
                <span>
                    Attachments:
                </span>
                </div>
                @foreach ($submission_data["attachment"] as $attachment)
                <div class="col-12 py-2">
                    
                    <a href="{{ asset('storage/attachments/submission/' . $attachment["fileLocation"]) }}">
                        @php
                            $parts = explode("_", $attachment["fileLocation"]);
                            $exceptFirst = array_slice($parts, 1);
                            foreach($exceptFirst as $element){
                                echo $element;
                            }
                        @endphp
                    </a>
                </div>
                @endforeach

            </div>
            <div class="col-md-8">
                <div class="row flex-row justify-content-between mb-3">
                    <div class="col-md-6">
                        <span class="fs-2">{{$submission_data["student"]["firstName"] . ' ' . $submission_data["student"]["lastName"] . ' - ' . $submission_data["title"]}}</span>
                    </div>
                    <form method="get" class="col-md-4 d-inline-block text-end" action="{{ route('view-submissions') }}">
                    @csrf
                    <input type="hidden" name="course_id" value="{{ $course_id }}">
                    <input type="hidden" name="course_name" value="{{ $course_name }}">        
                    <input type="hidden" name="submission_count" value="{{ $submission_count }}">
                    <input type="hidden" name="student_count" value="{{ $student_count }}">
                    <input type="hidden" name="assignment_id" value="{{ $submission_data["assignmentId"] }}">
                    <input type="hidden" name="assignment_name" value="{{ $assignment_name }}">    
                    <input type="hidden" name="photo_location" value="{{ $photo_location }}">
                    <input type="hidden" name="max_grade" value="{{ $max_grade }}">
                    <button type="submit" class="btn btn-secondary py-2 fs-5" style="width:50%;">< Go Back</button>
                    </form>
                </div>
                <div class="col-md-10">
                    <p>{{ $submission_data["description"] }}</p>
                </div>
            </div>
        </div>
    @else
        <script>
        window.location.href = "{{ route('login') }}";
        </script>
    @endif
@endsection