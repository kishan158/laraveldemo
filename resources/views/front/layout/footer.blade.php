
<footer  style="background-color: #5c5e7240;">
    <div class="container">
        <div class="container pt-5">
            <div class="row">
                <div class="col-lg-2 col-sm-2 col-md-2 footer-logo">
                <img src="{{ asset('storage/app/public/' . $title['logo']) }} " alt="Logo" class="logo">                </div>
                <div class="col-lg-10 col-sm-10 col-md-10 "></div>
            </div>
        </div>
       <div class="row mt-5">
          <div class="col-lg-3 col-md-3 col-sm-3 font">
         
       
            <h6>Company</h6>
            <div class="col">
    @foreach (DB::table('pages')->get() as $page)
        <div class=" col"> <!-- Adjust the column size as needed -->
            <a class="{{ request()->routeIs('front.page', [$page->slug]) ? 'active' : '' }}" 
               href="{{ route('front.page', $page->slug) }}" style="
    text-decoration: none;
    color: black;
">
               {{ $page->title }}
            </a>
        </div>
    @endforeach
</div>
          
          </div>
          <div class="col-lg-3 col-md-3 col-sm-3 font">
            <h6>For customers </h6>
            <p>OC reviews  </p>
            <p>Categories near you  </p>
            <p>Blog  </p>
            <p>Contact us  </p>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-3 font">
            <h6>For partners</h6>
            <a href="{{route('vendor.login')}}" style="
    text-decoration: none;
    color: black;
