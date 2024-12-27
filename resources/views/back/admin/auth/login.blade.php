<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <title>Omaa Company|Admin Login</title>
    <!-- GLOBAL MAINLY STYLES-->
    <link href="{{ asset('public/assets/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet" />


    <link href="{{asset('public/assets/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" />
    <link href="{{asset('public/assets/vendors/themify-icons/css/themify-icons.css')}}" rel="stylesheet" />
    <!-- THEME STYLES-->
    <link href="{{asset('public/assets/css/main.css')}}" rel="stylesheet" />
    <!-- PAGE LEVEL STYLES-->
    <link href="{{asset('public/assets/css/pages/auth-light.css')}}" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">

</head>

<body class="bg-silver-300">
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
    <div class="content">
        <div class="brand">
            <a class="link" href="index.html">Omaa Company</a>
        </div>
        <form  action="{{ route('admin.submit') }}" method="POST">
    @csrf
    <h2 class="login-title">Log in</h2>
    <div class="form-group">
        <div class="input-group-icon right">
            <div class="input-icon"><i class="fa fa-envelope"></i></div>
            <input class="form-control" type="email" name="email" placeholder="Email" autocomplete="off" required>
        </div>
        <!-- Display email error -->
        @error('email')
            <div class="alert alert-danger mt-2">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="form-group">
        <div class="input-group-icon right">
            <div class="input-icon"><i class="fa fa-lock font-16"></i></div>
            <input class="form-control" type="password" name="password" placeholder="Password" required>
        </div>
        <!-- Display password error -->
        @error('password')
            <div class="alert alert-danger mt-2">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="form-group">
        <button class="btn btn-info btn-block" type="submit">Login</button>
    </div>
</form>
           
          
        
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
    <script src="{{asset('public/assets/vendors/jquery-validation/dist/jquery.validate.min.js')}}" type="text/javascript"></script>
    <!-- CORE SCRIPTS-->
    <script src="{{asset('public/assets/js/app.js')}}" type="text/javascript"></script>
    <!-- PAGE LEVEL SCRIPTS-->
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
    <script type="text/javascript">
        $(function() {
            $('#login-form').validate({
                errorClass: "help-block",
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true
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
</body>

</html>