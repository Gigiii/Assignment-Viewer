@extends('layouts.layout')

@section('content')
    @if ($auth_data != Null)
        <div class="row mb-4">
            <div class="col-md-6 col-sm-12">
                <h1>Assignments for Course Name</h1>
            </div>
            <div class="col-md-6 col-sm-12 text-end">

                <form method="get" action="{{ route('create-assignment') }}">
                    @csrf
                    <input type="hidden" name="assignment_id" value="1">
                    <button type="submit" class="btn btn-secondary py-3 fs-5" style="width:50%;">Create New Assignment</button>
                </form>
                
            </div>
        </div>
        <div class="row py-3 justify-content-evenly">

            <!-- Example Assignment -->
            <div class="col-md-5 d-flex flex-row my-4 assignment-background p-3">
                <div class="col-6 align-self-center">
                    <div class="course-img col-3 mx-auto d-flex justify-content-center">
                        <img src="{{ asset('images/course-photo.png') }}" alt="Course Image" class="img-fluid">
                    </div>
                    <h2 class="text-center">Assignment Name</h2>
                    <div class="text-center">
                        <p>Deadline: YYYY-MM-DD</p>
                    </div>
                </div>
                <div class="col-6 d-flex flex-column justify-content-evenly text-center">
                    <form method="get" action="{{ route('view-assignment') }}">
                            @csrf
                            <input type="hidden" name="assignment_id" value="1">
                            <button type="submit" class="btn btn-secondary" style="width:50%;">View Assignment</button>
                        </form>
                    <form method="get" action="{{ route('edit-assignment') }}">
                        @csrf
                        <input type="hidden" name="assignment_id" value="1">
                        <button type="submit" class="btn btn-secondary" style="width:50%;">Edit Assignment</button>
                    </form>
                    <form method="get" action="{{ route('delete-assignment') }}">
                        @csrf
                        <input type="hidden" name="assignment_id" value="1">
                        <button type="submit" class="btn btn-secondary" style="width:50%;">Delete Assignment</button>
                    </form>
                </div>
            </div>


        </div>
        <!-- <p>API Key = {{ $auth_data['auth_token'] }}</p>
        <p>Role = {{ $auth_data['role'] }}</p>
        <p>Id = {{ $auth_data['user_id'] }}</p> -->
    @else
        <script>
        window.location.href = "{{ route('login') }}";
        </script>
    @endif
@endsection