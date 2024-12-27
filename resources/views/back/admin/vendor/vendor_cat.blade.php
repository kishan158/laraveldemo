@extends('back.admin.layout.app')
@section('content')
<div class="page-content fade-in-up">
    <div class="alert bg-white d-flex justify-content-between align-items-center">
        <h4>Assign Cat</h4>
        <a href="{{route('admin.vendor.list')}}" class="btn btn-primary">Back</a>
    </div>

    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">Create SubCategory</div>
            <div class="ibox-tools">
                <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
            </div>
        </div>
        <div class="ibox-body">
        <form class="form-horizontal" id="form-sample-1" method="post" action="{{ route('admin.vendor.catSubmit', $data->id) }}" novalidate="novalidate" enctype="multipart/form-data">
    @csrf
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Category Name</label>
        <div class="col-sm-10">
            <select class="form-control" name="category_id" id="category_id" required>
                <option value="">Select Category</option>
                @foreach($subcategories as $subcategory)
                    <option value="{{ $subcategory->id }}">{{ $subcategory->category }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Subcategory Dropdown -->
   

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
// JavaScript to populate subcategories based on category selection
document.getElementById('category_id').addEventListener('change', function() {
    var categoryId = this.value;

    if (categoryId) {
        // Clear the existing options
        var subcategorySelect = document.getElementById('subcategory_id');
        subcategorySelect.innerHTML = '<option value="">Select Subcategory</option>';

        // Fetch subcategories for the selected category
        var subcategories = @json($subcategories); // Convert PHP data to JS array

        // Loop through subcategories and add to the dropdown
        subcategories.forEach(function(subcategory) {
            if (subcategory.category_id == categoryId) {
                var option = document.createElement('option');
                option.value = subcategory.id;
                option.text = subcategory.subcategory;
                subcategorySelect.appendChild(option);
            }
        });
    }
});
</script>
@endsection