@extends('back.admin.layout.app')
@section('content')
<div class="page-content fade-in-up">
    <div class="alert bg-white d-flex justify-content-between align-items-center">
        <h4>Update Product Category</h4>
        <a href="{{route('admin.product_type.list',['id'=>$service->id])}}" class="btn btn-primary">Back</a>

    </div>
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">Update Product Category</div>
            <div class="ibox-tools">
                <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
            </div>
        </div>
        <div class="ibox-body">
            <form class="form-horizontal" id="form-sample-1" method="post"
                action="{{ route('admin.product_type.update', $subcategory->id) }}" novalidate="novalidate"
                enctype="multipart/form-data">
                @csrf


                <!-- Category Dropdown -->

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"> Service</label>
                    <div class="col-sm-10">
                    <input class="form-control" type="text" value="{{ $service->service }}" readonly>
                            <input type="hidden" name="service_id" value="{{ $service->id }}">
                    </div>
                </div>
                <!-- SubCategory Name -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Product Category </label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="product_type"
                            value="{{ $subcategory->product_type }}" required>
                    </div>
                </div>

                <!-- Image Upload -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Upload Image</label>
                    <div class="col-sm-10">
                        <input type="file" name="image" accept="image/*" onchange="previewImage(event)">
                        @if($subcategory->image)
                        <img src="{{ asset('public/category/image/' . $subcategory->image) }}" alt="Current Image"
                            style="max-height: 100px;">
                        @endif
                    </div>
                </div>

                <!-- Submit Button -->
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