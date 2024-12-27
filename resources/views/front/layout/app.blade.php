<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> {{$title['title']}}</title>
    <link rel="stylesheet" href="{{asset('public/front/css/style.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

</head>
<body class="d-body">
  <div class="bg-cur">
    <div class="mobile-icon d-block d-md-none location" >
     <div>
      <h2>H107</h2>
      <p>H Block-Sector 63-Noida Uttar Prades...</p>
     </div>
      <div>
        <a style="color: white; font-size: 26px;" href="#"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a>
      </div>
    </div>

    <div id="searchBar" class="mobile-icon d-block d-md-none fixed-top" style="padding:12px 11px; box-shadow: 0px 0px 2px 0px;">
      <form class="d-flex">
          <input id="animatedPlaceholder" class="form-control me-2 ps-5" type="search"  aria-label="Search">
          <button class="ser-btn" type="submit"><i class="fa fa-search" aria-hidden="true" style="font-size: 20px"></i></button>
      </form>
    </div>
    @php
    use App\Models\HomeCustomize;

    $Images = HomeCustomize::first();
    $mobile_view = $Images ? json_decode($Images->mobile_view, true) : null;
@endphp
    <div class="mobile-icon d-block d-md-none " >
       <h2 class="electric">Electric Week</h2>
       <div class="container pb-5">
        <div class="row">
        @if($mobile_view)
    @foreach($mobile_view as $image)
        <div class="col-4">
            <img src="{{ asset('storage/app/private/public/'.$image) }}" alt="" width="100%" style="border-radius: 10px">
        </div>
    @endforeach
@else
    
@endif
         
         </div>
       </div>
     </div>
  </div>
 
@include('front.layout.header')

   <div class="content">
    @yield('content')
</div>


@include('front.layout.footer')
  
   
<style>
  .electric{
    margin-top: 87px;
    color: white;
    font-size: 42px;
    padding-left: 28px;

  }
  
  .location{
    color: white;
    padding: 64px 11px;
    display: flex !important;
    justify-content: space-between;
  }
    img.ico-img {
    width: 35px;
}
h6.icon-name {
    font-size: 13px;
    color: black;
    text-decoration: none;
}
a.ic-link {
    text-decoration: none;
}
.ser-btn{
    border: none;
    background: transparent;
    position: absolute;
    top: 19px;
    left: 17px;
}
.fixed-scroll {
    top: 0 !important;
    transition: top 0.3s ease-in-out;
    background-color: white!important;
}
.fixed-top {
    position: fixed;
    top: 158px;
    right: 0;
    left: 0;
    z-index: 1030;
    background-color: #03133B;
}
</style>
<script>
  document.addEventListener('scroll', function () {
    const searchBar = document.getElementById('searchBar');
    const scrollDistance = 100;

    if (window.scrollY > scrollDistance) {
        searchBar.classList.add('fixed-scroll');
    } else {
        searchBar.classList.remove('fixed-scroll');
    }
});
</script>




<div class="mobile-icon d-block d-md-none fixed-bottom" style="background-color: white;    padding:12px 11px; box-shadow: 0px 4px 12px 0px;">
    <div class="row">
      <div class="col text-center">
        <a href="{{route('front.home')}}" class="ic-link"><i class="fa fa-home" aria-hidden="true" style="color: #afa8aa;font-size: 26px;"></i>
        <h6 class="icon-name">Home</h6>
       </a>
      </div>
      <div class="col text-center">
       
          @if(Auth::check())
       <a href="{{ route('user.front.dashboard') }}" class="ic-link">
          <i class="fa fa-book" aria-hidden="true" style="color: #afa8aa; font-size: 26px;"></i>
          <h6 class="icon-name">My Booking</h6>
        </a>
       @else
         <a href="{{route('user.login')}}" class="ic-link">
          <i class="fa fa-book" aria-hidden="true" style="color: #afa8aa; font-size: 26px;"></i>
          <h6 class="icon-name">My Booking</h6>
        </a>
        
         @endif
       
      </div>
     
     <div class="col text-center">
          @if(Auth::check())
        <a href="{{ route('user.front.wallet') }}" class="ic-link">
          <i class="fa fa-user-plus" aria-hidden="true" style="color: #afa8aa; font-size: 26px;"></i>
          <h6 class="icon-name">Referral</h6>
        </a>
        @else
          <a href="{{route('user.login')}}" class="ic-link">
          <i class="fa fa-user-plus" aria-hidden="true" style="color: #afa8aa; font-size: 26px;"></i>
          <h6 class="icon-name">Referral</h6>
        </a>
      @endif
      </div>

      <!-- <div class="col text-center">
        <a href="#" class="ic-link"><i class="fa fa-shopping-cart" aria-hidden="true" style="color: #afa8aa;font-size: 26px;"></i>
        <h6 class="icon-name">Cart</h6>
       </a>
      </div> -->


    </div>
  </div>



<div class="d-block d-md-none">
<div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasBottom" aria-labelledby="offcanvasBottomLabel" style="height: 76px;">
  {{-- <div class="offcanvas-header">
    
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div> --}}
  <div class="offcanvas-body small " style="display: flex !important; justify-content: space-around;">
    <p style="font-size: 17px">Product add in cart successfull</p>
    <div class="">
      <a style="text-decoration: none;font-size: 14px;padding: 7px 20px;background: #6f0ba1;color: white;font-weight: 500;border-radius: 6px;" href="#">View cart</a>
    </div>
  </div>
</div>
</div>



  <script>
    document.addEventListener("DOMContentLoaded", () => {
     const inputField = document.getElementById("animatedPlaceholder");
     const words = [" 'Ac Booking Services' ", " 'RO Booking Services' ", " 'Washing Booking Services' " ," 'Refrigerator Booking Services' "]; // Words to animate
     let wordIndex = 0; // Current word index
     let charIndex = 0; // Current character index
     let direction = 1; // 1 for forward, -1 for backward
 
     function animatePlaceholder() {
         const currentWord = words[wordIndex];
         inputField.placeholder = `Search for ${currentWord.slice(0, charIndex)}`;
         charIndex += direction;
 
         // Change direction at start or end of the word
         if (charIndex > currentWord.length) {
             direction = -1; // Reverse
         } else if (charIndex < 0) {
             direction = 1; // Forward
             wordIndex = (wordIndex + 1) % words.length; // Move to next word
         }
 
         // Adjust animation speed
         setTimeout(animatePlaceholder, 50);
     }
 
     animatePlaceholder();
 });
 </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body>

</html>