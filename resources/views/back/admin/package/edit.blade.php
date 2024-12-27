@extends('back.admin.layout.app')
@section('content')
<div class="page-content fade-in-up">
    <div class="alert bg-white d-flex justify-content-between align-items-center">
        <h4>Update</h4>
        <a href="{{route('admin.issue.list',['id' => $service->id])}}" class="btn btn-primary">Back</a>

    </div>
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">Update Issue</div>
            <div class="ibox-tools">
                <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
            </div>
        </div>
        <div class="ibox-body">
            <form class="form-horizontal" id="form-sample-1" method="POST"
                action="{{ route('admin.issue.update', $package->id) }}" enctype="multipart/form-data">
                @csrf


                <!-- Service Selection Dropdown -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Service</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" value="{{ $service->service }}" readonly>
                        <input type="hidden" name="service_id" value="{{ $service->id }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Service Title</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="service_title_id">
                            <option value="">Select a Service Title</option>
                            @foreach($service_titles as $title)
                            <option value="{{ $title->id }}"
                                {{ $title->id == $selected_service_title_id ? 'selected' : '' }}>
                                {{ $title->service_title }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Package Name -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Issue</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="package" value="{{ $package->package }}">
                    </div>
                </div>

                <!-- Image Upload -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Upload Image</label>
                    <div class="col-sm-10">
                        <label class="file">
                            <input type="file" name="image" id="gallery_file" accept="image/*"
                                onchange="previewImage(event)">
                        </label>
                        @if($package->image)
                        <img src="{{ asset('public/front/image/' . $package->image) }}" alt="Current Image"
                            style="max-width: 100%; max-height: 100px;">
                        @endif
                    </div>
                </div>

                <!-- Price -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Labour Cost</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="number" name="price" value="{{ $package->price }}">
                    </div>
                </div>

                <!-- Previous Price -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Previous Labour Cost</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="number" name="previous_price"
                            value="{{ $package->previous_price }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Convenience Fee</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="number" name="convenience_fee"
                            placeholder="Enter amount in Rupees" value="{{ $package->convenience_fee ?? '' }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Visiting Charge</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="number" name="visiting_charge"
                            placeholder="Enter amount in Rupees" value="{{ $package->visiting_charge ?? '' }}">
                    </div>
                </div>

                <!-- Time Duration -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Time Duration</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="number" name="time_duration"
                            value="{{ $package->time_duration }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"> Warranty</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="number" name="warranty" value="{{ $package->warranty }}">
                    </div>
                </div>

                <!-- City -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">City</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="city" value="{{ $package->city }}">
                    </div>
                </div>

                <!-- Pincode -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Pincode</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="pincode" value="{{ $package->pincode }}">
                    </div>
                </div>

                <!-- Description -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Description</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="description"
                            rows="4">{{ $package->description }}</textarea>
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