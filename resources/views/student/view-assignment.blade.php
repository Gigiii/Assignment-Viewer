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
                        Grade Amount: {{ $assignment_data['assignment']['maxGrade'] }}
                    </span>
                </div>
                <div class="col-12 py-2">
                    <span>
                        Deadline: {{ $assignment_data['assignment']['deadline'] }}
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
            <div class="col-md-8 d-flex flex-column">
                    <div class="d-flex flex-column" style="height: 100%;">

                <div class="row flex-row justify-content-between mb-3">
                    <div class="col-md-4">
                        <span class="fs-2">{{ $assignment_data['assignment']['title'] }}</span>
                    </div>
                    <form method="get" class="col-md-4 d-inline-block text-end" action="{{ route('view-assignments') }}">
                    @csrf
                    <input type="hidden" name="course_id" value="{{ $course_id }}">
                    <input type="hidden" name="course_name" value="{{ $course_name }}">
                    <button type="submit" class="btn btn-secondary py-2 fs-5 responsive-btn" style="width:50%;">< Go Back</button>
                    </form>
                </div>
                <div class="col-md-10">
                    <p>{{ $assignment_data['assignment']['description'] }}</p>
                </div>
                <div class="col-12 py-3 text-end mt-auto responsive-center-text">
                @if( $submission == 0 )
                    <form method="get" class="col-md-6 d-inline-block text-end" action=" {{ route('create-submission-form') }} ">
                        @csrf
                        <input type="hidden" name="course_name" value="{{ $course_name }}">
                        <input type="hidden" name="course_id" value="{{ $course_id }}">    
                        <input type="hidden" name="assignment_id" value="{{ $assignment_data['assignment']['id'] }}">
                        <button type="submit" class="btn btn-dark py-2 fs-5 responsive-btn" style="width:50%;">Upload Work</button>
                    </form>
                @else
                    <h2 class="text-success">You have submitted this assignment</h2>
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