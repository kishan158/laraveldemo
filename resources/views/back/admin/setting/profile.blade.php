@extends('back.admin.layout.app')
@section('content')
<div class="page-content fade-in-up">
    <div class="alert bg-white d-flex justify-content-between align-items-center">
        <h4>Profile</h4>

    </div>
    <div class="ibox">

        <div class="row">
            <div class="col-xl-12">

                <div class="page-content fade-in-up">
                    <div class="row">
                        <div class="col-lg-3 col-md-4">
                            <div class="ibox">
                                <div class="ibox-body text-center">
                                    <div class="m-t-20">
                                        <!-- <img class="img-circle" src="./assets/img/users/u3.jpg" /> -->
                                        @if($admin->image)
                                        <img src="{{ asset('storage/app/public/' . $admin->image) }}"
                                            alt="Profile Image" class="img-circle mt-2" width="100">
                                        @endif
                                    </div>
                                    <h5 class="font-strong m-b-10 m-t-10">{{$admin->name}}</h5>
                                    <div class="m-b-20 text-muted">{{$admin->role}}</div>

                                </div>
                            </div>

                        </div>
                        <div class="col-lg-9 col-md-8">
                            <div class="ibox">
                                <div class="ibox-body">
                                    <ul class="nav nav-tabs tabs-line">

                                        <li class="nav-item">
                                            <a class="nav-link" href="#tab-2" data-toggle="tab"><i
                                                    class="ti-settings"></i> Settings</a>
                                        </li>

                                    </ul>
                                    <div class="tab-content">

                                        <div class="tab-pane fade show active" id="tab-2">
                                            <form action="{{ route('admin.profile.update') }}" method="POST"
                                                enctype="multipart/form-data">

                                                @csrf
                                                <div class="row">
                                                    <div class="col-sm-6 form-group">
                                                        <label>First Name</label>
                                                        <input class="form-control" type="text" name="name"
                                                            placeholder="First Name"
                                                            value="{{ old('name', $admin->name) }}" required>
                                                    </div>
                                                    <div class="col-sm-6 form-group">
                                                        <label>Last Name</label>
                                                        <input class="form-control" type="text" name="last_name"
                                                            placeholder="Last Name"
                                                            value="{{ old('last_name', $admin->last_name) }}" required>
                                                    </div>

                                                    <div class="col-sm-6 form-group">
                                                        <label>Email</label>
                                                        <input class="form-control" type="email" name="email"
                                                            placeholder="Email address"
                                                            value="{{ old('email', $admin->email) }}" required>
                                                    </div>
                                                    <div class="col-sm-6 form-group">
                                                        <label>Phone</label>
                                                        <input class="form-control" type="number" name="phone"
                                                            placeholder="Phone"
                                                            value="{{ old('phone', $admin->phone) }}">
                                                    </div>

                                                    <div class="col-sm-6 form-group">
                                                        <label>Password</label>
                                                        <input class="form-control" type="password" name="password"
                                                            placeholder="Password">
                                                    </div>
                                                    <div class="col-sm-6 form-group">
                                                        <label>Image</label>
                                                        <input class="form-control" type="file" name="image"
                                                            placeholder="Upload Image">
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
                <!-- END PAGE CONTENT-->

            </div>
        </div>
    </div>
</div>
@endsection