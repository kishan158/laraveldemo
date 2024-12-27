<header class="header">
    <div class="page-brand">
        <a class="link" href="{{route('vendor.dashboard')}}">
            <span class="brand">OMAA
                <span class="brand-tip">COMPANY</span>
            </span>

        </a>
    </div>
    <div class="flexbox flex-1">
        <!-- START TOP-LEFT TOOLBAR-->
        <ul class="nav navbar-toolbar">
            <li>
                <a class="nav-link sidebar-toggler js-sidebar-toggler"><i class="ti-menu"></i></a>
            </li>
            <li>
                <form class="navbar-search" action="javascript:;">
                    <div class="rel">
                        <span class="search-icon"><i class="ti-search"></i></span>
                        <input class="form-control" placeholder="Search here...">
                    </div>
                </form>
            </li>
        </ul>
        <!-- END TOP-LEFT TOOLBAR-->
        <!-- START TOP-RIGHT TOOLBAR-->
        <ul class="nav navbar-toolbar">
           
           
            <li class="dropdown dropdown-notification">
                @if(Auth::guard('vendor')->check())
                @php
                $notifyVendor = App\Models\VendorOrder::where('notify_status', 0)->count();
                @endphp

                <a class="nav-link dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-bell" style="font-size:20px">
                        @if($notifyVendor > 0)
                        <span class="badge badge-pill badge-danger">
                            {{ $notifyVendor }}
                        </span>
                        @endif
                    </i>
                </a>
                @endif
                <ul class="dropdown-menu dropdown-menu-right dropdown-menu-media">
                    <li class="dropdown-menu-header">
                        <div>
                            <span><strong> New</strong> Notifications</span>
                        </div>
                    </li>
                    <li class="list-group list-group-divider scroller" data-height="240px" data-color="#71808f">
                        @if($notifyVendor > 0)
                        <!-- First notification: New Order -->
                        <a class="list-group-item" href="{{ route('vendor.vendor.markAsRead') }}">
                            <div class="media">
                                <div class="media-img">
                                    <span class="badge badge-success badge-big"><i class="fa fa-check"></i></span>
                                </div>
                                <div class="media-body">
                                    <div class="font-13">You have a new order</div>
                                    <small class="text-muted">Just now</small>
                                </div>
                            </div>
                        </a>
                        @else

                       
                   
                        <!-- No new notifications message -->
                        <a class="list-group-item">
                            <div class="media">
                                <div class="media-body">
                                    <div class="font-13">No new notifications</div>
                                    <small class="text-muted">You are all caught up!</small>
                                </div>
                            </div>
                        </a>
                        @endif
                    </li>
                </ul>
            </li>



            <li class="dropdown dropdown-user">
                <a class="nav-link dropdown-toggle link" data-toggle="dropdown">
                    
                @if(Auth::guard('vendor')->user()->image)
                <img src="{{ asset('storage/app/public/' .Auth::guard('vendor')->user()->image) }}" alt="Profile Image" class="" width="100">
            @endif
                
                    <span></span>Partner<i class="fa fa-angle-down m-l-5"></i></a>
                <ul class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{route('vendor.profile')}}"><i class="fa fa-user"></i>Profile</a>

                    <li class="dropdown-divider"></li>
                    <a class="dropdown-item" href="{{route('vendor.logout')}}"><i class="fa fa-power-off"></i>Logout</a>
                </ul>
            </li>
        </ul>
    </div>
</header>

<nav class="page-sidebar" id="sidebar">
    <div id="sidebar-collapse">
        <div class="admin-block d-flex">

            <div class="admin-info">
                <div class="font-strong">{{ Auth::guard('vendor')->user()->name }} {{ Auth::guard('vendor')->user()->last_name }}</div><small>Partner
                    Panel</small>
            </div>
        </div>
        <ul class="side-menu metismenu">
            <li>
                <a class="active" href="{{route('vendor.dashboard')}}"><i class="sidebar-item-icon fa fa-th-large"></i>
                    <span class="nav-label">Dashboard</span>
                </a>
            </li>
            <li class="heading">FEATURES</li>
            <!-- <li>
                        <a href="javascript:;"><i class="sidebar-item-icon fa fa-bookmark"></i>
                            <span class="nav-label">Service Provide</span><i class="fa fa-angle-left arrow"></i></a>
                        <ul class="nav-2-level collapse">
                            <li>
                                <a href="{{route('vendor.service.list')}}">All Service</a>
                            </li>
                           
                        </ul>
                    </li> -->
            <li>
                <a href="javascript:;"><i class="sidebar-item-icon ti-shopping-cart"></i>
                    <span class="nav-label">Manage Job</span><i class="fa fa-angle-left arrow"></i></a>
                <ul class="nav-2-level collapse">
                    <li>
                        <a href="{{route('vendor.service.order')}}">My Job</a>
                    </li>
                    <li>
                        <a href="{{route('vendor.order.history')}}">Job History</a>
                    </li>

                </ul>
            </li>
            <li>
                <a href="javascript:;"><i class="sidebar-item-icon ti-user"></i>
                    <span class="nav-label">Manage Finance</span><i class="fa fa-angle-left arrow"></i></a>
                <ul class="nav-2-level collapse">
                    <li>
                        <a href="{{route('vendor.wallet.balance')}}">Wallet</a>
                    </li>
                    <li>
                        <a href="{{route('vendor.wallet.rechargelist')}}">Recharge Recored</a>
                    </li>
                    <li>
                        <a href="{{route('vendor.finance')}}">Finance Details</a>
                    </li>
                   


                </ul>
            </li>


            <li>
                <a href="{{route('vendor.logout')}}"><i class="sidebar-item-icon fa fa-user"></i>
                    <span class="nav-label">Logout</span></a>

            </li>

        </ul>
    </div>
</nav>

<style>
    .nav-link .fa-bell {
    position: relative; /* This ensures the bell icon is the reference point for the badge */
}

.nav-link .fa-bell .badge {
    position: absolute; /* Positions the badge relative to the bell icon */
    top: -5px;  /* Adjusts the badge above the icon */
    right: -5px; /* Adjusts the badge to the right of the icon */
    padding: 2px 5px;
    font-size: 10px;
}

</style>
