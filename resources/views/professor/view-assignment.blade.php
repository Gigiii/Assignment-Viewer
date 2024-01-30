@extends('layouts.layout')

@section('content')
    @if ($auth_data != Null)
        <div class="row mb-2">
            <div class="col-md-4">
                <div class="course-img col-4 mx-auto d-flex justify-content-center">
                    <img src="{{ asset('storage/images/assignments/'. $assignment_data["assignment"]["pictureLocation"]) }}" alt="Course Image" class="img-fluid">
                </div>
                <div class="col-12 py-2">
                    <span>
                        Grade Amount: {{ $assignment_data["assignment"]["maxGrade"] }}
                    </span>
                </div>
                <div class="col-12 py-2">
                    <span>
                        Deadline: {{ $assignment_data["assignment"]["deadline"] }}
                    </span>
                </div>
                <div class="col-12 py-2">
                <span>
                    Attachments:
                </span>
                </div>
                @foreach ($assignment_data["attachments"]["original"] as $attachment)
                    <div class="col-12 py-2">
                        <a href="{{ asset('storage/attachments/assignment/' . $attachment["fileLocation"]) }}">
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
                    <div class="col-md-4">
                        <span class="fs-2">{{ $assignment_data["assignment"]["title"] }}</span>
                    </div>
                    <form method="get" class="col-md-4 d-inline-block text-end" action="{{ route('manage-assignments') }}">
                    @csrf
                    <input type="hidden" name="course_id" value="{{ $course_id }}">
                    <input type="hidden" name="course_name" value="{{ $course_name }}">
                    <button type="submit" class="btn btn-secondary responsive-btn py-2 fs-5" style="width:50%;">< Go Back</button>
                    </form>
                </div>
                <div class="col-md-10">
                    <p>{{ $assignment_data["assignment"]["description"] }}</p>
                </div>
                <div class="col-12 pt-5 text-end">
                    <span>
                        Amount of Submissions: {{ $assignment_data['submission_count']}} / {{ $assignment_data['student_count'] }}
                    </span>
                </div>
                <div class="col-12 py-3 text-end">
                @if ( $assignment_data['submission_count'] > 0)
                <form method="get" class="col-md-6 d-inline-block text-end" action="{{ route('view-submissions') }}">
                    @csrf
                    <input type="hidden" name="course_id" value="{{ $course_id }}">
                    <input type="hidden" name="course_name" value="{{ $course_name }}">
                    <input type="hidden" name="submission_count" value="{{ $assignment_data['submission_count']}}">
                    <input type="hidden" name="student_count" value="{{ $assignment_data['student_count']}}">
                    <input type="hidden" name="assignment_name" value="{{ $assignment_data['assignment']['title'] }}">
                    <input type="hidden" name="assignment_id" value="{{ $assignment_data["assignment"]["id"] }}">
                    <input type="hidden" name="photo_location" value="{{ $assignment_data["assignment"]["pictureLocation"] }}">
                    <button type="submit" class="btn btn-dark py-2 fs-5 responsive-btn" style="width:50%;">View Submissions</button>
                </form>
                @else
                    <h3>No Submissions to view</h3>                
                @endif
            </div>
            </div>
        </div>
    @else
        <script>
        window.location.href = "{{ route('login') }}";
        </script>
    @endif
@endsection