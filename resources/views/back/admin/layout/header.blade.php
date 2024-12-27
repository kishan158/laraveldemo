<header class="header">
    <div class="page-brand">
        <a class="link" href="{{route('admin.dashboard')}}">
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
            <li class="dropdown dropdown-inbox">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope-o"></i>
                    <span class="badge badge-primary envelope-badge">9</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-right dropdown-menu-media">
                    <li class="dropdown-menu-header">
                        <div>
                            <span><strong>New</strong> Messages</span>
                            <a class="pull-right" href="mailbox.html">view all</a>
                        </div>
                    </li>
                    <li class="list-group list-group-divider scroller" data-height="240px" data-color="#71808f">
                        <div>
                            <a class="list-group-item">
                                <div class="media">
                                    <div class="media-img">
                                        <img src="./assets/img/users/u1.jpg" />
                                    </div>
                                    <div class="media-body">
                                        <div class="font-strong"> </div>Jeanne Gonzalez<small
                                            class="text-muted float-right">Just now</small>
                                        <div class="font-13">Your proposal interested me.</div>
                                    </div>
                                </div>
                            </a>
                            <a class="list-group-item">
                                <div class="media">
                                    <div class="media-img">
                                        <img src="./assets/img/users/u2.jpg" />
                                    </div>
                                    <div class="media-body">
                                        <div class="font-strong"></div>Becky Brooks<small
                                            class="text-muted float-right">18 mins</small>
                                        <div class="font-13">Lorem Ipsum is simply.</div>
                                    </div>
                                </div>
                            </a>
                            <a class="list-group-item">
                                <div class="media">
                                    <div class="media-img">
                                        <img src="./assets/img/users/u3.jpg" />
                                    </div>
                                    <div class="media-body">
                                        <div class="font-strong"></div>Frank Cruz<small
                                            class="text-muted float-right">18 mins</small>
                                        <div class="font-13">Lorem Ipsum is simply.</div>
                                    </div>
                                </div>
                            </a>
                            <a class="list-group-item">
                                <div class="media">
                                    <div class="media-img">
                                        <img src="./assets/img/users/u4.jpg" />
                                    </div>
                                    <div class="media-body">
                                        <div class="font-strong"></div>Rose Pearson<small
                                            class="text-muted float-right">3 hrs</small>
                                        <div class="font-13">Lorem Ipsum is simply.</div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </li>
                </ul>
            </li>
            <li class="dropdown dropdown-notification">
                @if(Auth::guard('admin')->check())
                @php
                $notificationAdmin = App\Models\Order::where('notify_status', 0)->count();
                $notificationVendor = App\Models\Vendor::where('notify_status', 0)->count();
                $notificationWidthraw = App\Models\WidthrawRequest::where('notify_status', 0)->count();
                $totalNotifications = $notificationAdmin + $notificationVendor + $notificationWidthraw;
                @endphp

                <a class="nav-link dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-bell" style="font-size:20px">
                        @if($totalNotifications > 0)
                        <span class="badge badge-pill badge-danger">
                            {{ $totalNotifications }}
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
                        @if($notificationAdmin > 0)
                        <!-- First notification: New Order -->
                        <a class="list-group-item" href="{{ route('admin.order.markAsRead') }}">
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
                        @endif

                        @if($notificationVendor > 0)
                        <!-- Second notification: New Partner Register -->
                        <a class="list-group-item" href="{{ route('admin.vendor.markAsRead') }}">
                            <div class="media">
                                <div class="media-img">
                                    <span class="badge badge-success badge-big"><i class="fa fa-check"></i></span>
                                </div>
                                <div class="media-body">
                                    <div class="font-13">You have a new partner registration</div>
                                    <small class="text-muted">Just now</small>
                                </div>
                            </div>
                        </a>
                        @endif

                        @if($notificationWidthraw > 0)
                        <!-- Second notification: New Partner Register -->
                        <a class="list-group-item" href="{{ route('admin.widthraw.markAsRead') }}">
                            <div class="media">
                                <div class="media-img">
                                    <span class="badge badge-success badge-big"><i class="fa fa-check"></i></span>
                                </div>
                                <div class="media-body">
                                    <div class="font-13">You have a New Widthdraw Request</div>
                                    <small class="text-muted">Just now</small>
                                </div>
                            </div>
                        </a>
                        @endif

                        @if($totalNotifications == 0)
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
                    @if(Auth::guard('admin')->user()->image)
                    <img src="{{ asset('storage/app/public/' .Auth::guard('admin')->user()->image) }}"
                        alt="Profile Image" class="" width="100">
                    @endif
                    <span></span>Admin<i class="fa fa-angle-down m-l-5"></i></a>
                <ul class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{route('admin.profile')}}"><i class="fa fa-user"></i>Profile</a>

                    <li class="dropdown-divider"></li>
                    <!-- <a class="dropdown-item" href="login.html"><i class="fa fa-power-off"></i>Logout</a> -->
                </ul>
            </li>
        </ul>
        <!-- END TOP-RIGHT TOOLBAR-->
    </div>
