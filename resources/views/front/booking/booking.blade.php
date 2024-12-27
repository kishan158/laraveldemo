@extends('front.layout.app')
@section('content')

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

<div class="section">
    <div class="container p-5">
        <div class="row">
            <!-- Sidebar Section -->
            <div class="d-flex flex-column flex-shrink-0 p-3 bg-dark text-black "
                style="width: 250px;  border-radius:10px;">
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
                <div class="">
                    <div class="page-content fade-in-up">
                        <!-- Booking Header -->
                        <div class="alert user mt-0 d-flex justify-content-between align-items-center">
                            <h4>My Booking</h4>
                        </div>

                        <div class="tb-data">
                            @if($userOrders->count() > 0)
                            <div class="row">
                                @foreach($userOrders as $data)
                                @php
                                // Decode the 'cart' JSON data directly from the order
                                $cartItems = json_decode($data->cart, true) ?? [];
                                @endphp

                                @foreach($cartItems as $item)
                                @php
                                // Fetch package and service details
                                $package = \App\Models\Package::find($item['package_id']);
                                $packageName = $package ? $package->package : 'Package not found';

                                $service = $package ? \App\Models\Service::find($package->service_id) : null;
                                $serviceName = $service ? $service->service : 'Service not found';
                                $serviceImage = $service ? $service->image : null;
                                @endphp
                                <div class="col-md-12 mb-3">
                                    <div class="p-2" style="background-color: #F7F7F7; border-radius:10px;">

                                        <div class="card-body">
                                            <div class="row">
                                            <div class="col-6">
                                            <p class="card-text">{{ $data->order_id }}</p>
                                            <p class="card-text">{{ $serviceName }}</p>

                                            <p class="card-text"> {{ $packageName }}</p>
                                            <p class="card-text">Quantity: {{ $item['quantity'] ?? 1 }}</p>
                                            </div>
                                            <div class="col-6">
 
                                            <a href="{{ route('user.front.bill', $data->order_id) }}"
                                            class="btn btn-secondary">View Estimate</a>
                                                <p class="card-text" style="margin-top:10%;"><strong>Price:</strong>
                                                    ₹{{ number_format($data->total_price ?? 0, 2) }}</p>
                                                
                                           
                                            </div>
                                            </div>
                                           
                                          
                                           
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endforeach
                            </div>
                            @else
                            <div class="alert user1 text-center">
                                No bookings found.
                            </div>
                            @endif

                           
                        </div>
                        {{$userOrders->links('pagination::bootstrap-4') }}
                    </div>

                </div>

            </div>
        </div>
    </div>
    @endsection