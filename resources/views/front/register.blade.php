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
    <div class="checkout-card" style="
    margin: 5% 17%;
">

        <div class="item-name pt-3" style="background-color:#F7F7F7;">

            <p style="margin: 0;">
            <h4 class="text-center mb-6" >Register Here</h4>
            </p>

        </div>



        <div class="">
            <!-- Form starts here -->
            <form method="POST" action="{{ route('front.user.register') }}" class="p-4 bg-light rounded shadow-sm">
                @csrf

                <!-- Heading -->



                @if($invite_code)
                <div class="form-group mb-3">
                    <input type="text" name="invite_code" value="{{ $invite_code }}"
                        placeholder="Enter your Invitation Code" class="form-control">
                </div>
                @endif
                <!-- Name Input -->
                <div class="form-group mb-3">
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Enter your Name"
                        class="form-control" required>
                    @error('name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email Input -->
                <div class="form-group mb-3">
                    <input type="email" name="email" placeholder="Enter your Email" class="form-control" required>
                    @error('email')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Phone Input -->
                <div class="form-group mb-3">
                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Enter your Phone"
                        class="form-control" required>
                    @error('phone')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Address Input -->
                <div class="form-group mb-3">
                    <textarea name="address" placeholder="Enter your Address" class="form-control" rows="4"
                        required>{{ old('address') }}</textarea>
                    @error('address')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror

                </div>


                <!-- City Input -->
                <div class="form-group mb-3">
                    <input type="text" name="city" value="{{ old('city') }}" placeholder="Enter your City"
                        class="form-control" required>
                    @error('city')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Pin Code Input -->
                <div class="form-group mb-4">
                    <input type="text" name="pin_code" value="{{ old('pin_code') }}" placeholder="Enter your Pin Code"
                        class="form-control" required>
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
                        <input type="email" name="email" id="email" class="form-control" placeholder="Enter your Email"
                            required>
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
                        <input type="text" name="otp" id="otp" class="form-control" placeholder="Enter OTP" required>
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
                <form method="POST" action="{{ route('front.user.register') }}" class="p-4 bg-light rounded shadow-sm">
                    @csrf

                    <!-- Heading -->
                    <h4 class="text-center mb-4">Register Here</h4>
                    <div class="form-group mb-3">
                        <input type="text" name="invite_code" value="{{ old('invite_code') }}"
                            placeholder="Enter your Invitation Code" class="form-control">
                    </div>
                    <!-- Name Input -->
                    <div class="form-group mb-3">
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Enter your Name"
                            class="form-control" required>
                        @error('name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email Input -->
                    <div class="form-group mb-3">
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter your Email"
                            class="form-control" required>
                        @error('email')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Phone Input -->
                    <div class="form-group mb-3">
                        <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Enter your Phone"
                            class="form-control" required>
                        @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Address Input -->
                    <div class="form-group mb-3">
                        <textarea name="address" placeholder="Enter your Address" class="form-control" rows="4"
                            required>{{ old('address') }}</textarea>
                        @error('address')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror

                    </div>


                    <!-- City Input -->
                    <div class="form-group mb-3">
                        <input type="text" name="city" value="{{ old('city') }}" placeholder="Enter your City"
                            class="form-control" required>
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