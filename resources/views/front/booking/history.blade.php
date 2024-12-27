@extends('front.layout.app')
@section('content')
<div class="section">
    <div class="container p-5">
        <div class="row">
            <!-- Sidebar Section -->
            <div class="d-flex flex-column flex-shrink-0 p-3 bg-dark text-black "
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



            <!-- Main Content Section -->
            <div class="col">
                <div class="p-4">
                    <div class="page-content fade-in-up">
                        <!-- Booking Header -->
                        <div class="alert user d-flex justify-content-between align-items-center">
                            <h4>MyBooking History</h4>
                        </div>

                        @if($userOrders->count() > 0)
                          <div class="container">
                            @forelse($userOrders as $data)
                            @if ($data->order)
                            @php
                            $cartItems = json_decode($data->order->cart, true);
                            @endphp

                            @foreach($cartItems as $item)
                            @php
                            $package = \App\Models\Package::find($item['package_id']);
                            $packageName = $package ? $package->package : 'Package not found';

                            $service = $package ? \App\Models\Service::find($package->service_id) : null;
                            $serviceName = $service ? $service->service : 'Service not found';
                            @endphp

                            <div class=" mb-4 p-3  col-12" style="background-color: #F7F7F7; border-radius:10px;">
                                <div class="d-flex justify-content-between align-items-start">
                                    <!-- Left Section -->
                                    <div>
                                        <h5 class="mb-2"> {{ $data->order_id ?? '' }}</h5>
                                        <div><strong>Service:</strong> {{ $serviceName }}</div>
                                        <div><strong>Package:</strong> {{ $packageName }}</div>
                                        <!-- <div><strong>Quantity:</strong> {{ $item['quantity'] ?? 1 }}</div> -->
                                    </div>

                                    <!-- Right Section: Status and View Button -->
                                    <div class="text-end">
                                        <div class="mb-3">
                                            @if ($data->status == 2)
                                            <button class="btn btn-danger btn-sm">Rejected</button>
                                            @elseif ($data->status == 3)
                                            <button class="btn btn-success btn-sm">Done</button>
                                            @else
                                            <button class="btn btn-secondary btn-sm">Pending</button>
                                            @endif
                                        </div>
                                        <a href="{{ route('user.front.bill', $data->order_id) }}"
                                            class="btn btn-info btn-sm">View</a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif
                            @empty
                            <div class="alert alert-warning text-center">
                                No bookings found.
                            </div>
                            @endforelse
                         </div>
                         @endif

                         {{$userOrders->links('pagination::bootstrap-4') }}
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