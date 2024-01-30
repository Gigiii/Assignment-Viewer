@extends('layouts.layout')

@section('content')
    @if ($auth_data != Null)
        <div class="row mb-4">
            <h1>Homepage</h1>

        </div>
        <div class="row py-3 justify-content-center">
            @foreach ($course_data as $course)
                <div class="col-md-3 d-flex flex-column my-4 justify-content-end">
                    <div class="course-img col-3 mb-2 mx-auto d-flex justify-content-center">
                        <img src="{{ asset('storage/images/courses/' . $course['pictureLocation']) }}" alt="Course Image" class="img-fluid">
                    </div>
                    <h3 class="text-center">{{ $course['name'] }}</h3>
                    <div class="text-center">
                        <form method="get" action="{{ route('manage-assignments') }}">
                            @csrf
                            <input type="hidden" name="course_id" value="{{ $course['id'] }}">                            <input type="hidden" name="course_name" value="{{ $course['name'] }}">
                            <input type="hidden" name="course_name" value="{{ $course['name'] }}">
                            <button type="submit" class="btn btn-secondary" style="width:50%;">Select</button>
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