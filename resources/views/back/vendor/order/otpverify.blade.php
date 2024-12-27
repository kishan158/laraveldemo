@extends('back.vendor.layout.app')
@section('content')
<div class="page-content fade-in-up">
    <div class="alert bg-white d-flex justify-content-between align-items-center">
        <h4>OTP Verify</h4>
     <a href="{{route('vendor.service.order')}}" class="btn btn-primary">Back</a>

    </div>

    <div class="page-content fade-in-up">
        <div class="row">
            <div class="col-md-6">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">OTP</div>
                       
                    </div>
                    <div class="ibox-body">
                    <form action="{{route('vendorOrder.otp.submit',$order->id)}}" method="post">
                        @csrf
                        <input type="hidden" value="{{$order->id}}">
                    <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label>Enter Otp</label>
                                    <input class="form-control" type="text" name="otp" placeholder="Please Enter Otp" required>
                                </div>
                              
                            </div>

                            <div class="form-group">
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>


    </div>

@endsection