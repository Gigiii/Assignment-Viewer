@extends('layouts.layout')

@section('content')
    @if ($auth_data != Null)
        <div class="row mb-4">
        <div class="col-md-6 col-sm-12">
            <h1>Submissions for Assignment Title</h1>
            <span>
                        Amount of Submmissions: XX/XX
            </span>
        </div>
            <form method="get" class="col-md-6 col-sm-12 d-inline-block text-end" action="{{ route('manage-assignments') }}">
            @csrf
            <input type="hidden" name="assignment_id" value="1">
            <button type="submit" class="btn btn-secondary py-2 fs-5" style="width:25%;">< Go Back</button>
            </form>
        </div>
        <div class="row py-3 justify-content-center">

            <!-- Example Submission -->
            <div class="col-md-3 d-flex flex-column my-4">
                <div class="course-img col-3 mx-auto d-flex justify-content-center">
                    <img src="{{ asset('images/course-photo.png') }}" alt="Course Image" class="img-fluid">
                </div>
                <h3 class="text-center">Student Name</h3>
                <span class="text-center fs-5 pb-2 text-success">Submitted at XX/XX/XXXX</span>
                <div class="text-center">
                    <form method="get" action="{{ route('view-submission') }}">
                        @csrf
                        <input type="hidden" name="submission_id" value="1">
                        <input type="hidden" name="assignment_id" value="1">
                        <button type="submit" class="btn btn-secondary" style="width:50%;">View Submission</button>
                    </form>
                </div>
            </div>

            <!-- Example Submission -->
            <div class="col-md-3 d-flex flex-column my-4">
                <div class="course-img col-3 mx-auto d-flex justify-content-center">
                    <img src="{{ asset('images/course-photo.png') }}" alt="Course Image" class="img-fluid">
                </div>
                <h3 class="text-center">Student Name</h3>
                <span class="text-center fs-5 pb-2 text-danger">Not Submitted</span>
            </div>

        </div>
    @else
        <script>
        window.location.href = "{{ route('login') }}";
        </script>
    @endif
@endsection