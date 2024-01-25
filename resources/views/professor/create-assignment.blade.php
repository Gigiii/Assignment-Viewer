@extends('layouts.layout')

@section('content')
    @if ($auth_data != Null)
    <div class="row flex-row justify-content-between mb-3">
                    <div class="col-md-4">
                        <span class="fs-2">Create New Assignment</span>
                    </div>
                    <form method="get" class="col-md-4 d-inline-block text-end" action="{{ route('manage-assignments') }}">
                    @csrf
                    <input type="hidden" name="course_id" value="1">
                    <button type="submit" class="btn btn-secondary py-2 fs-5" style="width:50%;">< Go Back</button>
                    </form>
                </div>
    <div class="row">
    <form method="post" class="col-md-12 d-inline-block" action="{{ route('create-assignment') }}">
        @csrf
        <input type="hidden" name="course_id" value="1">
        <div class="text-end">
            <button type="submit" class="btn btn-dark py-3 px-5 fs-4">Create</button>
        </div>
        </form>
    </div>
    @else
        <script>
        window.location.href = "{{ route('login') }}";
        </script>
    @endif
@endsection