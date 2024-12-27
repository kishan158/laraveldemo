@extends('back.admin.layout.app')
@section('content')
<div class="page-content fade-in-up">
    <div class="alert bg-white d-flex justify-content-between align-items-center">
        <h4>Add Product </h4>
    <a href="{{route('admin.product_type.list',['id'=>$service->id])}}" class="btn btn-primary">Back</a>

    </div>
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">Create Product </div>
            <div class="ibox-tools">
                <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
            </div>
        </div>
        <div class="ibox-body">
            <form class="form-horizontal" id="form-sample-1" method="post"
                action="{{route('admin.product_type.submit',['id'=>$service->id])}}" novalidate="novalidate" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"> Service</label>
                  
                    <input class="form-control col-sm-10" type="text" name="service_id" value="{{ $service->service }}" required readonly>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"> Name</label>
                  
                    <input class="form-control col-sm-10" type="text" name="product_type" value="{{ old('product_type') }}" required>
                </div>

              

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Upload Image</label>
                    <div class="col-sm-10">
                        <label class="file">
                            <input type="file" name="image" id="gallery_file" accept="image/*"
                                aria-label="File browser example" onchange="previewImage(event)" required />
                        </label>
                    </div>
                </div>

                <!-- Image Preview Section -->
                <div class="form-group row" id="imagePreviewContainer" style="display: none;">
                    <label class="col-sm-2 col-form-label">Image Preview</label>
                    <div class="col-sm-10">
                        <img id="imagePreview" src="#" alt="Image Preview"
                            style="max-width: 100%; max-height: 100px;" />
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-10 ml-sm-auto">
                        <button class="btn btn-info" type="submit">Submit</button>
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