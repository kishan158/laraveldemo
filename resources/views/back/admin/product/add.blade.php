@extends('back.admin.layout.app')
@section('content')
<div class="page-content fade-in-up">
    <div class="alert bg-white d-flex justify-content-between align-items-center">
        <h4>Add Product</h4>

        <a href="{{route('admin.Part.list',['id'=>$subcat->id])}}" class="btn btn-primary">Back</a>
    </div>
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">Add Product</div>
            <div class="ibox-tools">
                <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
            </div>
        </div>
        <div class="ibox-body">
        <form class="form-horizontal" id="form-sample-1" method="post" action="{{ route('admin.Part.submit',$subcat->id) }}" novalidate="novalidate" enctype="multipart/form-data">
    @csrf

    <!-- Category Dropdown -->
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Service Name</label>
        <div class="col-sm-10">
        <input class="form-control" type="text"  value="{{$service->service ?? ''}}" required readonly>
        <input class="form-control" type="hidden" name="service_id" value="{{$subcategories->service_id ?? ''}}" required>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Product Category Name</label>
        <div class="col-sm-10">
        <input class="form-control" type="text"  value="{{$subcategories->product_type ?? ''}}" required readonly>
        <input class="form-control" type="hidden" name="subcategory_id" value="{{$subcategories->id ?? ''}}" required>

        </div>
    </div>

   

    <!-- Product Name -->
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Product Name</label>
        <div class="col-sm-10">
            <input class="form-control" type="text" name="product_name" required>
        </div>
    </div>

    <!-- Product Price -->
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Product Price</label>
        <div class="col-sm-10">
            <input class="form-control" type="text" name="price" required>
        </div>
    </div>

    <!-- Product Image Upload -->
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Upload Image</label>
        <div class="col-sm-10">
            <label class="file">
                <input type="file" name="image" id="gallery_file" accept="image/*" aria-label="File browser example" onchange="previewImage(event)" required />
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