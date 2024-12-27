@extends('front.layout.app')
@section('content')

<div class="section">
    <div class="container p-5">
        <div class="row">
            <div class="d-flex flex-column flex-shrink-0 p-3 bg-dark text-black"
                style="width: 250px;  border-radius: 10px;">
                <a href="" class="text-decoration-none text-black mb-3">
                    <span class="fs-4">Dashboard</span>
                </a>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="{{route('user.front.dashboard')}}"
                            class="nav-link text-black {{ Request::is('dashboard') ? 'active' : '' }}">
                            <i class="bi bi-house-door"></i> Home
                        </a>
                    </li>
                    <li>
                        <a href="{{route('user.front.booking')}}"
                            class="nav-link text-black {{ Request::is('products*') ? 'active' : '' }}">
                            <i class="bi bi-box"></i> Booking
                        </a>
                    </li>
                    <li>
                        <a href="{{route('user.front.order.history')}}"
                            class="nav-link text-black {{ Request::is('orders*') ? 'active' : '' }}">
                            <i class="bi bi-cart"></i> Orders
                        </a>
                    </li>
                    <li>
                        <a href="{{route('user.front.profile')}}"
                            class="nav-link text-black {{ Request::is('users*') ? 'active' : '' }}">
                            <i class="bi bi-people"></i> Users
                        </a>
                    </li>
                    <li>
                        <a href="{{route('user.front.wallet')}}"
                            class="nav-link text-black {{ Request::is('wallet*') ? 'active' : '' }}">
                            <i class="bi bi-people"></i> Wallet
                        </a>
                    </li>
                    <li>
                    <a href="{{route('user.front.widthrawHistory')}}"
                        class="nav-link text-black {{ Request::is('Widthraw*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i>Widthraw History
                    </a>
                </li>
                    <li>
                        <a href="{{route('user.front.setting')}}"
                            class="nav-link text-black {{ Request::is('settings') ? 'active' : '' }}">
                            <i class="bi bi-gear"></i> Settings
                        </a>
                    </li>
                </ul>
                <hr>
                <a href="{{ route('front.user.logout') }}" class="btn btn-danger">Logout</a>
            </div>

            <!-- Main Content -->
            <div class="col">
                <div class="p-4">
                    <div class="page-content fade-in-up">
                        <div class="alert user  d-flex justify-content-between align-items-center">
                            <h4>Widthdraw Balance </h4><br>
                            <p>Total Balance: <span><strong>₹ {{ $totalBalance }}.00</strong></span></p>

                        </div>

                        <div class="profile page-content fade-in-up mb-4">
                            <div class="container p-3" style="background-color: #F7F7F7; border-radius:10px;">
                                <div class="row">
                                    @if(!is_null($data))
                                    <form action="{{ route('user.front.widthdraw.request') }}" method="POST"
                                        class="w-100">
                                        @csrf
                                        <div class="row w-100">
                                            <div class="col-md-6 mb-3">
                                                <label for="bank_ifsc" class="form-label">Choose Bank Account</label>
                                                <select class="form-control" id="bank_ifsc" name="account_no" required>
                                                    <option value="">Select Bank</option>
                                                    <option value="{{ $data->account_no ?? '' }}">
                                                        {{ $data->account_no ?? '' }}
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="amount" class="form-label">Amount</label>
                                                <input type="number" class="form-control" id="amount" name="amount"
                                                    placeholder="Enter Amount" min="500" required>
                                                <small class="text-muted">Minimum withdrawal amount is 500.</small>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                    @else
                                    <p class="text-muted">Complete your KYC to withdraw balance.</p> @endif
                                </div>
                            </div>
                        </div>


                        <div class=" profile page-content fade-in-up mb-4">
                            <div class="container p-3" style="background-color: #F7F7F7; border-radius:10px;">
                                <div class="row">
                                    <form action="{{ route('user.front.kyc') }}" method="POST" class="w-100">
                                        @csrf
                                        <div class="row w-100">
                                            <!-- Name Field -->
                                            <div class="col-md-4 mb-3">
                                                <label for="name" class="form-label">Name</label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                    value="{{ $data->name ?? '' }}" placeholder="Enter Your Name"
                                                    required>
                                            </div>

                                            <!-- PAN Number Field -->
                                            <div class="col-md-4 mb-3">
                                                <label for="pan_no" class="form-label">Pan No</label>
                                                <input type="text" class="form-control" id="pan_no" name="pan_no"
                                                    value="{{ $data->pan_no ?? '' }}" placeholder="Enter Pan Card No"
                                                    required>
                                            </div>

                                            <!-- Aadhaar Number Field -->
                                            <div class="col-md-4 mb-3">
                                                <label for="adhar_no" class="form-label">Aadhar No</label>
                                                <input type="text" class="form-control" id="adhar_no" name="adhar_no"
                                                    value="{{ $data->adhar_no ?? '' }}"
                                                    placeholder="Enter Your Aadhar No" required>
                                            </div>

                                            <!-- Bank Name Field -->
                                            <div class="col-md-4 mb-3">
                                                <label for="bank_name" class="form-label">Bank Name</label>
                                                <input type="text" class="form-control" id="bank_name" name="bank_name"
                                                    value="{{ $data->bank_name ?? '' }}"
                                                    placeholder="Enter Your Bank Name" required>
                                            </div>

                                            <!-- Account Number Field -->
                                            <div class="col-md-4 mb-3">
                                                <label for="account_no" class="form-label">Account Number</label>
                                                <input type="text" class="form-control" id="account_no"
                                                    name="account_no" value="{{ $data->account_no ?? '' }}"
                                                    placeholder="Enter Account Number" required>
                                            </div>

                                            <!-- Bank Branch Field -->
                                            <div class="col-md-4 mb-3">
                                                <label for="bank_branch" class="form-label">Bank Branch</label>
                                                <input type="text" class="form-control" id="bank_branch"
                                                    name="bank_branch" value="{{ $data->bank_branch ?? '' }}"
                                                    placeholder="Enter Bank Branch" required>
                                            </div>

                                            <!-- IFSC Code Field -->
                                            <div class="col-md-4 mb-3">
                                                <label for="bank_ifsc" class="form-label">IFSC CODE</label>
                                                <input type="text" class="form-control" id="bank_ifsc" name="bank_ifsc"
                                                    value="{{ $data->bank_ifsc ?? '' }}"
                                                    placeholder="Enter Bank IFSC CODE" required>
                                            </div>
                                        </div>

                                        <!-- Submit Button -->
                                        <button type="submit" class="btn btn-primary">KYC Submit</button>
                                    </form>

                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
    .user {
        color: black;
        background-color: #F7F7F7;
        border-radius: 10px;
        padding: 24px 20px;
        text-align: center;
        border: none;
        cursor: pointer;
        display: inline-block;
        transition: background-color 0.3s ease;
        margin-top: -23px;
    }

    .bg-dark {
        --bs-bg-opacity: 1;
        background-color: #F7F7F7 !important;
        color: black;
    }

    .section {
        background: #ffffff;
    }

    .user1 {
        color: white;
        background-color: #607d8b;
        border-radius: 8px;
        padding: 1px 10px;
        margin-top: 10px;
    }

    .user1:hover {
        background-color: #384a52;
    }

    .tb-data {
        padding: 21px;
        background: white;
        border-radius: 4px;
    }

    a.nav-link {
        padding: 5px 22px !important;
        font-size: 15px;
    }
    </style>

    @endsection