<header class="sticky-top" style="background-color: #f7f7f7;">
    <nav class="navbar navbar-expand-lg navbar-light ">
        <div class="container">

            <a class="navbar-brand ms-auto" href="{{route('front.home')}}">
                <img src="{{ asset('storage/app/public/' . $title['logo']) }} " alt="Logo" class="logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling"
                aria-controls="offcanvasScrolling">
                <span class="navbar-toggler-icon"></span>
            </button>
            {{-- <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling">Enable body scrolling</button> --}}

            <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#electric">Electric </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('front.home')}}">Homes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#native">OMAA</a>
                    </li>
                </ul>

                <form class="d-flex me-3 position-relative ">
                    <input class="form-control es pe-5" type="search" placeholder=" Search for your location"
                        aria-label="Search">
                    <button type="submit" class="btn btn-search-icon">
                        <i class="fa fa-map-marker" aria-hidden="true"></i></i>
                    </button>
                </form>
                <form class="d-flex me-3 position-relative locate">
                    <input class="form-control es pe-5" type="search" placeholder="Search for" aria-label="Search">
                    <button type="submit" class="btn btn-search-icon">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </button>
                </form>

                {{-- <span class="me-3"><i class="fa fa-cart-arrow-down" aria-hidden="true"></i></span> --}}
                <!-- User Icon with Dropdown -->
                <div class="dropdown">
                    <!-- User Icon -->
                    <span class="ms-3" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                    </span>

                    <!-- Dropdown Menu -->
                    <ul class="dropdown-menu" aria-labelledby="userDropdown">
                        <!-- Name Field -->
                        @if(Auth::check())
                        <li>
                            <div class="dropdown-item">
                                <label for="userName" class="form-label">{{ auth()->user()->name }}</label>
                            </div>
                        </li>

                        <!-- Email Field -->
                        <li>
                            <div class="dropdown-item">
                                <label for="userEmail" class="form-label">{{ auth()->user()->email }}</label>
                            </div>
                        </li>

                        <!-- My Booking Link -->
                        <li>
                            <div class="dropdown-item">
                                <a href="{{ route('user.front.dashboard') }}" class="form-label">My Booking</a>
                            </div>
                        </li>

                        <!-- Logout Button -->
                        <li>
                            <div class="dropdown-item">
                                <a href="{{ route('front.user.logout') }}" class="btn btn-danger">Logout</a>
                            </div>
                        </li>
                        @else
                        <!-- Login Link -->
                        <li>
                            <div class="dropdown-item">
                                <a href="{{ route('user.login') }}" class="form-label">Login</a>
                            </div>
                        </li>
                        @endif
                    </ul>

                </div>


            </div>
        </div>
    </nav>

</header>


{{-- mobile --}}
<div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1"
    id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasScrollingLabel">Menu</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul style="list-style-type: none;padding: 0;">
            <li class="nav-item1">
                <a class="nav-link1" aria-current="page" href="#electric">Electric </a>
            </li>
            <li class="nav-item1">
                <a class="nav-link1" href="{{route('front.home')}}">Homes</a>
            </li>
            <li class="nav-item1">
                <a class="nav-link1" href="#native">OMAA</a>
            </li>
        </ul>

        <form class="d-flex position-relative ">
            <input class="form-control es pe-5" type="search" placeholder=" Search for your location"
                aria-label="Search">
            <button type="submit" class="btn btn-search-icon">
                <i class="fa fa-map-marker" aria-hidden="true"></i></i>
            </button>
        </form>
        <form class="d-flex  position-relative locate">
            <input class="form-control es pe-5" type="search" placeholder="Search for" aria-label="Search">
            <button type="submit" class="btn btn-search-icon">
                <i class="fa fa-search" aria-hidden="true"></i>
            </button>
        </form>

        <div class="dropdown">
            <!-- User Icon -->
            <span class="ms-3" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-user-circle-o" aria-hidden="true"></i>
            </span>

            <!-- Dropdown Menu -->
            <ul class="dropdown-menu" aria-labelledby="userDropdown">
                <!-- Name Field -->
                <li>
                    <div class="dropdown-item">
                        <label for="userName" class="form-label">{{ auth()->user()->name ?? '' }}</label>
                    </div>
                </li>

                <!-- Email Field -->
                <li>
                    <div class="dropdown-item">
                        <label for="userEmail" class="form-label">{{ auth()->user()->email ?? '' }}</label>
                    </div>
                </li>

                <!-- Logout Button (only if the user is logged in) -->
                @if(Auth::check())
                <li>
                    <div class="dropdown-item">
                        <a href="{{ route('user.front.dashboard') }}"><label for="userEmail" class="form-label">My
                                Booking</label></a>
                    </div>
                </li>
                <li>
                    <div class="dropdown-item">
                        <a href="{{ route('front.user.logout') }}" class="btn btn-danger">Logout</a>
                    </div>
                </li>


                @endif
            </ul>
        </div>

    </div>
</div>
</div>

<style>
a.nav-link1 {
    color: black;
    text-decoration: none;
    font-size: 20px;
}

li.nav-item1 {
    padding-bottom: 11px;
}

button.navbar-toggler {
    position: absolute;
}
</style>