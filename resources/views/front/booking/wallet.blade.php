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
                        <div
                            class="alert user d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                            <div class="text-left">
                                <h4>My Wallet</h4>

                            </div>
                            <div class="d-flex">

                                <a href="{{ route('user.front.widthdraw') }}" class="btn btn-light"
                                    style="background-color: #d8dcdd;">Withdraw</a>
                            </div>

                        </div>

                        <div class="profile page-content fade-in-up">
                            <div class="container p-3" style="background-color: #F7F7F7; border-radius:10px;">
                                <div class="row">
                                    <div class="alert user d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                                    <p>Balance: <span><strong>₹ {{ $totalBalance }}.00</strong></span></p>
                                    <div>
                                    Your Invitation Code is
                                        <a href="#" style="text-decoration:none;"> {{$invite_code->invite_code ?? ''}}</a>

                                       
                                        <button onclick="copyInviteURL()" class="btn btn-light"
                                        style="background-color: #d8dcdd;">Share</button>
                                    </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>

                        <div class="profile page-content fade-in-up mb-4">
                            <div class="container p-3">
                                <div class="row">

                                    @foreach($records as $record)
                                    @if(!is_null($record->credit))
                                    <div class="col-md-12 mb-3 p-2"
                                        style="background-color: #F7F7F7; border-radius:10px;">
                                        <!-- Add a margin-bottom for spacing -->
                                        <div class="row w-100">
                                            <div class="flex-md-row justify-content-between align-items-md-center">
                                                <label for="inputField1" class="form-label"> Credit :<span><strong>₹
                                                            {{ $record->credit }}</strong> </span></label>

                                                <label for="inputField1" class="form-label">Date :<span><strong>
                                                            {{ $record->created_at->format('d-m-Y') }}</strong>
                                                    </span></label>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @endforeach


                                    @foreach($records as $record)
                                    @if($record->debit != 0.00)
                                    <div class="col-md-12 mb-3 p-2"
                                        style="background-color: #F7F7F7; border-radius:10px;">
                                        <!-- Add a margin-bottom for spacing -->
                                        <div class="row w-100">
                                            <div class="col-md-4 mb-3">
                                                <label for="inputField1" class="form-label"> Debit :<span><strong>₹
                                                            {{ $record->debit }}</strong> </span></label>

                                                <label for="inputField1" class="form-label">Date :<span><strong>
                                                            {{ $record->created_at->format('d-m-Y') }}</strong>
                                                    </span></label>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @endforeach


                                </div>

                            </div>
                        </div>

                        {{ $records->links('pagination::bootstrap-4') }}

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
    <script>
    function copyInviteURL() {
        // Define the base app URL
        const appUrl = "{{ url('/') }}";

        // Define the invitation code
        const inviteCode = "{{$invite_code->invite_code ?? ''}}";

        // Construct the full URL
        const inviteUrl = `${appUrl}/user/register/${inviteCode}`;

        // Copy the URL to clipboard
        navigator.clipboard.writeText(inviteUrl)
            .then(() => {
                alert('Invitation URL copied to clipboard!');
            })
            .catch(err => {
                alert('Failed to copy the URL: ' + err);
            });
    }
    </script>

    @endsection