">Register as a professional</a>
            
          </div>
          <div class="col-lg-3 col-md-3 col-sm-3">
            <h6>Social links</h6>
            <ul class="d-ruby;" style="list-style-type: none;    display: ruby; margin-left: 0px; padding-left: 0px;">
                <li><svg class="m-icon" 
                    viewBox="0 0 24 24" fill="#0F0F0F" xmlns="http://www.w3.org/2000/svg"><path d="M17 16.827V13.13c0-1.98-1.058-2.902-2.468-2.902-1.139 0-1.647.626-1.932 1.066v.02h-.014l.014-.02v-.914h-2.144c.029.605 0 6.447 0 6.447H12.6v-3.601c0-.192.015-.384.071-.522.155-.386.508-.784 1.1-.784.776 0 1.086.591 1.086 1.457v3.45H17zM7 8.385c0-.632.48-1.114 1.213-1.114.734 0 1.185.482 1.199 1.114 0 .619-.465 1.115-1.213 1.115h-.014C7.466 9.5 7 9.005 7 8.385zM9.271 10.38v6.447H7.127V10.38h2.144z" fill="#0F0F0F"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M2 12c0 5.523 4.477 10 10 10s10-4.477 10-10S17.523 2 12 2 2 6.477 2 12zm15.657 5.657A8 8 0 116.343 6.342a8 8 0 0111.314 11.315z" fill="#0F0F0F"></path></svg></li>
                <li><svg class="m-icon" viewBox="0 0 24 24" fill="#0F0F0F" xmlns="http://www.w3.org/2000/svg"><path d="M17.34 5.46a1.2 1.2 0 100 2.4 1.2 1.2 0 000-2.4zm4.6 2.42a7.588 7.588 0 00-.46-2.43 4.94 4.94 0 00-1.16-1.77 4.7 4.7 0 00-1.77-1.15 7.3 7.3 0 00-2.43-.47C15.06 2 14.72 2 12 2s-3.06 0-4.12.06a7.3 7.3 0 00-2.43.47 4.78 4.78 0 00-1.77 1.15 4.7 4.7 0 00-1.15 1.77 7.3 7.3 0 00-.47 2.43C2 8.94 2 9.28 2 12s0 3.06.06 4.12a7.3 7.3 0 00.47 2.43 4.7 4.7 0 001.15 1.77 4.78 4.78 0 001.77 1.15 7.3 7.3 0 002.43.47C8.94 22 9.28 22 12 22s3.06 0 4.12-.06a7.3 7.3 0 002.43-.47 4.7 4.7 0 001.77-1.15 4.85 4.85 0 001.16-1.77c.285-.78.44-1.6.46-2.43 0-1.06.06-1.4.06-4.12s0-3.06-.06-4.12zM20.14 16a5.61 5.61 0 01-.34 1.86 3.06 3.06 0 01-.75 1.15c-.324.33-.717.586-1.15.75a5.61 5.61 0 01-1.86.34c-1 .05-1.37.06-4 .06s-3 0-4-.06a5.73 5.73 0 01-1.94-.3 3.27 3.27 0 01-1.1-.75 3 3 0 01-.74-1.15 5.54 5.54 0 01-.4-1.9c0-1-.06-1.37-.06-4s0-3 .06-4a5.54 5.54 0 01.35-1.9A3 3 0 015 5a3.14 3.14 0 011.1-.8A5.73 5.73 0 018 3.86c1 0 1.37-.06 4-.06s3 0 4 .06a5.61 5.61 0 011.86.34 3.06 3.06 0 011.19.8c.328.307.584.683.75 1.1.222.609.337 1.252.34 1.9.05 1 .06 1.37.06 4s-.01 3-.06 4zM12 6.87A5.13 5.13 0 1017.14 12 5.12 5.12 0 0012 6.87zm0 8.46a3.33 3.33 0 110-6.66 3.33 3.33 0 010 6.66z" fill="#0F0F0F"></path></svg></li>
                <li><svg class="m-icon" viewBox="0 0 24 24" fill="#0F0F0F" xmlns="http://www.w3.org/2000/svg"><path d="M18.354 5.624C16.604 3.883 14.466 3 12 3c-2.489 0-4.633.884-6.373 2.625C3.884 7.366 3 9.512 3 12c0 2.465.883 4.603 2.624 6.354C7.365 20.11 9.51 21 12 21c2.467 0 4.605-.89 6.356-2.643C20.111 16.604 21 14.465 21 12c0-2.488-.89-4.634-2.646-6.376zm-1.412 11.319c-1.137 1.139-2.436 1.788-3.942 1.985V14h2v-2h-2v-1.4a.6.6 0 01.601-.6H15V8h-1.397c-.742 0-1.361.273-1.857.822-.496.547-.746 1.215-.746 2.008V12H9v2h2v4.93c-1.522-.195-2.826-.845-3.957-1.984C5.668 15.562 5 13.944 5 12c0-1.966.667-3.588 2.042-4.96C8.412 5.667 10.034 5 12 5c1.945 0 3.562.668 4.945 2.043C18.328 8.415 19 10.037 19 12c0 1.941-.673 3.559-2.058 4.943z" fill="#0F0F0F"></path></svg></li>
                <li><svg class="m-icon"
                 viewBox="0 0 24 24" fill="#0F0F0F" xmlns="http://www.w3.org/2000/svg"><path d="M22.991 3.95a1 1 0 00-1.51-.86 7.48 7.48 0 01-1.874.794 5.152 5.152 0 00-3.374-1.242 5.232 5.232 0 00-5.223 5.063 11.032 11.032 0 01-6.814-3.924 1.012 1.012 0 00-.857-.365 1 1 0 00-.785.5 5.276 5.276 0 00-.242 4.769l-.002.001a1.041 1.041 0 00-.496.89c-.002.147.007.294.027.439a5.185 5.185 0 001.568 3.312.998.998 0 00-.066.77 5.204 5.204 0 002.362 2.922 7.465 7.465 0 01-3.59.448A1 1 0 001.45 19.3a12.942 12.942 0 007.01 2.061 12.788 12.788 0 0012.465-9.363c.353-1.183.533-2.411.535-3.646l-.001-.2a5.77 5.77 0 001.532-4.202zm-3.306 3.212a.995.995 0 00-.234.702c.01.165.009.331.009.488a10.822 10.822 0 01-.454 3.08 10.685 10.685 0 01-10.546 7.93c-.859 0-1.715-.1-2.55-.301a9.481 9.481 0 002.942-1.564 1 1 0 00-.602-1.786 3.208 3.208 0 01-2.214-.935 4.95 4.95 0 00.445-.105 1 1 0 00-.08-1.943 3.197 3.197 0 01-2.25-1.726c.18.025.363.04.545.046a1.02 1.02 0 00.984-.696 1 1 0 00-.4-1.137 3.196 3.196 0 01-1.419-2.871 13.014 13.014 0 008.21 3.48 1.02 1.02 0 00.817-.36 1 1 0 00.206-.867 3.152 3.152 0 01-.087-.729 3.23 3.23 0 014.505-2.962c.404.176.767.433 1.066.756a.993.993 0 00.921.298 9.27 9.27 0 001.212-.322 6.683 6.683 0 01-1.026 1.524z" fill="#0F0F0F"></path></svg></li>

            </ul><br>
            <!-- <img src="image/icon-image1.webp" alt="" class="footer-image"><br/> -->
            <img src="{{asset('public/front/image/icon-image2.webp')}}" alt="" class="footer-image">
          </div>
       </div>
       <hr>
       <p class="pb-5 m-0 text-center" style="font-size:14px; ">Copyright @2024 OMAA CURRENTSEWA INDIA PVT. LTD. All Rights Reserved</p>
    </div>
