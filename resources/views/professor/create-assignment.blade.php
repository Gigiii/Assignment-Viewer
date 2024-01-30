@extends('layouts.layout')

@section('content')
    @if ($auth_data != Null)
    <div class="row flex-row justify-content-between mb-4">
        <div class="col-md-4">
            <span class="fs-2">Create New Assignment for {{ $course_name }}</span>
        </div>
        <form method="get" class="col-md-4 d-inline-block text-end" action="{{ route('manage-assignments') }}">
        @csrf
        <input type="hidden" name="course_id" value="{{ $course_id }}">
        <input type="hidden" name="course_name" value="{{ $course_name }}">
        <button type="submit" class="btn btn-secondary py-2 fs-5 responsive-btn" style="width:50%;">< Go Back</button>
        </form>
    </div>
    <div class="row">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <form method="post" enctype="multipart/form-data" action="{{ route('create-assignment') }}">
                        @csrf
                                <div class="col-md-5 py-2">
                                <p class="fw-light fs-5 mb-1">Title</p>
                                <input type="text" name="title" class="form-control" required placeholder="Title">
                                </div>
                                <div class="col-md-8 py-2">
                                <p class="fw-light fs-5 mb-1">Description</p>
                                <textarea type="text" name="description" class="form-control" required placeholder="Description"></textarea>
                                </div>
                                <div class="row">
                                <div class="col-md-5">
                                    <div class="col-md-4 py-2">
                                    <p class="fw-light fs-5 mb-1">Grade</p>
                                    <input type="number" name="maxGrade" id="grade" class="form-control" required placeholder="Grade">
                                    </div>
                                </div>
                                <div class="col-md-4 py-2">
                                    <p class="fw-light fs-5 mb-1">Upload Attachments</p>
                                    <input type="file" class="form-control" name="attachments[]" required id="attachments" accept=".jpeg, .jpg, .png, .gif, .pdf, .doc, .docx, .ppt, .pptx" multiple>
                                </div>
                                <div class="col-md-5">
                                    <div class="col-md-8 py-2">
                                    <p class="fw-light fs-5 mb-1">Deadline</p>
                                    <input type="datetime-local" class="form-control" required name="deadline" id="deadline">
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="col-md-3 d-flex flex-column">
                            <div class="d-flex flex-column justify-content-between" style="height: 100%;">
                            <input type="hidden" name="course_id" value="{{ $course_id }}">
                            <input type="hidden" name="course_name" value="{{ $course_name }}">
                            <div class="container">
                                <div class="col-12 text-center">
                                <div class="course-img col-6 mx-auto d-flex justify-content-center">
                                    <img id="uploaded-photo" class="img-fluid" alt="Uploaded Photo" src="{{ asset('storage/images/image-placeholder.jpg') }}">
                                </div>
                                <label class="btn btn-default bg-black text-white" style="width:50%;">
                                    Upload Photo<input type="file" name="photo-upload" required id="photo-upload" class="form-control" accept="image/*" hidden>
                                </label>
                                </div>
                            </div>
                            <div class="text-end responsive-center-text pt-5">
                                <button type="submit" class="btn btn-dark py-3 px-5 fs-4">Create</button>
                                </div>
                            </div>
                        </div>
                    </form>
        </div>
    </div>

    </div>
    <script>
    const photoUploadInput = document.getElementById('photo-upload');
    const uploadedPhoto = document.getElementById('uploaded-photo');

    photoUploadInput.addEventListener('change', function() {
        const file = this.files[0];
        const reader = new FileReader();

        reader.addEventListener('load', function() {
        uploadedPhoto.src = reader.result;
        });

        if (file) {
        reader.readAsDataURL(file);
        }
    });
    </script>
    @else
        <script>
        window.location.href = "{{ route('login') }}";
        </script>
    @endif
@endsection