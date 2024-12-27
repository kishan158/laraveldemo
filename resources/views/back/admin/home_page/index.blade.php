@extends('back.admin.layout.app')
@section('content')
<div class="page-content fade-in-up">
    <div class="alert bg-white d-flex justify-content-between align-items-center">
        <h4>Order List</h4>


    </div>
    <div class="ibox">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-head">
                    <div class="ibox-title">Title Logo</div>
                    <div class="ibox-tools">
                        <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        <a class="fullscreen-link"><i class="fa fa-expand"></i></a>
                    </div>
                </div>
                <div class="ibox-body">
                    <form class="form-horizontal" action="{{ route('admin.front.submit') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Title</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" name="title" value="{{ $title['title'] ?? '' }}"
                                    placeholder="Company Name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Address</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" name="address"
                                    value="{{ $title['address'] ?? '' }}" placeholder="Company Address">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Logo</label>
                            <div class="col-sm-10">
                                <!-- Logo Preview Container -->
                                <div id="logoPreviewContainer">
                                    @if(isset($title['logo']) && $title['logo'])
                                    <img src="{{ asset('storage/app/public/' . $title['logo']) }}" alt="Logo"
                                        width="100">
                                    @endif
                                </div>

                                <!-- File Input for Logo -->
                                <div id="logoPreviewContainer" style="display: flex; gap: 10px;"></div>

                                <input class="form-control" type="file" name="logo" id="logoInput"
                                    placeholder="Please Choose Logo">
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
    </div>

    <div class="ibox">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-head">
                    <div class="ibox-title">Home Banner</div>
                    <div class="ibox-tools">
                        <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        <a class="fullscreen-link"><i class="fa fa-expand"></i></a>
                    </div>
                </div>
                <div class="ibox-body">
                    <form class="form-horizontal" action="{{ route('admin.front.banners') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf

                        <!-- Banner1 -->
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Banner1</label>
                            <div class="col-sm-10">
                                <!-- Preview for existing images -->
                                <div id="banner1PreviewContainer" style="display: flex; gap: 10px;">
                                    @foreach($banner1 as $image)
                                    <img src="{{ asset('storage/app/private/public/' . $image) }}" alt="Banner 1"
                                        width="100">
                                    @endforeach
                                </div>

                                <!-- File input for Banner1 -->
                                <input class="form-control" type="file" name="banner1[]" multiple id="banner1Input"
                                    placeholder="Please Choose Banner First">
                            </div>
                        </div>

                        <!-- Banner2 -->
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Banner2</label>
                            <div class="col-sm-10">
                                <div id="banner2PreviewContainer" style="display: flex; gap: 10px;">
                                    @foreach($banner2 as $image)
                                    <img src="{{ asset('storage/app/private/public/' . $image) }}" alt="Banner 2"
                                        width="100">
                                    @endforeach
                                </div>
                                <input class="form-control" type="file" name="banner2[]" multiple id="banner2Input"
                                    placeholder="Please Choose Banner Second">
                            </div>
                        </div>

                        <!-- Banner3 -->
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Banner3</label>
                            <div class="col-sm-10">
                                <div id="banner3PreviewContainer" style="display: flex; gap: 10px;">
                                    @foreach($banner3 as $image)
                                    <img src="{{ asset('storage/app/private/public/' . $image) }}" alt="Banner 3"
                                        width="100">
                                    @endforeach
                                </div>
                                <input class="form-control" type="file" name="banner3[]" multiple id="banner3Input"
                                    placeholder="Please Choose Banner Third">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Mobile View Image</label>
                            <div class="col-sm-10">
                                <div id="mobile_viewPreviewContainer" style="display: flex; gap: 10px;">
                                    @foreach($mobile_view as $image)
                                    <img src="{{ asset('storage/app/private/public/' . $image) }}" alt="Mobile view "
                                        width="100">
                                    @endforeach
                                </div>
                                <input class="form-control" type="file" name="mobile_view[]" multiple id="mobile_viewInput"
                                    placeholder="Please Choose Mobile view Image">
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
    </div>


</div>
<script>
function previewBannerImages(input, previewContainerId) {
    const files = input.files;
    const previewContainer = document.getElementById(previewContainerId);
    previewContainer.innerHTML = ''; // Clear any existing previews

    // Loop through the selected files
    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const reader = new FileReader();

        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.width = '100px'; // Set image size
            img.style.height = '100px';
            img.style.marginRight = '10px';
            previewContainer.appendChild(img);
        };

        reader.readAsDataURL(file);
    }
}

// Attach event listeners to the banner file inputs
document.getElementById('banner1Input').addEventListener('change', function() {
    previewBannerImages(this, 'banner1PreviewContainer');
});

document.getElementById('banner2Input').addEventListener('change', function() {
    previewBannerImages(this, 'banner2PreviewContainer');
});

document.getElementById('banner3Input').addEventListener('change', function() {
    previewBannerImages(this, 'banner3PreviewContainer');
});
document.getElementById('mobile_viewInput').addEventListener('change', function() {
    previewBannerImages(this, 'mobile_viewPreviewContainer');
});

document.getElementById('logoInput').addEventListener('change', function() {
    previewBannerImages(this, 'logoPreviewContainer');
});
</script>

<style>
#banner1PreviewContainer img,
#banner2PreviewContainer img,
#banner3PreviewContainer img,
#mobile_viewPreviewContainer img,
#logoPreviewContainer img {
    width: 100px;
    /* Set the image size */
    height: 100px;
    /* Maintain aspect ratio */
    margin-right: 10px;
    /* Add space between images */
}
</style>
@endsection