@extends('back.vendor.layout.app')
@section('content')
<div class="page-content fade-in-up">
    <div class="alert bg-white d-flex justify-content-between align-items-center">
        <h4>Recharge Wallet</h4>
        <a href="{{route('vendor.wallet.rechargelist')}}" class="btn btn-primary">Back</a>

    </div>

    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">Recharge </div>
            <div class="ibox-tools">
                <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
            </div>
        </div>
        <div class="ibox-body">

            <div class="row">
                @foreach($data as $value)
                <div class="col">
                    <div class="form-group">
                        <label class="col-sm-2 col-form-label">Pay on UPI ID</label>
                        <div class="col-sm-10">
                            <!-- Display the UPI ID from the data -->
                            {{ $value->upi_id ?? 'N/A' }}
                        </div>
                    </div>
                </div>
                OR
                <div class="col">
                    <div class="form-group ">
                        <label class="col-sm-2 col-form-label">Scan OR Code</label>
                        <div class="col-sm-10">
                            <img src="{{ asset('storage/app/public/' . $value->image) }}" alt="img" class="img-fluid"
                                style="width: 300px; height: 300px;">
                        </div>
                    </div>
                </div>
                @endforeach
            </div>





            <form class="form-horizontal" id="form-sample-1" method="post" action="{{route('vendor.wallet.recharge.submit')}}"
                novalidate="novalidate">

                @csrf
               
                <div class="form-group row">
                    <div class="col-sm-10 ml-sm-auto">
                    <input class="" type="number" name="amount" placeholder="Enter Recharge Amount">
                   <input class="" type="text" name="Utr_no" placeholder="Enter UTR No">
                      
                </div>
                <button class="btn btn-info" type="submit">Submit</button>
            </form>

          




        </div>
    </div>

</div>

@endsection