</footer>


<script>
    const leftButton = document.querySelector('.repair-left');
    const rightButton = document.querySelector('.repair-right');
    const carouselItems = document.querySelector('.repair-carousel-items');
    const cards = document.querySelectorAll('.repair-card');
    let currentIndexes = 0;
    const cardWidth = cards[0].clientWidth + 30; // Width of card + margin

    // Function to update the carousel position
    function updateCarousel() {
        const offset = currentIndex * cardWidth;
        carouselItems.style.transform = `translateX(-${offset}px)`;
    }

    leftButton.addEventListener('click', () => {
        if (currentIndex > 0) {
            currentIndex--;
            updateCarousel();
        }
    });

    rightButton.addEventListener('click', () => {
        if (currentIndex < cards.length - 1) {
            currentIndex++;
            updateCarousel();
        }
    });
</script>



<script>
let currentIndex = 0;
function slideRight() {
    const container = document.getElementById("custom-slider");
    const totalItems = container.children.length;
    if (currentIndex < totalItems - 1) {
        currentIndex++;
        container.style.transform = `translateX(-${currentIndex * 215}px)`;
    }
}

function slideLeft() {
    if (currentIndex > 0) {
        currentIndex--;
        document.getElementById("custom-slider").style.transform = `translateX(-${currentIndex * 215}px)`;
    }
}
</script>
<script>
    $(document).ready(function(){
        $('.owl-carousel').owlCarousel({
            loop: true,
            margin: 10,
            nav: false,
            autoplay: true,
            autoplayTimeout: 3000, // Auto slide every 3 seconds
            autoplayHoverPause: true,
            responsive: {
                0: {
                    items: 2
                },
                600: {
                    items: 3
                },
                1000: {
                    items: 5
                }
            }
        });
    });
</script>
<script>
    let autoScroll;

    function scrollLeft() {
        clearInterval(autoScroll);
        document.querySelector('.scroll-container').scrollBy({
            left: -200,
            behavior: 'smooth'
        });
        startAutoScroll();
    }

    function scrollRight() {
        clearInterval(autoScroll);
        document.querySelector('.scroll-container').scrollBy({
            left: 200,
            behavior: 'smooth'
        });
        startAutoScroll();
    }

    function startAutoScroll() {
        autoScroll = setInterval(() => {
            document.querySelector('.scroll-container').scrollBy({
                left: 200,
                behavior: 'smooth'
            });
        }, 3000); // Scrolls every 3 seconds
    }

    // Start auto scroll on page load
    window.onload = startAutoScroll;
</script>
<script>
    $(document).ready(function() {
        @if(session('success'))
            toastr.success('{{ session('success') }}');
        @endif

        
        @if($errors->any())
            @foreach($errors->all() as $error)
                toastr.error('{{ $error }}');
            @endforeach
        @endif
    });
</script>

<script>
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right", // You can change the position here
        "timeOut": "5000",
    };
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
