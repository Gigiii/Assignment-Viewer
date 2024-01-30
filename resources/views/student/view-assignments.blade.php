@extends('layouts.layout')

@section('content')
    @if ($auth_data != Null)
        <div class="row mb-4 justify-content-between">
            <div class="col-md-5">
                <h1 class="d-inline-block">Assignments for {{ $course_name }}</h1>
            </div>
            <form method="get" class="col-md-3 d-inline-block text-end" action="{{ route('home') }}">
                @csrf
                <input type="hidden" name="course_id" value="{{ $course_id }}">
                <input type="hidden" name="course_name" value="{{ $course_name }}">
                <button type="submit" class="btn btn-secondary py-2 fs-5 responsive-btn" style="width:50%;">< Go Back</button>
            </form>
        </div>
        <div class="row py-3 justify-content-center align-items-end">
            @foreach ($assignment_data as $assignment)
            <div class="col-md-3 d-flex flex-column my-4">
                <div class="course-img col-3 mx-auto d-flex justify-content-center">
                    <img src="{{ asset('storage/images/assignments/' . $assignment['original']['assignment']['pictureLocation']) }}" alt="Course Image" class="img-fluid">
                </div>
                <h3 class="text-center">{{ $assignment['original']['assignment']['title'] }}</h3>
                <span class="text-center pb-3">Due: {{ $assignment['original']['assignment']['deadline'] }}</span>
                <div class="text-center">
                    <form method="get" action="{{ route('view-assignment-student') }}">
                        @csrf
                        <input type="hidden" name="course_name" value="{{ $course_name }}">
                        <input type="hidden" name="course_id" value="{{ $course_id }}">
                        <input type="hidden" name="assignment_id" value="{{ $assignment['original']['assignment']['id'] }}">
                        <button type="submit" class="btn btn-secondary" style="width:50%;">View Assignment</button>
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