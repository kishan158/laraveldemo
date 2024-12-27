@extends('front.layout.app')

@section('content')
<style>
    a.crd-text{
        text-decoration:none;
        color:black;
    }

    .category-item{
        background-color:#F5F5F5;
    }
    .service-category {
    background-color: #FFFFFF; /* Pure white */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05); /* Subtle shadow for depth */
    border: 1px solid #E0E0E0; /* Light border for definition */
    border-radius: 1px; /* Slightly rounded corners */
    padding: 20px; /* Adds spacing inside */
}
.siz {
    position: relative;
    display: inline-block;
    color: inherit; /* Use the existing text color */
}

.siz::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: 0;
    width: 0;
    height: 2px;
    background-color: black; /* Black underline */
    transition: width 0.4s ease; /* Smooth animation */
}

.siz:hover::after {
    width: 100%; /* Expand underline on hover */
}
</style>
<div class=" m-1 ">
    <div class="row">
      <div class="col-lg-5">
        <h2 class="h2-head">Home services at your doorstep</h2>
        <div class="service-category mt-4">
           <h5>Appliance repair & service</h5>
            <div class="row mt-3">
               
               
                @foreach($data as $service)
                <div class="col-4 col-md-4 mb-3 ">
                <a href="{{ url('/package/' . $service->id) }}"  class="crd-text">
                    <div class="category-item">
                        <!-- Dynamically display service image -->
                       
                        <img src="{{ asset('public/front/image/'.$service->image) }}" alt="{{ $service->name }}" class="img-fluid">
                        
                        <!-- Display service name -->
                        
                    </div>
                    <span class="siz">{{ $service->service }}</span>
                    </a>
                </div>
              @endforeach
              
            </div>
        </div>
        <div class="col-6 col-md-4 mb-3 rate">
           <div class="row ">
            <div class="col-6 col-md-8 mb-3 service-rating " style="    height: 65px;
                padding-top: 40px;">
                <div><i class="fa fa-star" style="color: yellow"></i><p><b>4.8</b> </p><span class="siz">Service Rating</span></div>
            </div>
            <div class="col-6 col-md-4 mb-3  service-rating " style="    height: 65px;
                padding-top: 40px;">
                <div><i class="fa fa-users"></i> <p><b>12M+</b></p><span class="siz"> Customers Globally</span></div>
            </div>
           </div>
        </div>
      </div>
      <div class="col-1"></div>
      <div class="col-lg-6">
        <div class="service-images">
        @foreach($banner1 as $image)
          <img src="{{ asset('storage/app/private/public/'.$image) }}" alt="Service Image 1">
          @endforeach
        </div>
      </div>
    </div>
</div>

<div class="m-1 m-pad">
    <div class="owl-carousel">
        @foreach($banner2 as $image)
        <div class="item">
            <img src="{{ asset('storage/app/private/public/'.$image) }}" alt="Image 1">
        </div>
        @endforeach
    </div>
</div>
<script>
   $(document).ready(function () {
    $(".owl-carousel").owlCarousel({
        loop: true, // Enable infinite scrolling
        margin: 10, // Space between items
        nav: false, // Disable navigation buttons
        autoplay: true, // Auto-slide
        autoplayTimeout: 3000, // 3 seconds per slide
        autoplayHoverPause: true, // Pause on hover
        responsive: {
            0: {
                items: 2 // Show 1 card on screens less than 576px
            },
            576: {
                items: 2 // Keep 1 card for larger phones
            },
            768: {
                items: 3 // Show 2 cards for tablets
            },
            1000: {
                items: 3 // Show 3 cards for desktops
            }
        }
    });
});


</script>
<style>
    .owl-carousel .item {
    text-align: center; /* Center content in each item */
    width: 100%; /* Make the item responsive */
}

.owl-carousel img {
    width: 100%; /* Make images responsive */
    height: auto; /* Maintain aspect ratio */
}

@media (max-width: 576px) {
    .owl-carousel .item {
        margin: 0 auto; /* Center the single card on mobile */
    }
}
</style>
   <section>
    <div class=" ml-5 m-5">
        <div id="cardCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="card-group">
                    @foreach($banner2 as $image)
                        <div class="card" style="border: none; margin-right: 13px;">
                            <img src="{{ asset('storage/app/private/public/'.$image) }}" class="card-img-top" alt="Image 1">
                        </div>
                        @endforeach
                    </div>
                </div>

                
                <div class="carousel-item active">
                    <div class="card-group">
                    @foreach($banner2 as $image)
                        <div class="card" style="border: none; margin-right: 13px;">
                            <img src="{{ asset('storage/app/private/public/'.$image) }}" class="card-img-top" alt="Image 1">
                        </div>
                        @endforeach
                        
                    </div>
                </div>      

                
            </div>

           
            <button class="carousel-control-prev" type="button" data-bs-target="#cardCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#cardCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</section> 


