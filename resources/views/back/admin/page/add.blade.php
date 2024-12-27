@extends('back.admin.layout.app')
@section('content')
<div class="page-content fade-in-up">
    <div class="alert bg-white d-flex justify-content-between align-items-center">
        <h4>Add Page</h4>
        <a href="{{ route('admin.back.page') }}" class="btn btn-primary">Back</a>
    </div>

    <div class="ibox">
        <div class="ibox-body">
            <form class="form-horizontal" id="form-sample-1" method="post" action="{{ route('admin.back.page.submit') }}" novalidate="novalidate" enctype="multipart/form-data">
                @csrf

                <!-- Title Field -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Title</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="title" placeholder="title" required>
                    </div>
                </div>

                <!-- Slug Field -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Slug</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="slug" required>
                    </div>
                </div>

                <!-- Summernote WYSIWYG Editor for Details -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Details</label>
                    <div class="col-sm-10">
                        <textarea id="summernote" name="details" data-plugin="summernote" data-air-mode="true" required></textarea>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="form-group row">
                    <div class="col-sm-10 ml-sm-auto">
                        <button class="btn btn-info" type="submit">Submit</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
