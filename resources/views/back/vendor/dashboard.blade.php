@extends('back.vendor.layout.app')
@section('content')



<div class="page-content fade-in-up">

    <div class="col-lg-12 col-md-12 p-0">
        <div class="ibox bg-secondary color-white widget-stat">
            <div class="ibox-body">
                <h2 id="greeting" class="m-b-5 font-strong"></h2> <!-- Dynamic Greeting Here -->
                <div class="m-b-5"></div><i class="fa fa-clock widget-stat-icon">
                    <form method="POST" action="{{ route('vendor.dashboard.status') }}">
                        @csrf

                        <div class="form-group" style="margin-top:45%;">
                            @if($availabilityStatus == 'Available')
                            <!-- Ensure availability status is compared properly -->
                            <!-- Online Button, only show if current status is 0 (Offline) -->
                            @if($currentStatus !== 1)
                            <button type="submit" name="status" value="1" class="btn btn-light btn-sm mr-2">
                                Online
                            </button>
                            @endif

                            <!-- Offline Button, only show if current status is 1 (Online) -->
                            @if($currentStatus !== 0)
                            <button type="submit" name="status" value="0" class="btn btn-danger btn-sm">
                                Offline
                            </button>
                            @endif
                            @endif
                        </div>

                    </form>
                </i> <!-- Watch Icon -->
                <div><i class="fa fa-level-up m-r-5"></i><small id="timeOfDay"></small></div> <!-- Time of Day -->
                <div><i class="fa fa-clock m-r-5"></i><small id="currentTime"></small></div>
                <!-- Current Time -->
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 col-md-6">
            <div class="ibox bg-Silver color-black widget-stat">
                <div class="ibox-body">
                    <h2 class="m-b-5 font-strong"><strong>{{now()->format('l,F j')}}</strong></h2>
                    <div class="m-b-5"></div>
                    <div class="m-b-5">
                        {{ now()->format(' Y') }}
                        <!-- Example: Friday, November 22, 2024 -->
                    </div>
                    <i class="ti-calendar widget-stat-icon"></i>

                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-6">
            <div class="ibox bg-Silver color-black widget-stat" style="height:86px;">
                <div class="ibox-body ">
                    <div class="row">
                        <div class="col-3">
                            <h4>
                                <span class="{{ $availabilityStatus == 'Available' ? 'text-success' : 'text-danger' }}">
                                @if($availabilityStatus == 'Available')     @if($currentStatus !== 0) <i class="fa fa-circle text-success"
                                        style="font-size: 10px; margin-right: 5px;">Online</i> @endif  @endif
                                    {{ $availabilityStatus }}
                                  
                                </span>
                            </h4>
                            @if($partnerAvailable) 
    {{ \Carbon\Carbon::parse($partnerAvailable->date)->format('d-m-Y') }} 
@endif
                        </div>
                        <div class="col-9 ">


                            <form method="POST" action="{{ route('vendor.dashboard.AvaliblitySubmit') }}"
                                class="d-flex">
                                @csrf
                                <div class="form-group mr-3">
                                    <label for="dateInput" class="form-label">Select Date:</label>
                                    <input type="date" name="date" id="dateInput" class="form-control" required>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-secandory btn-sm"
                                    style="padding: 0px 10px;">Add</button>
                            </form>





                        </div>

                        <i class="ti-calendar widget-stat-icon"></i>
                    </div>


                </div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="ibox bg-Silver color-black widget-stat">
                <div class="ibox-body">
                    <h2 class="m-b-5 font-strong">{{$orderCount }}</h2>
                    <div class="m-b-5">Total Job</div><i class="ti-shopping-cart widget-stat-icon"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <a href="{{route('vendor.order.history')}}">
                <div class="ibox bg-Silver color-black widget-stat">
                    <div class="ibox-body">
                        <h2 class="m-b-5 font-strong">{{$orderComplete }}</h2>
                        <div class="m-b-5">Complete Job</div><i class="ti-bar-chart widget-stat-icon"></i>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="ibox bg-Silver color-black widget-stat">
                <div class="ibox-body">
                    <h2 class="m-b-5 font-strong">$1570</h2>
                    <div class="m-b-5">TOTAL INCOME</div><i class="fa fa-money widget-stat-icon"></i>

                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <a href="{{route('vendor.service.order')}}">
                <div class="ibox bg-Silver color-black widget-stat">
                    <div class="ibox-body">
                        <h2 class="m-b-5 font-strong">{{$orderPending }}</h2>
                        <div class="m-b-5">New Job</div><i class="ti-user widget-stat-icon"></i>
                    </div>
                </div>
            </a>
        </div>
    </div>



    <style>
    .visitors-table tbody tr td:last-child {
        display: flex;
        align-items: center;
    }

    .visitors-table .progress {
        flex: 1;
    }

    .visitors-table .progress-parcent {
        text-align: right;
        margin-left: 10px;
    }
    </style>

</div>
<script>
window.onload = function() {
    // Time-based greeting
    var today = new Date();
    var hour = today.getHours();
    var greetingMessage = '';
    var timeOfDay = '';

    // Determine greeting based on the time of day
    if (hour < 12) {
        greetingMessage = 'Good Morning {{ Auth::guard("vendor")->user()->name }}, Here\'s What\'s Next';
        timeOfDay = 'Morning';
    } else if (hour < 18) {
        greetingMessage = 'Good Afternoon {{ Auth::guard("vendor")->user()->name }}, Here\'s What\'s Next';
        timeOfDay = 'Afternoon';
    } else {
        greetingMessage = 'Good Evening {{ Auth::guard("vendor")->user()->name }}, Here\'s What\'s Next';
        timeOfDay = 'Evening';
    }

    // Display the greeting and time of day
    document.getElementById('greeting').innerText = greetingMessage;
    document.getElementById('timeOfDay').innerText = timeOfDay;

    // Function to update and display the current time
    function updateCurrentTime() {
        var currentTime = new Date();
        var hours = currentTime.getHours().toString().padStart(2, '0');
        var minutes = currentTime.getMinutes().toString().padStart(2, '0');
        var seconds = currentTime.getSeconds().toString().padStart(2, '0');
        var formattedTime = hours + ':' + minutes + ':' + seconds;

        document.getElementById('currentTime').innerText = formattedTime;
    }

    // Call the function to update the current time initially
    updateCurrentTime();

    // Update the time every second
    setInterval(updateCurrentTime, 1000); // Update every 1000ms (1 second)
};
</script>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

@endsection