<div class="m-1">
    <h2 class="h2-head mb-4" style="margin-left: 10px; ">New and noteworthy</h2>
    <div class="owl-carousel">
        @foreach($services as $service)
        @foreach($service->packages as $package)
        <a href="{{ url('/package/' . $service->id) }}" style="text-decoration:none;">
        <div class="item">
            <img src="{{ asset('public/front/image/' . $package->image) }}" alt="{{ $package->package }}" width="100%">
            <p class="card-title">{{ $package->package }}</p>
        </div>
    </a>
    @endforeach 
    @endforeach
    </div>
</div>

{{-- <section class=" m-5 position-relative" id="native">
    <h2 style="margin-left: 10px;">New and noteworthy</h2>
   
    <div class="scroll-container position-relative">
    @foreach($services as $service)
    @foreach($service->packages as $package)
    <a href="{{ url('/package/' . $service->id) }}" style="text-decoration:none;">
        <div class="card" style="border: none;">
            <img src="{{ asset('public/front/image/' . $package->image) }}" alt="{{ $package->package }}">
            <p class="card-title">{{ $package->package }}</p>
        </div>
        </a>
        @endforeach 
        @endforeach
    </div>
   
</section> --}}


<div class="m-1">
    <h2 class="h2-head" style="margin-left: 10px;">Most Booked Services</h2>
    <div class="owl-carousel">
        @foreach($services as $service)
            @foreach($service->packages as $package)
            <a href="{{ url('/package/' . $service->id) }}" style="text-decoration:none;">
        <div class="item">
            <img src="{{ asset('public/front/image/' . $package->image) }}" alt="{{ $package->package }}" class="img-fluid">
            <p class="card-title">{{ $package->package }}</p>
                
                    {{-- <p class="card-text">
                        <i class="fa fa-star" style="color: yellow" aria-hidden="true"></i>
                    </p> --}}
        </div>
    </a>
    @endforeach
@endforeach
    </div>
</div>

{{-- 
<section class="m-5 position-relative">
    <h2 style="margin-left: 10px;">Most Booked Services</h2>
    
    
    <div class="scroll-container owl-carousel">
        @foreach($services as $service)
            @foreach($service->packages as $package)
            <a href="{{ url('/package/' . $service->id) }}" style="text-decoration:none;">
                <div class="card" style="border: none; margin-right: 15px;">
                    <img src="{{ asset('public/front/image/' . $package->image) }}" alt="{{ $package->package }}" class="img-fluid">
                    
                        <p class="card-title">{{ $package->package }}</p>
                
                    <p class="card-text">
                        <i class="fa fa-star" aria-hidden="true"></i>
                    </p>
                </div>
                </a>
            @endforeach
        @endforeach
    </div>
</section> --}}


<section>
@if(!empty($banner3) && isset($banner3[0]))
    <div class=" mt-5">
            <img src="{{ asset('storage/app/private/public/'.$banner3[0]) }}" alt="Banner Image" width="100%">
        </div>
   
@endif
</section>

<section class="m-1  mobile-service" id="electric">
    <div class="row">
      @foreach($services->take(3) as $service)
      <h4 class="custom-section h2-head" style="padding-bottom:15px;">{{ $service->service }}</h4>
      @foreach($service->packages as $package)
      <div class="col-lg-6 col-md-6 col-6">
        <a href="{{ url('/package/' . $service->id) }}" style="text-decoration:none;">
          <div class="card" style="border: none; position: relative; margin-bottom: 15px;">
            <img src="{{ asset('public/front/image/' . $package->image) }}" alt="{{ $package->package }}" class="img-fluid">
            <div class="">
              <p class="card-title">{{ $package->package }}</p>
            </div>
          </div>
        </a>
      </div>
      @endforeach
      @endforeach
    </div>
  </section>
  

<section class=" m-1 position-relative web-ser" id="electric">

     <a href="#"> <button  style="
        border: 1px solid #dee2e6;
        height: 37px;
        width: 91px;
     
        margin-bottom: 10px;
    ">See all</button></a>
@foreach($services->take(3) as $service) 
    <h4 class="custom-section" style="padding-bottom:15px;">{{ $service->service }}</h4>
    
    <div class="position-relative" style="display: flex;">
      
        @foreach($service->packages as $package) 
        <a href="{{ url('/package/' . $service->id) }}" style="text-decoration:none;">
            <div class="card" style="border: none; position: relative;margin-right: 25px; padding-bottom:25px; ">
             
                    <img src="{{ asset('public/front/image/' . $package->image) }}" alt="{{ $package->package }}" class="img-fluid">
              
                <div class="overlay-content">
                    <p class="card-title">{{ $package->package }}</p>
                </div>
            </div>
            </a>
        @endforeach
    </div>
@endforeach


</section>


<section>
@if(!empty($banner3) && isset($banner3[1]))
    <div class=" mt-5">
            <img src="{{ asset('storage/app/private/public/'.$banner3[1]) }}" alt="Banner Image" width="100%">
        </div>
   
@endif

