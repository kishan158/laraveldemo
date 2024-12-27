@extends('back.admin.layout.app')
@section('content')
<div class="page-content fade-in-up">
    <div class="alert bg-white d-flex justify-content-between align-items-center">
        <h4>QR Add</h4>


    </div>
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">Add QR Code</div>
            <div class="ibox-tools">
                <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
            </div>
        </div>
        <div class="ibox-body">
        <form class="form-horizontal" id="form-sample-1" method="POST" action="{{ route('admin.qr.update', $data->id) }}" novalidate="novalidate" enctype="multipart/form-data">
    @csrf
     <!-- Include method spoofing for PUT request -->
    
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">UPI ID</label>
        <div class="col-sm-10">
            <input class="form-control" type="text" name="upi_id" value="{{ old('upi_id', $data->upi_id) }}" required>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Upload QR Code</label>
        <div class="col-sm-10">
            <label class="file">
                <input type="file" name="image" id="gallery_file" accept="image/*" aria-label="File browser example" onchange="previewImage(event)" />
            </label>
        </div>
    </div>

    <!-- Image Preview Section -->
    <div class="form-group row" id="imagePreviewContainer" style="display: none;">
        <label class="col-sm-2 col-form-label">Image Preview</label>
        <div class="col-sm-10">
            <img id="imagePreview" src="#" alt="Image Preview" style="max-width: 100%; max-height: 100px;" />
        </div>
    </div>

    <!-- Current Image Display -->
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Current QR Code</label>
        <div class="col-sm-10">
            <img src="{{ asset('storage/app/public/' . $data->image) }}" alt="Current QR Code" class="img-fluid" style="width: 100px; height: 100px;">
            <small class="form-text text-muted">Current QR Code</small>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-10 ml-sm-auto">
            <button class="btn btn-info" type="submit">Update</button>
        </div>
    </div>
</form>

        </div>
    </div>

</div>
<script>
// JavaScript function to preview the selected image
function previewImage(event) {
    var reader = new FileReader();
    reader.onload = function() {
        var output = document.getElementById('imagePreview');
        output.src = reader.result;
        document.getElementById('imagePreviewContainer').style.display = 'block'; // Show the image preview
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>

@endsection