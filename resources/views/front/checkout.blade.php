@extends('front.layout.app')
@section('content')
    <style>
        .frequently-added-carousel .item {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px;
        }

        input[type="email"] {
            width: 100%;
            height: 40px;
            border-radius: 5px;
            border: 1px solid gainsboro;
        }

        .card {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            width: 225px;
            text-align: center;
            padding: 10px;
        }


        .card-content h4 {
            font-size: 16px;
            margin: 10px 0 5px;
            color: #333;
        }

        .card-content p {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }

        .add-button {
            border-radius: 5px;
            padding: 3px 17px;
            color: #350b87;
            font-weight: bold;
            margin-left: -16px;
        }

        .owl-prev,
        .owl-next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: #ffffff;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: #333;
            cursor: pointer;
            border: 1px solid #ddd;
        }

        .owl-prev {
            left: -20px;
            border: 1px solid !important;
        }

        .owl-next {
            right: -4px;
            border: 1px solid !important;
        }

        .login-card {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 15px;
        }

        .ac {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .srp-label {
            flex: 1;
            font-weight: bold;
            color: #555;
        }

        .srp-input {
            flex: 2;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            outline: none;
            width: 100%;
            max-width: 200px;
        }

        .srp-input:focus {
            border-color: #007bff;
        }

        .btn-div {
            text-align: center;
            margin-top: 20px;
        }

        .login-btn1 {
            background-color: green;
            color: #fff;
            padding: 10px 15px;
            border-radius: 59px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .login-btn1:hover {
            background-color: #0056b3;
        }
    </style>
    <div class="container">
        <div class="row">
            @if (Auth::check())
                <!-- Content for logged-in users -->
                <div class="col-lg-6 col-md-6 col-sm-6 stick">
                    <p class="saving">Share and Earn Every Refer! Your Invite Code:
                        <strong>{{ Auth::user()->invite->invite_code ?? 'N/A' }}</strong></p>

                    <div class="login-card">
                        <h6 class="ac">User Details</h6>

                        <!-- Phone Number -->
                        <form action="{{ route('front.user.order') }}" method="post">
                            @csrf

                            <!-- Name Field -->
                            <div class="detail-item">
                                <label class="srp-label">Name:</label>
                                <input class="srp-input" type="text" name="name" placeholder="Enter Your Name" required>
                            </div>

                            <!-- Phone Field -->
                            <div class="detail-item">
                                <label class="srp-label">Phone:</label>
                                <input class="srp-input" type="text" name="phone" placeholder="Enter Your Number" required>
                            </div>

                            <label class="srp-label">Address:</label>
                            <div class="detail-item"
                                style="display: flex;gap: 10px;align-content: flex-end;flex-direction: column;flex-wrap: wrap;justify-content: flex-end;">

                                <input name="house_flat_number" class="srp-input" type="text"
                                    placeholder="House/Building/Flat No*" required>
                                <select name="city" class="srp-input" required>
                                    <option value="">Select City</option>
                                    <option value="Noida">Noida</option>
                                    <option value="Greater Noida">Greater Noida</option>
                                </select>
                                <input name="pin_code" class="srp-input" type="text" placeholder="Pin Code" required>
                                <input name="landmark" class="srp-input" type="text" placeholder="Landmark:(optional)">
                            </div>



                            <!-- Date Field -->
                            <div class="detail-item">
                                <label class="srp-label">Date:</label>
                                <input class="srp-input" type="date" name="date" value="" required>
                            </div>

                            <!-- Time Field -->
                            <div class="detail-item">
                                <label class="srp-label">Time Slot:</label>
                                <input class="srp-input" type="time" name="time" value="" required>
                            </div>

                            <!-- Cart Items (Hidden inputs for each cart item) -->
                            @if (!empty($cart))
                                @foreach ($cart as $item)
                                    <input type="hidden" name="cart_items[]" value="{{ json_encode($item) }}">
                                @endforeach
                            @endif

                            <br>

                            <!-- Submit Button -->
                            <button type="submit" class="login-btn1">Book Order</button>
                        </form>
                    </div>
                </div>
            @else
                <!-- Content for guests -->
                <div class="col-lg-6 col-md-6 col-sm-6 stick">
                    <p class="saving">You're saving total ₹300 on this order!</p>
                    <div class="login-card">
                        <h6 class="ac">Account</h6>
                        <p class="srp">To book the service, please login or sign up</p>
                        <div class="btn-div" data-bs-toggle="modal" data-bs-target="">
                        <a class="login-btn" href="{{route('user.login', ['redirect' => request()->fullUrl()] )}}">Login</a>
                        </div>
                        <br>
                      
                    </div>
                </div>
            @endif

            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="checkout-card">
                    @if (!empty($cart))
                        @foreach ($cart as $item)
                            <div class="item-name">
                                <!-- Display the package name -->
                                <p>{{ $item['package'] }}</p>

                                <div class="add-to-cart">
                                    <div class="quantity-control">
                                        <button class="qt-btn"
                                            onclick="decrement(this, '{{ $item['package_id'] }}')"></button>
                                        <span class="quantity">{{ $item['quantity'] }}</span>
                                        <button class="qt-btn"
                                            onclick="increment(this, '{{ $item['package_id'] }}')"></button>
                                    </div>
                                </div>

                                <!-- Display the total price for the item -->
                                <p> &#8377;{{ $item['quantity'] * $item['price'] }}</p>
                            </div>
                        @endforeach
                    @else
                        <p>Your cart is empty!</p>
                    @endif
                    <div class="item-name pt-3">
                        <div>
                            <div class="offer-title">✔️Omaa Cover ▼</div>
                        </div>
                        <p style="margin: 0;">protection on this booking</p>
                        <p style="margin:0;"><svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12" r="10" stroke="black" stroke-width="2" />
                                <line x1="12" y1="10" x2="12" y2="16" stroke="black"
                                    stroke-width="2" stroke-linecap="round" />
                                <circle cx="12" cy="8" r="1" fill="black" />
                            </svg></p>
                    </div>

                    <div class="mt-4" style="border-bottom: 1px solid gainsboro;">
                        <h4 style="font-size: 18px;">Most Used Services</h4>
                        <div class="frequently-added-carousel owl-carousel owl-theme">

                            @foreach ($services as $service)
                                @foreach ($service->packages as $package)
                                    <div class="item">

                                        <div class="card">
                                            <div class="row">

                                                <div class="col-12 col-md-6">
                                                    <!-- 6 columns on medium screens and 12 on small screens -->
                                                    <div class="card-content">
                                                        <h4>{{ $package->package ?? 'No Package Name' }}</h4>
                                                        <p>₹{{ $package->price ?? 'Not Available' }}</p>
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-6">
                                                    <!-- Same here, for the image and button section -->
                                                    <a href="{{ url('/package/' . $service->id) }}">
                                                        @if ($package->image)
                                                            <img src="{{ asset('public/front/image/' . $package->image) }}"
                                                                alt="Package Image" class="ac-small-img">
                                                        @else
                                                            <p>No image available</p>
                                                        @endif
                                                    </a>
                                                    <a href="{{ url('/package/' . $service->id) }}"
                                                        class=" btn btn-secondary btn-sm">Add</a>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                @endforeach
                            @endforeach



                            <!-- Add more items as needed -->
                        </div>
                    </div>

                    <div class="check">
                        <input type="checkbox" name="" id="">
                        <p class="avoid">Avoid calling before reaching the location</p>
                    </div>
                </div>

                <div class="login-card mt-4 d-flex">
                    <div>
                        <svg width="50" height="50" viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg">
                            <!-- Circle background -->
                            <circle cx="25" cy="25" r="25" fill="green" />

                            <!-- Percentage symbol -->
                            <text x="50%" y="50%" font-size="20" fill="white" text-anchor="middle"
                                alignment-baseline="middle" font-weight="bold">
                                %
                            </text>
                        </svg>

                    </div>
                    <div>
                        <p class="coupon">Coupons and offers</p>
                        <p class="sign"> Login/Sign up to view offers</p>
                    </div>
                </div>

                <div class="payment-summary mt-4">
                    <h3>Payment summary</h3>
                    <div class="summary-item">
                        <span>Item total</span>
                        <span>₹{{ $grandTotal }}</span>
                    </div>
                    <div class="summary-item">
                        <span>Item discount</span>
                        <span class="discount">0</span>
                    </div>
                    <div class="summary-item">
                        <span>Taxes and Fee</span>
                        <span>0</span>
                    </div>
                    <hr class="dotted-line">
                    <div class="total">
                        <span>Total</span>
                        <span class="total-amount">₹{{ $grandTotal }}</span>
                    </div>
                </div>

            </div>
        </div>


    </div>
    <script>
        $(document).ready(function() {
            $(".frequently-added-carousel").owlCarousel({
                items: 2,
                loop: false,
                margin: 10,
                nav: true,
                dots: false,
                navText: ["<", ">"],
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 2
                    },
                    1000: {
                        items: 2
                    }
                }
            });
        });
    </script>

    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius:1px;">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Please Login</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('front.user.login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" name="email" id="email" class="form-control"
                                placeholder="Enter your Email" required>
                            @error('email')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mt-3">Send OTP</button>
                    </form>

                    @if (session('otp_sent'))
                        <div class="alert alert-success mt-3">
                            {{ session('otp_sent') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger mt-3">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- OTP Verification Form -->
                    @if (session('otp_sent'))
                        <form method="POST" action="{{ route('front.verify.otp') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="otp" class="form-label">OTP</label>
                                <input type="text" name="otp" id="otp" class="form-control"
                                    placeholder="Enter OTP" required>
                                @error('otp')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-success w-100 mt-3">Verify OTP</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>


    </div>
    <div class="modal fade" id="staticBackdrop1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-2"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Sign up</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form starts here -->
                    <form method="POST" action="{{ route('front.user.register') }}"
                        class="p-4 bg-light rounded shadow-sm">
                        @csrf

                        <!-- Heading -->
                        <h4 class="text-center mb-4">Register Here</h4>
                        <div class="form-group mb-3">
                            <input type="text" name="invite_code" value="{{ old('invite_code') }}"
                                placeholder="Enter your Invitation Code" class="form-control">
                        </div>
                        <!-- Name Input -->
                        <div class="form-group mb-3">
                            <input type="text" name="name" value="{{ old('name') }}"
                                placeholder="Enter your Name" class="form-control" required>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Email Input -->
                        <div class="form-group mb-3">
                            <input type="email" name="email" value="{{ old('email') }}"
                                placeholder="Enter your Email" class="form-control" required>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Phone Input -->
                        <div class="form-group mb-3">
                            <input type="text" name="phone" value="{{ old('phone') }}"
                                placeholder="Enter your Phone" class="form-control" required>
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Address Input -->
                        <div class="form-group mb-3">
                            <textarea name="address" placeholder="Enter your Address" class="form-control" rows="4" required>{{ old('address') }}</textarea>
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                        </div>


                        <!-- City Input -->
                        <div class="form-group mb-3">
                            <input type="text" name="city" value="{{ old('city') }}"
                                placeholder="Enter your City" class="form-control" required>
                            @error('city')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Pin Code Input -->
                        <div class="form-group mb-4">
                            <input type="text" name="pin_code" value="{{ old('pin_code') }}"
                                placeholder="Enter your Pin Code" class="form-control" required>
                            @error('pin_code')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary w-100">Register</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script>
        document.getElementById('proceed-button').addEventListener('click', function() {
            // Hide the email input and show the OTP input
            document.getElementById('email-input').style.display = 'none';
            document.getElementById('otp-input').style.display = 'block';
        });
    </script>


@endsection
