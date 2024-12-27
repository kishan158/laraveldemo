<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <title>Omaa Company| Dashboard</title>
    <!-- GLOBAL MAINLY STYLES-->
    <link href="" rel="icon">
    <link href="{{ asset('public/assets/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{asset('public/assets/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" />
    <link href="{{asset('public/assets/vendors/themify-icons/css/themify-icons.css')}}" rel="stylesheet" />
    <!-- PLUGINS STYLES-->
    <link href="{{asset('public/assets/vendors/summernote/dist/summernote.css')}}" rel="stylesheet" />
    <link href="{{asset('public/assets/vendors/jvectormap/jquery-jvectormap-2.0.3.css')}}" rel="stylesheet" />
    <!-- THEME STYLES-->
    <link href="{{asset('public/assets/css/main.min.css')}}" rel="stylesheet" />
    <link href="{{asset('public/assets/css/pages/mailbox.css')}}" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <!-- PAGE LEVEL STYLES-->
</head>
<style>
    .page-sidebar{
position: fixed;
    }
    .content-wrapper{
        min-height:640px;
    }
</style>
<body class="fixed-navbar">
    <div class="page-wrapper">
       
     

        @include('back.vendor.layout.header')
        <div class="content-wrapper">

            @yield('content')
            @include('back.vendor.layout.footer')
        </div>
       
    </div>

   
   
</body>

</html>