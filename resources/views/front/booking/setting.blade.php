@extends('front.layout.app')
@section('content')
<div class="section">
    <div class="container p-5">
<div class="row">
    <div class="d-flex flex-column flex-shrink-0 p-3 bg-dark text-black " style="width: 250px;">
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
                    <h4>User Setting</h4>


                </div>
                <div class=" profile page-content fade-in-up mb-4">
                    <div class="container p-3" style="background-color: #F7F7F7; border-radius:10px;">
                    <div class="row">
                        <form action="{{ route('user.front.settingPassword') }}" method="POST" class="w-100">
                            @csrf
                            <div class="row w-100">
                                <!-- New Password Field -->
                                <div class="col-md-3 mb-3">
                                    <label for="newPassword" class="form-label">New Password</label>
                                    <input type="password" class="form-control" id="newPassword" name="new_password"
                                        placeholder="Enter New Password" required>

                                </div>

                                <!-- Confirm Password Field -->
                                <div class="col-md-3 mb-3">
                                    <label for="confirmPassword" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" id="confirmPassword"
                                        name="new_password_confirmation" placeholder="Confirm New Password" required>

                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary">Change Password</button>
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