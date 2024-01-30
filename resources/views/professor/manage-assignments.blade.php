@extends('layouts.layout')

@section('content')
    @if ($auth_data != Null)
        <div class="row mb-4">
            <div class="col-md-6 col-sm-12">
                <h1>Assignments for {{ $course_name }}</h1>
            </div>
            <div class="col-md-6 col-12 text-end">
                <form method="get" class="col-md-4 col-12 mb-2 d-inline-block text-end" action="{{ route('home') }}">
                    @csrf
                    <input type="hidden" name="course_id" value="1">
                    <button type="submit" class="btn btn-secondary py-2 fs-5 responsive-btn" style="width:50%;">< Go Back</button>
                </form>
                <form method="get" action="{{ route('create-assignment-form') }}">
                    @csrf
                    <input type="hidden" name="course_id" value="{{ $course_id }}">
                    <input type="hidden" name="course_name" value="{{ $course_name }}">
                    <button type="submit" class="btn btn-secondary py-3 fs-5 responsive-btn" style="width:50%;">Create New Assignment</button>
                </form>
            
            </div>
        </div>
        <div class="row py-3 justify-content-evenly">
            @foreach ($assignment_data as $assignment)
                
                <div class="col-md-5 d-flex flex-row my-4 assignment-background p-3">
                    <div class="col-6 align-self-center">
                        <div class="course-img col-3 mx-auto d-flex justify-content-center">
                            <img src="{{ asset('storage/images/assignments/' . $assignment['original']['assignment']['pictureLocation']) }}" alt="Course Image" class="img-fluid">
                        </div>
                        <h2 class="text-center">{{ $assignment['original']['assignment']['title'] }}</h2>
                        <div class="text-center">
                            <p>Deadline: {{ $assignment['original']['assignment']['deadline'] }}</p>
                        </div>
                    </div>
                    <div class="col-6 d-flex flex-column justify-content-evenly text-center">
                        <form method="get" action="{{ route('view-assignment') }}">
                                @csrf
                                <input type="hidden" name="assignment_id" value="{{ $assignment['original']['assignment']['id'] }}">
                                <input type="hidden" name="course_id" value="{{ $course_id }}">
                                <input type="hidden" name="course_name" value="{{ $course_name }}">
                                <button type="submit" class="btn btn-secondary responsive-btn" style="width:50%;">View Assignment</button>
                            </form>
                        <form method="get" action="{{ route('edit-assignment-form') }}">
                            @csrf
                            <input type="hidden" name="assignment_id" value="{{ $assignment['original']['assignment']['id'] }}">
                            <input type="hidden" name="course_id" value="{{ $course_id }}">
                            <input type="hidden" name="course_name" value="{{ $course_name }}">
                            <button type="submit" class="btn btn-secondary responsive-btn" style="width:50%;">Edit Assignment</button>
                        </form>
                        <form action="">
                            <button type="button" class="btn btn-secondary responsive-btn" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $assignment['original']['assignment']['id'] }}" style="width:50%;">
                                Delete Assignment
                            </button>
                        </form>

                        <!-- Modal -->
                        <div class="modal fade" id="deleteModal{{ $assignment['original']['assignment']['id'] }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                Are you sure you want to delete this assignment?
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <form method="post" action="{{ route('delete-assignment') }}?_method=DELETE">
                                    @csrf
                                    <input type="hidden" name="assignment_id" value="{{ $assignment['original']['assignment']['id'] }}">
                                    <input type="hidden" name="course_id" value="{{ $course_id }}">
                                    <input type="hidden" name="course_name" value="{{ $course_name }}">
                                    <button type="submit" class="btn btn-secondary">Delete Assignment</button>
                                </form>
                                </div>
                            </div>
                            </div>
                        </div>
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