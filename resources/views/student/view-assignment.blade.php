@extends('layouts.layout')

@section('content')
    @if ($auth_data != Null)

        <div class="row mb-2">
            <div class="col-md-4">
                <div class="course-img col-4 mx-auto d-flex justify-content-center">
                    <img src="{{ asset('images/course-photo.png') }}" alt="Course Image" class="img-fluid">
                </div>
                <div class="col-12 py-2">
                    <span>
                        Grade Amount: X
                    </span>
                </div>
                <div class="col-12 py-2">
                    <span>
                        Deadline: XX/XX/XXXX XX:XX
                    </span>
                </div>
                <div class="col-12 py-2">
                <span>
                    Attachments:
                </span>
                </div>
                <div class="col-12 py-2">

                    <a href="#">
                        Attachment 1
                    </a>
                </div>
                <div class="col-12 py-2">
                    <a href="#">
                        Attachment 2
                    </a>
                </div>


            </div>
            <div class="col-md-8 d-flex flex-column">
                    <div class="d-flex flex-column" style="height: 100%;">

                <div class="row flex-row justify-content-between mb-3">
                    <div class="col-md-4">
                        <span class="fs-2">Assignment Name</span>
                    </div>
                    <form method="get" class="col-md-4 d-inline-block text-end" action="{{ route('view-assignments') }}">
                    @csrf
                    <input type="hidden" name="course_id" value="1">
                    <button type="submit" class="btn btn-secondary py-2 fs-5" style="width:50%;">< Go Back</button>
                    </form>
                </div>
                <div class="col-md-10">
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Amet quibusdam earum, quae velit eum doloribus accusamus qui quos sapiente vel?</p>
                </div>
                <div class="col-12 py-3 text-end mt-auto">
                <!-- make sure he hasn't submitted already -->
                <form method="get" class="col-md-6 d-inline-block text-end" action=" {{ route('create-submission-form') }} ">
                    @csrf
                    <input type="hidden" name="assignment_id" value="1">
                    <button type="submit" class="btn btn-dark py-2 fs-5" style="width:50%;">Upload Work</button>
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