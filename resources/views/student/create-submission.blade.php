@extends('layouts.layout')

@section('content')
    @if ($auth_data != Null)
    <div class="row flex-row justify-content-between mb-4">
        <div class="col-md-4">
            <span class="fs-2">Create New Submission</span>
        </div>
        <form method="get" class="col-md-4 d-inline-block text-end" action="{{ route('manage-assignments') }}">
        @csrf
        <input type="hidden" name="assignment_id" value="1">
        <button type="submit" class="btn btn-secondary py-2 fs-5" style="width:50%;">< Go Back</button>
        </form>
    </div>
    <div class="row">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <form method="post" action="{{ route('create-assignment') }}">
                        @csrf
                        <div class="col-md-5 py-2">
                        <p class="fw-light fs-5 mb-1">Title*</p>
                        <input type="text" class="form-control" required placeholder="Title">
                        </div>
                        <div class="col-md-8 py-2">
                        <p class="fw-light fs-5 mb-1">Description*</p>
                        <textarea type="text" class="form-control" style="min-height:35vh;" required placeholder="Description"></textarea>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex flex-column">
                    <div class="d-flex flex-column justify-content-between" style="height: 100%;">
                    <input type="hidden" name="course_id" value="1">
                    <div class="container">
                    <div class="col-md-12 py-2">
                            <p class="fw-light fs-5 mb-1">Upload Attachments</p>
                            <input type="file" class="form-control" name="attachments" id="attachments" accept=".jpeg, .jpg, .png, .gif, .pdf, .doc, .docx, .ppt, .pptx">
                        </div>
                    </div>
                    <div class="text-end pt-5">
                        <button type="submit" class="btn btn-dark py-3 px-5 fs-4">Submit Work</button>
                        </div>
                    </div>
                </div>
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