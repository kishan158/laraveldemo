@extends('back.admin.layout.app')
@section('content')
<div class="page-content fade-in-up">
    <div class="alert bg-white d-flex justify-content-between align-items-center">
        <h4>Partner Profile</h4>
        <a href="{{route('admin.vendor.list')}}" class="btn btn-primary">Back</a>
    </div>

    <div class="page-content fade-in-up">
        <div class="row">
            <div class="col-lg-3 col-md-4">
                <div class="ibox">
                    <div class="ibox-body text-center">
                        @if(!empty($data->image))
                        <div class="m-t-20">
                            <img class="img-circle" src="{{ asset('storage/app/public/' . $data->image) }}" alt="Image">
                        </div>
                        @else
                        <p>No Image Available</p>
                        @endif
                        <h5 class="font-strong m-b-10 m-t-10">{{$data->name ?? ''}} {{$data->last_name ?? ''}}</h5>
                        <div class="profile-social m-b-20">
                        </div>
                        <div>
                            <button class="btn btn-info btn-rounded m-b-5"><i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-8">
                <div class="ibox">
                    <div class="ibox-body">
                        <ul class="nav nav-tabs tabs-line">
                            <li class="nav-item">
                                <a class="nav-link active" href="#tab-1" data-toggle="tab"><i class="ti-bar-chart"></i>
                                    Personal Details</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#tab-2" data-toggle="tab"><i class="ti-settings"></i>
                                    Bank Details</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#tab-3" data-toggle="tab"><i class="ti-announcement"></i>
                                    KYC Details</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#tab-4" data-toggle="tab"><i class="ti-announcement"></i>
                                    Partner Cat</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="tab-1">
                                <h5 class="text-info m-b-20 m-t-20"><i class="fa fa-bullhorn"></i> Latest Feeds</h5>
                                <ul class="media-list media-list-divider m-0">
                                    <li class="media">
                                        <div class="media-img"><i class="ti-user font-18 text-muted"></i></div>
                                        <div class="media-body">
                                            <div class="media-heading text-success">Name <small
                                                    class="float-right text-muted"></small></div>
                                            <div class="font-13">{{ $personalDetails['name'] ?? 'No Data' }}</div>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <div class="media-img"><i class="ti-user font-18 text-muted"></i></div>
                                        <div class="media-body">
                                            <div class="media-heading text-success">Father Name <small
                                                    class="float-right text-muted"></small></div>
                                            <div class="font-13">{{ $personalDetails['father_name'] ?? 'No Data' }}
                                            </div>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <div class="media-img"><i class="ti-email font-18 text-muted"></i>
                                        </div>
                                        <div class="media-body">
                                            <div class="media-heading text-success">Email <small
                                                    class="float-right text-muted"></small></div>
                                            <div class="font-13">{{ $personalDetails['email'] ?? 'No Data' }}</div>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <div class="media-img"><i class="ti-mobile font-18 text-muted"></i></div>
                                        <div class="media-body">
                                            <div class="media-heading text-success">Phone <small
                                                    class="float-right text-muted"></small></div>
                                            <div class="font-13">{{ $personalDetails['phone'] ?? 'No Data' }}</div>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <div class="media-img"><i class="fa fa-calendar font-18 text-muted"></i>
                                        </div>
                                        <div class="media-body">
                                            <div class="media-heading text-success">Date Of Birth <small
                                                    class="float-right text-muted"></small></div>
                                            <div class="font-13">{{ $personalDetails['dob'] ?? 'No Data' }}</div>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <div class="media-img"><i class="ti-user font-18 text-muted"></i></div>
                                        <div class="media-body">
                                            <div class="media-heading text-success">Gender <small
                                                    class="float-right text-muted"></small></div>
                                            <div class="font-13">{{ $personalDetails['gender'] ?? 'No Data' }}</div>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <div class="media-img"><i class="ti-location-pin font-18 text-muted"></i></div>
                                        <div class="media-body">
                                            <div class="media-heading text-success">City <small
                                                    class="float-right text-muted"></small></div>
                                            <div class="font-13">{{ $personalDetails['city'] ?? 'No Data' }}</div>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <div class="media-img"><i class="ti-location-pin font-18 text-muted"></i></div>
                                        <div class="media-body">
                                            <div class="media-heading text-success">Address <small
                                                    class="float-right text-muted"> </small></div>
                                            <div class="font-13">{{ $personalDetails['address'] ?? 'No Data' }}.</div>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <div class="media-img"><i class="ti-location-pin font-18 text-muted"></i></div>
                                        <div class="media-body">
                                            <div class="media-heading text-success">Pin Code <small
                                                    class="float-right text-muted"></small></div>
                                            <div class="font-13">{{ $personalDetails['pin_code'] ?? 'No Data' }}</div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-pane fade" id="tab-2">
                                <h5 class="text-info m-b-20 m-t-20"><i class="fa fa-bullhorn"></i> Latest Feeds</h5>
                                <ul class="media-list media-list-divider m-0">
                                    <li class="media">
                                        <div class="media-img"><i class="ti-user font-18 text-muted"></i></div>
                                        <div class="media-body">
                                            <div class="media-heading text-success">Name <small
                                                    class="float-right text-muted"></small></div>
                                            <div class="font-13">{{ $bankDetails['account_name'] ?? 'No Data' }}</div>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <div class="media-img"><i class="ti-layout-menu-v font-18 text-muted"></i></div>
                                        <div class="media-body">
                                            <div class="media-heading text-success">Bank Name <small
                                                    class="float-right text-muted"></small></div>
                                            <div class="font-13">{{ $bankDetails['bank_name']  ?? 'No Data' }}</div>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <div class="media-img"><i class="ti-credit-card font-18 text-muted"></i></div>
                                        <div class="media-body">
                                            <div class="media-heading text-success">Account Number <small
                                                    class="float-right text-muted"></small></div>
                                            <div class="font-13">{{ $bankDetails['account_number'] ?? 'No Data' }}</div>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <div class="media-img"><i class="ti-layout-menu-v font-18 text-muted"></i></div>
                                        <div class="media-body">
                                            <div class="media-heading text-success">Branch <small
                                                    class="float-right text-muted"></small></div>
                                            <div class="font-13">{{ $bankDetails['branch'] ?? 'No Data' }}</div>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <div class="media-img"><i class="ti-layout-menu-v font-18 text-muted"></i></div>
                                        <div class="media-body">
                                            <div class="media-heading text-success">IFSC CODE <small
                                                    class="float-right text-muted"></small></div>
                                            <div class="font-13">{{ $bankDetails['ifsc_code'] ?? 'No Data' }}</div>
                                        </div>
                                    </li>

                                </ul>
                            </div>
                            <div class="tab-pane fade" id="tab-3">
                                <h5 class="text-info m-b-20 m-t-20"><i class="fa fa-bullhorn"></i> Latest Feeds</h5>
                                <ul class="media-list media-list-divider m-0">
                                    <li class="media">
                                        <div class="media-img"><i class="ti-user font-18 text-muted"></i></div>
                                        <div class="media-body">
                                            <div class="media-heading text-success">GST Name <small
                                                    class="float-right text-muted"></small></div>
                                            <div class="font-13">{{ $kycDetails['gst_name'] ?? 'No Data' }}</div>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <div class="media-img"><i class="ti-credit-card font-18 text-muted"></i></div>
                                        <div class="media-body">
                                            <div class="media-heading text-success">GST Number <small
                                                    class="float-right text-muted"></small></div>
                                            <div class="font-13">{{ $kycDetails['gst_no'] ?? 'No Data' }}</div>
                                        </div>
                                    </li>

                                    <li class="media">
                                        <div class="media-img"><i class="ti-credit-card font-18 text-muted"></i></div>
                                        <div class="media-body">
                                            <div class="media-heading text-success">Name on Pan Card <small
                                                    class="float-right text-muted"></small></div>
                                            <div class="font-13">{{ $kycDetails2['pan_name'] ?? 'No Data' }}</div>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <div class="media-img"><i class="ti-credit-card font-18 text-muted"></i></div>
                                        <div class="media-body">
                                            <div class="media-heading text-success">Pan No <small
                                                    class="float-right text-muted"></small></div>
                                            <div class="font-13">{{ $kycDetails2['pan_no'] ?? 'No Data' }}</div>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <div class="media-img"><i class="ti-credit-card font-18 text-muted"></i></div>
                                        <div class="media-body">
                                            <div class="media-heading text-success">Pan Image <small
                                                    class="float-right text-muted"></small></div>

                                            @if(!empty($kycDetails2['pan_upload']))
                                            <img src="{{ asset('storage/app/public/' . $kycDetails2['pan_upload']) }}"
                                                alt="Pan Card Image" width="200">
                                            @else
                                            <p>No Pan Card Image Available</p>
                                            @endif
                                        </div>
                                    </li>
                                    <li class="media">
                                        <div class="media-img"><i class="ti-credit-card font-18 text-muted"></i></div>
                                        <div class="media-body">
                                            <div class="media-heading text-success">Aadhar No <small
                                                    class="float-right text-muted"></small></div>
                                            <div class="font-13">{{ $personalDetails['aadhar_number'] ?? 'No Data' }}
                                            </div>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <div class="media-img"><i class="ti-credit-card font-18 text-muted"></i></div>
                                        <div class="media-body">
                                            <div class="media-heading text-success">Aadhar Image <small
                                                    class="float-right text-muted"></small></div>
                                            @if(!empty($personalDetails['aadhar_upload']))
                                            <img src="{{ asset('storage/app/public/' . $personalDetails['aadhar_upload']) }}"
                                                alt="img" width="200">
                                            @else
                                            <p>No Image Available</p>
                                            @endif
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-pane fade" id="tab-4">
                                <h5 class="text-info m-b-20 m-t-20"><i class="fa fa-bullhorn"></i> Partner Categoey</h5>
                                <ul class="media-list media-list-divider m-0">
                                    <li class="media">
                                        <div class="media-img"><i class="ti-user font-18 text-muted"></i></div>
                                        <div class="media-body">
                                            <div class="media-heading text-success">Category name <small
                                                    class="float-right text-muted"></small></div>
                                            <div class="font-13"> {{ $category ? $category->category : 'N/A' }}</div>
                                        </div>
                                    </li>
                                   


                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <style>
        .profile-social a {
            font-size: 16px;
            margin: 0 10px;
            color: #999;
        }

        .profile-social a:hover {
            color: #485b6f;
        }

        .profile-stat-count {
            font-size: 22px
        }
        </style>

    </div>

    @endsection