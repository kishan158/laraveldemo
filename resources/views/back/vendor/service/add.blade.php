@extends('back.vendor.layout.app')
@section('content')
<div class="page-content fade-in-up">
    <div class="alert bg-white d-flex justify-content-between align-items-center">
        <h4>Add</h4>


    </div>
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">Create </div>
            <div class="ibox-tools">
                <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
            </div>
        </div>
        <div class="ibox-body">
            <form class="form-horizontal" id="form-sample-1" method="post" action="{{route('vendor.service.submit')}}"
                novalidate="novalidate">
                @csrf
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Service</label>
                    <div class="col-sm-10">
                        <select name="service_id" id="service" class="form-control" required>
                            <option value="">Select Service</option>
                            @foreach($services as $service)
                            <option value="{{ $service->id }}">{{ $service->service }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Package</label>
                    <div class="col-sm-10">
                        <select name="package_id" id="package" class="form-control" required>
                            <option value="">Select Package</option>
                            @foreach($services as $service)
                            @foreach($service->packages as $package)
                            <option value="{{ $package->id }}" data-service="{{ $service->id }}">{{ $package->package }}
                            </option>
                            @endforeach
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Title</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="title">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Price</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="price">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Previous Price</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="previous_price">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Time Duration</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="time_duration" placeholder="minutes">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">City</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="city">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Pincode</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" name="pincode">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Description</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="description" rows="4"
                            placeholder="Enter a description"></textarea>
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

@endsection