</header>

<nav class="page-sidebar" id="sidebar">
    <div id="sidebar-collapse">
        <div class="admin-block d-flex">

            <div class="admin-info">
                <div class="font-strong">{{ $admin->name ?? '' }} </div><small>Admin Panel</small>
            </div>
        </div>
        <ul class="side-menu metismenu">
            <li>
                <a class="active" href="{{route('admin.dashboard')}}"><i class="sidebar-item-icon fa fa-th-large"></i>
                    <span class="nav-label">Dashboard</span>
                </a>
            </li>
            <li class="heading">FEATURES</li>
            <li>
                <a href="javascript:;"><i class="sidebar-item-icon fa fa-bookmark"></i>
                    <span class="nav-label">Manage Category</span><i class="fa fa-angle-left arrow"></i></a>
                <ul class="nav-2-level collapse">
                    <li>
                        <a href="{{route('admin.category.list')}}"> Category</a>
                    </li>


                </ul>
            </li>
            <!-- <li>
                <a href="javascript:;"><i class="sidebar-item-icon ti-pencil-alt"></i>
                    <span class="nav-label">Manage Product</span><i class="fa fa-angle-left arrow"></i></a>
                <ul class="nav-2-level collapse">
                    <li>
                        <a href="{{route('admin.Subcategory.list')}}">Product Category</a>
                    </li>
                    <li>
                        <a href="{{route('admin.product.list')}}"> Product</a>
                    </li>


                </ul>
            </li> -->
            <li>
                <a href="javascript:;"><i class="sidebar-item-icon fa fa-user"></i>
                    <span class="nav-label">Partner</span><i class="fa fa-angle-left arrow"></i></a>
                <ul class="nav-2-level collapse">
                    <li>
                        <a href="{{route('admin.vendor.list')}}">All Partner</a>
                    </li>

                </ul>
            </li>
            <li>
                <a href="javascript:;"><i class="sidebar-item-icon fa fa-gear"></i>
                    <span class="nav-label">Manage Service</span><i class="fa fa-angle-left arrow"></i></a>
                <ul class="nav-2-level collapse">
                    <li>
                        <a href="{{route('admin.service.list')}}">Service</a>
                    </li>

              

                </ul>
            </li>

            <li>
                <a href="javascript:;"><i class="sidebar-item-icon ti-bag"></i>
                    <span class="nav-label">Manage Order</span><i class="fa fa-angle-left arrow"></i></a>
                <ul class="nav-2-level collapse">
                    <li>
                        <a href="{{route('admin.order')}}">Order</a>
                    </li>
                    <li>
                        <a href="{{route('admin.order.history')}}">Order History</a>
                    </li>


                </ul>
            </li>

            <li>
                <a href="javascript:;"><i class="sidebar-item-icon ti-wallet"></i>
                    <span class="nav-label">Manage Wallet</span><i class="fa fa-angle-left arrow"></i></a>
                <ul class="nav-2-level collapse">
                    <li>
                        <a href="{{route('admin.qr_code')}}">QR Code</a>
                    </li>
                    <li>
                        <a href="{{route('admin.recharge.request')}}">Recharge Request</a>
                    </li>

                    <li>
                        <a href="{{route('admin.widthraw.request')}}">Widthraw Request</a>
                    </li>


                </ul>
            </li>
            <li>
                <a href="javascript:;"><i class="sidebar-item-icon ti-align-justify"></i>
                    <span class="nav-label">Manage Site</span><i class="fa fa-angle-left arrow"></i></a>
                <ul class="nav-2-level collapse">
                    <li>
                        <a href="{{route('admin.front.home')}}">Home</a>
                    </li>
                    <li>
                        <a href="{{route('admin.back.page')}}">Page</a>
                    </li>


                </ul>
            </li>
            <li>
                <form action="{{ route('admin.logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-link p-0"
                        style="border: none; background: none; cursor: pointer; color:white;margin-left: 5px">
                        <i class="fa fa-user"></i> Logout
                    </button>
                </form>
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