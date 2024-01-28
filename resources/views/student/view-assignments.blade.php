@extends('layouts.layout')

@section('content')
    @if ($auth_data != Null)
        <div class="row mb-4">
            <h1>Homepage</h1>
        </div>
        <div class="row py-3 justify-content-center">

            <!-- Example Assignment -->
            <div class="col-md-3 d-flex flex-column my-4">
                <div class="course-img col-3 mx-auto d-flex justify-content-center">
                    <img src="{{ asset('images/course-photo.png') }}" alt="Course Image" class="img-fluid">
                </div>
                <h3 class="text-center">Assignment Name</h3>
                <span class="text-center pb-3">Due: XX/XX/XXXX XX:XX</span>
                <div class="text-center">
                    <form method="get" action="{{ route('view-assignment-student') }}">
                        @csrf
                        <input type="hidden" name="assignment_id" value="1">
                        <button type="submit" class="btn btn-secondary" style="width:50%;">View Assignment</button>
                    </form>
                </div>
            </div>
        </div>
    @else
        <script>
        window.location.href = "{{ route('login') }}";
        </script>
    @endif
@endsection