</section>

  
   <section class=" m-1 position-relative">
   @foreach($services->skip(3)->take(1) as $service) <!-- Skip the first 3 services and take only the 4th one -->
    <h2 class="custom-section h2-head" style="padding-bottom:15px;">{{ $service->service }}</h2> <!-- Display the service name -->
    
    <div class="position-relative" style="display: flex;">
      
        @foreach($service->packages as $package)
        <a href="{{ url('/package/' . $service->id) }}" style="text-decoration:none;">
            <div class="card" style="border: none; position: relative;margin-right: 25px; padding-bottom:25px; ">
              
                    <img src="{{ asset('public/front/image/' . $package->image) }}" alt="{{ $package->package }}" class="img-fluid">
                
                <div class="">
                    <p class="card-title">{{ $package->package }}</p>
                </div>
            </div>
            </a>
        @endforeach
    </div>
@endforeach
</section>

<section>
@if(!empty($banner3) && isset($banner3[2]))
    <div class=" mt-5">
            <img src="{{ asset('storage/app/private/public/'.$banner3[2]) }}" alt="Banner Image" width="100%">
        </div>
   
@endif
</section>

<section class="custom-container mt-5 position-relative">
@foreach($services->skip(4)->take(1) as $service) <!-- Skip the first 3 services and take only the 4th one -->
    <h4 class="custom-section" style="padding-bottom:15px;">{{ $service->service }}</h4> <!-- Display the service name -->
    
    <div class="position-relative" style="display: flex;">
      
        @foreach($service->packages as $package) <!-- Loop through the packages of the service -->
        <a href="{{ url('/package/' . $service->id) }}" style="text-decoration:none;">
            <div class="card" style="border: none; position: relative;margin-right: 25px; padding-bottom:25px; ">
               
                    <img src="{{ asset('public/front/image/' . $package->image) }}" alt="{{ $package->package }}" class="img-fluid">
           
                <div class="overlay-content">
                    <p class="card-title">{{ $package->package }}</p>
                </div>
            </div>
            </a>
        @endforeach
    </div>
@endforeach

    <div class="custom-slider-buttons">
        <button onclick="slideLeft()">❮</button>
        <button onclick="slideRight()">❯</button>
    </div>
</section>

<section>
    <div class="repair-carousel-container">
    @foreach($services->skip(5)->take(1) as $service)
        <h4  class="custom-section" style="padding-bottom:15px;">{{ $service->service }}</h4>
       
        
        <div class="repair-carousel">
            <button class="repair-carousel-nav repair-left"><i class="fa fa-arrow-left" aria-hidden="true"></i> </button>
            @foreach($service->packages as $package)
            <div class="repair-carousel-items">
                <div class="repair-card">
                  <a href="{{ url('/package/' . $service->id) }}"><img src="{{ asset('public/front/image/' . $package->image) }}" alt="Curtain rod installation"></a>
                    <div class="repair-card-info">
                        <p>{{ $package->package }}</p>
                       
                    </div>
                </div>
                
            </div>
            @endforeach
            <button class="repair-carousel-nav repair-right"><i class="fa fa-arrow-right" aria-hidden="true"></i></button>
        </div>
        @endforeach
    </div>
</section>


<section class=" m-1  position-relative">
@foreach($services->skip(6)->take(1) as $service) <!-- Skip the first 3 services and take only the 4th one -->
    <h4 class="custom-section" style="padding-bottom:15px;">{{ $service->service }}</h4> <!-- Display the service name -->
    
    <div class="position-relative" style="display: flex;">
      
        @foreach($service->packages as $package) <!-- Loop through the packages of the service -->
        <a href="{{ url('/package/' . $service->id) }}" style="text-decoration:none;">
            <div class="card" style="border: none; position: relative;margin-right: 25px; ">
              
                    <img src="{{ asset('public/front/image/' . $package->image) }}" alt="{{ $package->package }}" class="img-fluid">
            
                <div class="overlay-content">
                    <p class="card-title">{{ $package->package }}</p>
                </div>
            </div>
            </a>
        @endforeach
    </div>
@endforeach
</section>

<section>
@if(!empty($banner3) && isset($banner3[3]))
    <div class=" mt-5">
            <img src="{{ asset('storage/app/private/public/'.$banner3[3]) }}" alt="Banner Image"  width="100%">
        </div>
   
@endif
</section>
<section class=" m-1 position-relative">
  
@foreach($services->skip(7)->take(1) as $service) <!-- Skip the first 3 services and take only the 4th one -->
    <h4 class="custom-section" style="padding-bottom:15px;">{{ $service->service }}</h4> <!-- Display the service name -->
    
    <div class="position-relative" style="display: flex;">
      
        @foreach($service->packages as $package) <!-- Loop through the packages of the service -->
        <a href="{{ url('/package/' . $service->id) }}" style="text-decoration:none;">
            <div class="card" style="border: none; position: relative;margin-right: 25px; ">
                
                    <img src="{{ asset('public/front/image/' . $package->image) }}" alt="{{ $package->package }}" class="img-fluid">
              
                <div class="overlay-content">
                    <p class="card-title">{{ $package->package }}</p>
                </div>
            </div>
            </a>
        @endforeach
    </div>
@endforeach
</section>

@endsection