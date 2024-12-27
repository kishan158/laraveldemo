@extends('back.vendor.layout.app')
@section('content')

<div class="page-content fade-in-up">
    <div class="alert bg-white d-flex justify-content-between align-items-center">
        <h4>Finance Details</h4>


    </div>

    <div class="page-content fade-in-up">
        <div class="row">
            <div class="col-md-6">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">GST Details</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>

                        </div>
                    </div>
                    <div class="ibox-body">
                        <form class="form-horizontal" action="{{ route('finance.saveOrUpdate') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="form_type" value="gst_form">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="gst_name" placeholder="Name"
                                        value="{{ old('gst_name', isset($financeData) && $financeData->gst_details ? json_decode($financeData->gst_details)->gst_name : '') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">GST No</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="gst_no" placeholder="GST No"
                                        value="{{ old('gst_no', isset($financeData) && $financeData->gst_details ? json_decode($financeData->gst_details)->gst_no : '') }}">
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
            <div class="col-md-6">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">PAN CARD Details</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <form class="form-horizontal" action="{{ route('finance.saveOrUpdate') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="form_type" value="pan_form">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Name On Pan Card</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" name="pan_name" placeholder="Name"
                                        value="{{ old('pan_name', isset($financeData->pan_card_details) ? json_decode($financeData->pan_card_details)->pan_name : '') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">PAN No</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" name="pan_no" placeholder="PAN No"
                                        value="{{ old('pan_no', isset($financeData->pan_card_details) ? json_decode($financeData->pan_card_details)->pan_no : '') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">PAN Upload</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="file" name="pan_upload">
                                    @if(isset($financeData->pan_card_details) &&
                                    json_decode($financeData->pan_card_details)->pan_upload)
                                    <a href="{{ asset('storage/app/public/' . json_decode($financeData->pan_card_details)->pan_upload) }}"
                                        target="_blank">View Uploaded File</a>
                                    @endif


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
        <div class="row">
            <div class="col-md-6">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Bank Account</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <form class="form-horizontal" action="{{ route('finance.saveOrUpdate') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="form_type" value="bank_form">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Name in Account</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" name="account_name"
                                        placeholder="Name in Account"
                                        value="{{ old('account_name', isset($financeData) && $financeData->bank_details ? json_decode($financeData->bank_details)->account_name : '') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Bank Name</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" name="bank_name" placeholder="Bank Name"
                                        value="{{ old('bank_name', isset($financeData) && $financeData->bank_details ? json_decode($financeData->bank_details)->bank_name : '') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Account Number</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" name="account_number" placeholder="Password"
                                        value="{{ old('account_number', isset($financeData) && $financeData->bank_details ? json_decode($financeData->bank_details)->account_number : '') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Branch</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" name="branch" placeholder="Branch"
                                        value="{{ old('branch', isset($financeData) && $financeData->bank_details ? json_decode($financeData->bank_details)->branch : '') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">IFSC CODE</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" name="ifsc_code" placeholder="IFSC CODE"
                                        value="{{ old('ifsc_code', isset($financeData) && $financeData->bank_details ? json_decode($financeData->bank_details)->ifsc_code : '') }}">
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
            <div class="col-md-6">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Personal Details</div>
                        <div class="ibox-tools">
                            <a class="ibox-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <form class="form-horizontal" action="{{ route('finance.saveOrUpdate') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="form_type" value="personal_form">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Name</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" name="name" placeholder="Name"
                                        value="{{ old('name', isset($financeData) && $financeData->personal_details ? json_decode($financeData->personal_details)->name : '') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Aadhar Number</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" name="aadhar_number"
                                        placeholder="Aadhar Card"
                                        value="{{ old('aadhar_number', isset($financeData) && $financeData->personal_details ? json_decode($financeData->personal_details)->aadhar_number : '') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Upload Adhar Card</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="file" name="aadhar_upload"
                                        placeholder="Aadhar Card">
                                    @if(isset($financeData) && $financeData->personal_details)
                                    @php
                                    $personalDetails = json_decode($financeData->personal_details);
                                    @endphp

                                    @if(isset($personalDetails->aadhar_upload))
                                    <div class="mt-2">
                                        <a href="{{ asset('storage/app/public/' . $personalDetails->aadhar_upload) }}"
                                            target="_blank" alt="img">View Uploaded Aadhar Card</a>
                                    </div>
                                    @endif
                                    @endif

                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Date Of Birth</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="date" name="dob" placeholder="D.O.B"
                                        value="{{ old('dob', isset($financeData) && $financeData->personal_details ? json_decode($financeData->personal_details)->dob : '') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Father's Name</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" name="father_name"
                                        placeholder="Father's Name"
                                        value="{{ old('father_name', isset($financeData) && $financeData->personal_details ? json_decode($financeData->personal_details)->father_name : '') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Email</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="email" name="email" placeholder="Email address"
                                        value="{{ old('email', isset($financeData) && $financeData->personal_details ? json_decode($financeData->personal_details)->email : '') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Phone No</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" name="phone" placeholder="Phone"
                                        value="{{ old('phone', isset($financeData) && $financeData->personal_details ? json_decode($financeData->personal_details)->phone : '') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Gender</label>
                                <div class="col-sm-8">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="male"
                                            value="Male"
                                            {{ old('gender', isset($financeData) && $financeData->personal_details && json_decode($financeData->personal_details)->gender == 'Male' ? 'checked' : '') }}>
                                        <label class="form-check-label" for="male">Male</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="female"
                                            value="Female"
                                            {{ old('gender', isset($financeData) && $financeData->personal_details && json_decode($financeData->personal_details)->gender == 'Female' ? 'checked' : '') }}>
                                        <label class="form-check-label" for="female">Female</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Address</label>
                                <div class="col-sm-8">
                                    <textarea class="form-control" name="address"
                                        placeholder="Address">{{ old('address', isset($financeData) && $financeData->personal_details ? json_decode($financeData->personal_details)->address : '') }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">City</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" name="city" placeholder="City"
                                        value="{{ old('city', isset($financeData) && $financeData->personal_details ? json_decode($financeData->personal_details)->city : '') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Pin Code</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" name="pin_code" placeholder="Pin Code"
                                        value="{{ old('pin_code', isset($financeData) && $financeData->personal_details ? json_decode($financeData->personal_details)->pin_code : '') }}">
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
    </div>

    @endsection