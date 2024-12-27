<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <title>Omaa Company| Register</title>
    <!-- GLOBAL MAINLY STYLES-->
    <link href="{{asset('public/assets/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet" />
    <link href="{{asset('public/assets/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" />
    <link href="{{asset('public/assets/vendors/themify-icons/css/themify-icons.css')}}" rel="stylesheet" />
    <!-- THEME STYLES-->
    <link href="{{asset('public/assets/css/main.css')}}" rel="stylesheet" />
    <!-- PAGE LEVEL STYLES-->
    <link href="{{asset('public/assets/css/pages/auth-light.css')}}" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">

</head>

<body class="bg-silver-300">
<div class="content">
    @if (session('success'))
        <script>
            toastr.success("{{ session('success') }}");
        </script>
    @endif

    @if (session('error'))
        <script>
            toastr.error("{{ session('error') }}");
        </script>
    @endif

    <div class="brand">
        <a class="link" href="index.html">Omaa Company</a>
    </div>
    <form action="{{ route('vender.register.submit') }}" method="post">
        @csrf
        <h2 class="login-title">Sign Up</h2>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <input class="form-control" type="text" name="name" placeholder="First Name" value="{{ old('name') }}">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <input class="form-control" type="text" name="last_name" placeholder="Last Name" value="{{ old('last_name') }}">
                    @error('last_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group col-6">
                <input class="form-control" type="email" name="email" placeholder="Email" value="{{ old('email') }}" autocomplete="off">
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group col-6">
                <input class="form-control" type="number" name="phone" placeholder="Phone" value="{{ old('phone') }}" autocomplete="off">
                @error('phone')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
           
            <div class="form-group col-6">
                <input class="form-control" type="text" name="address" placeholder=" Address" value="{{ old('address') }}" autocomplete="off">
                @error('address')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group col-6">
                <input class="form-control" id="password" type="password" name="password" placeholder="Password">
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group col-6">
                <input class="form-control" type="password" name="password_confirmation" placeholder="Confirm Password">
                @error('password_confirmation')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-group col-6">
            <button class="btn btn-info btn-block" type="submit">Sign up</button>
        </div>
        
    </form>
    <div class="text-center">Already a member?
        <a class="color-blue" href="{{route('vendor.login')}}">Login here</a>
    </div>
</div>
    <!-- BEGIN PAGA BACKDROPS-->
    <div class="sidenav-backdrop backdrop"></div>
    <div class="preloader-backdrop">
        <div class="page-preloader">Loading</div>
    </div>
    <!-- END PAGA BACKDROPS-->
    <!-- CORE PLUGINS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script src="{{asset('public/assets/vendors/jquery/dist/jquery.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('public/assets/vendors/popper.js/dist/umd/popper.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('public/assets/vendors/bootstrap/dist/js/bootstrap.min.js')}}" type="text/javascript"></script>
    <!-- PAGE LEVEL PLUGINS -->
    <script src="{{asset('public/assets/vendors/jquery-validation/dist/jquery.validate.min.js')}}"
        type="text/javascript"></script>
    <!-- CORE SCRIPTS-->
    <script src="{{asset('public/assets/js/app.js')}}" type="text/javascript"></script>
    <!-- PAGE LEVEL SCRIPTS-->
    <script type="text/javascript">
    $(function() {
        $('#register-form').validate({
            errorClass: "help-block",
            rules: {
                name: {
                    required: true,
                    minlength: 2
                },
                last_name: {
                    required: true,
                    minlength: 2
                },
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    confirmed: true
                },
                password_confirmation: {
                    equalTo: password
                }
            },
            highlight: function(e) {
                $(e).closest(".form-group").addClass("has-error")
            },
            unhighlight: function(e) {
                $(e).closest(".form-group").removeClass("has-error")
            },
        });
    });
    </script>
    <script>
    toastr.options = {
        "closeButton": true,  // Adds a close button
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right", // Position of the toast
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300", // Duration to show the toast
        "hideDuration": "1000",
        "timeOut": "5000", // Duration before the toast disappears
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
</script>
</body>

</html>