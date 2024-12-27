@extends('back.vendor.layout.app')
@section('content')

<div class="page-content fade-in-up">
    <div class="alert bg-white d-flex justify-content-between align-items-center">
        <h4>Add Extra Extimate</h4>


    </div>
    <div class="page-content fade-in-up">
        <div class="row">
            <div class="col-md-6">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Add Extra Work</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                            <a class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></a>

                        </div>
                    </div>
                    <div class="ibox-body">
                    <form action="{{ route('vendor.service.order.submit', $order->id) }}" method="post">
                        @csrf
                    <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label>Work</label>
                                    <input class="form-control" type="text" name="extra_work" placeholder="Enter Extra Work" required>
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label>Price</label>
                                    <input class="form-control" type="text" name="price_added" placeholder="Enter price" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <button class="btn btn-default" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>


    </div>
    @endsection