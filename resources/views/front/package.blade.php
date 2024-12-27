@extends('front.layout.app')

@section('content')
<style>
.cart-section {
    background-color: #f8f8f8;
    padding: 15px;
    margin-top: 20px;
    border-radius: 8px;
}

.cart-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-left: -29px;
    margin-bottom: 10px;
    line-height: 16px;
}

.cart-item-title {
    font-size: 14px;
    line-height: 20px;
    color: rgb(15, 15, 15);
    text-decoration-line: none;
    text-transform: none;
    font-weight: 400;
    text-align: start;
}

.quantity-control {
    display: flex;
    align-items: center;
}

.price-info {
    text-align: right;
}

.current-price {
    font-size: 12px;
    line-height: 16px;
    color: rgb(15, 15, 15);
    text-decoration-line: none;
    text-transform: none;
    font-weight: 400;
    text-align: right;
}

.old-price {
    font-size: 14px;
    text-decoration: line-through;
    color: #888;
}

.savings-info {
    background-color: #28a745;
    color: white;
    padding: 10px;
    margin-top: 10px;
    border-radius: 5px;
    text-align: center;
}

.view-cart-button {
    background-color: #6f42c1;
    color: white;
    padding: 12px;
    border: none;
    border-radius: 5px;
    width: 100%;
    margin-top: 15px;
}

.modal-header .btn-close {
    filter: invert(1);
}

a.crd-text {
    text-decoration: none;
    color: black;
}

.category-item {
    background-color: #F5F5F5;
}

.service-category {
    background-color: #FFFFFF;
    /* Pure white */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    /* Subtle shadow for depth */
    border: 1px solid #E0E0E0;
    /* Light border for definition */
    border-radius: 8px;
    /* Slightly rounded corners */
    padding: 20px;
    /* Adds spacing inside */
}

.siz {
    position: relative;
    display: inline-block;
    color: inherit;
    /* Use the existing text color */
}

.siz::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: 0;
    width: 0;
    height: 2px;
    background-color: black;
    /* Black underline */
    transition: width 0.4s ease;
    /* Smooth animation */
}

.siz:hover::after {
    width: 100%;
    /* Expand underline on hover */
}
</style>
<section>
    <div class="  mt-5 mb-5">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 srv">
                <section class="service-container">

                    <div class="service-header">
                        <h5 style="color: #070769; font-weight: 700;">{{ $serviceName ?? '' }}</h5>
                        <div class="rating">
                            <span class="rating-badge">4.82</span>
                            <span class="reviews" data-bs-toggle="modal" data-bs-target="#staticBackdrop1">1.4 M
                                reviews</span>
                        </div>
                    </div>
                    <div class="warranty-info " data-bs-toggle="modal" data-bs-target="">
                        <p class="warranty-icon">✔️ Omaa COVER</p>
                        <span style="font-size: 12px;">Verified quotes & 30 days
                            warranty</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <i
                            class="fa fa-arrow-right" aria-hidden="true"></i>
                    </div>
                    <div class="service-options">
                        <h4>Select a service</h4>
                        <div class="row">
                        @foreach ($packages as $titles)
    @if (isset($titles->servicetitle) && !empty($titles->servicetitle->service_title) && !empty($titles->servicetitle->image))
        <div class="col-md-6 col-sm-12 mb-3">
            <a href="javascript:void(0);" class="crd-text" data-target="#service-{{ $titles->id }}">
                <div class="category-item">
                    <img src="{{ asset('public/front/image/' . $titles->servicetitle->image) }}"
                         alt="img" class="img-fluid">
                </div>
                <span class="siz">{{ $titles->servicetitle->service_title ?? '' }}</span>
            </a>
        </div>
    @endif
@endforeach

                        </div>
                    </div>

                </section>

            </div>
            <div class="col-lg-8 col-md-8 col-sm-8">

                <hr>
                <div class="container">
                    <div class="row ">
                        <div class="col-lg-8 col-md-8 col-sm-8 card-container">

                            @if ($packages->isEmpty())
                            <!-- If no packages are available, show the message -->
                            <div class="cart-section">
                                <div class="cart-icon">🛒</div>
                                <div class="cart-text">No Packages Available</div>
                            </div>
                            @else
                            <!-- If packages are available, display them -->
                            @foreach ($packages as $package)
                            <div id="service-{{ $package->id }}" class="d-flex" style="border-bottom: none;">
                                <div class="details-section">
                                    <h5 class="">{{ $package->servicetitle->service_title ?? '' }}</h5>
                                    <div class="unit-price">₹{{ $package->price ?? '' }}</div>
                                    <div class="service-title">{{ $package->package ?? '' }}</div>
                                    <div class="rating-info" data-bs-toggle="modal" data-bs-target="#staticBackdrop1">
                                        ★ 4.82 (610K reviews)
                                    </div>
                                    <div>
                                        <span class="current-price">₹{{ $package->price ?? '0' }}</span>
                                        <span class="old-price">₹{{ $package->previous_price ?? 'N/A' }}</span><br>
                                        <span class="current-price">Warranty : {{ $package->warranty ?? '0' }}
                                        </span>
                                    </div>
                                    <div class="discount-info">
                                        ₹{{ number_format(($package->previous_price ?? 0) - ($package->price ?? 0), 2) }}
                                        off 2nd item onwards
                                    </div>

                                    <ul class="feature-list">
                                        <li>{{ $package->description ?? 'N/A' }}</li>
                                    </ul>
                                    <a href="#" class="details-link" data-bs-toggle="modal"
                                        data-bs-target="#staticBackdrop3" data-title="{{ $package->title }}"
                                        data-price="{{ $package->price }}" data-package="{{ $package->package }}"
                                        data-duration="{{ $package->time_duration }}"
                                        data-description="{{ $package->description }}"
                                        data-image="{{ asset('public/front/image/' . $package->image) }}">
                                        View details
                                    </a>
                                    <hr>
                                </div>


                                <!-- Button trigger modal -->
                                {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Launch demo modal
  </button> --}}

                                <div class="button-section">
                                    <div class="unit-image">
                                        <img src="{{ asset('public/front/image/' . $package->image) }}" alt="img"
                                            class="img-fluid">
                                        <h2 class="unit"></h2>
                                        <h5 class="unit1"></h5>
                                    </div>
                                    <div class="add-to-cart">
                                        <button class="add-button" data-bs-toggle="offcanvas"
                                            data-bs-target="#offcanvasBottom" aria-controls="offcanvasBottom"
                                            onclick="addItem({{ $package->id }}, '{{ $package->package }}', {{ $package->price }}, {{ $package->previous_price }},{{ $package->convenience_fee }},{{ $package->visiting_charge }},{{ $package->warranty }})">Add</button>
                                        <div class="quantity-control" id="quantity-control-{{ $package->id }}"
                                            style="display: none;">
                                            <button class="qt-btn" onclick="decrement({{ $package->id }})">-</button>
                                            <span class="quantity" id="quantity-{{ $package->id }}">1</span>
                                            <button class="qt-btn" onclick="increment({{ $package->id }})">+</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif

                            <script>
                            // Function to handle adding an item
                            function addItem(button, packageId) {
                                // Hide the "Add" button and show quantity controls
                                button.style.display = "none";
                                const quantityControl = document.getElementById(`quantity-control-${packageId}`);
                                quantityControl.style.display = "flex";
                            }

                            // Function to increment the quantity
                            function increment(button, packageId) {
                                const quantitySpan = document.getElementById(`quantity-${packageId}`);
                                let quantity = parseInt(quantitySpan.textContent);
                                quantitySpan.textContent = quantity + 1;
                            }

                            // Function to decrement the quantity
                            function decrement(button, packageId) {
                                const quantitySpan = document.getElementById(`quantity-${packageId}`);
                                let quantity = parseInt(quantitySpan.textContent);
                                if (quantity > 1) {
                                    quantitySpan.textContent = quantity - 1;
                                } else {
                                    // Hide the quantity controls and show the "Add" button again
                                    const quantityControl = document.getElementById(`quantity-control-${packageId}`);
                                    quantityControl.style.display = "none";
                                    const addButton = quantityControl.previousElementSibling;
                                    addButton.style.display = "inline-block";
                                }
                            }
                            </script>


                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="info-container">

                                <a href="#" style="text-decoration:none;">
                                    <div class="warranty-info " data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                        <p class="warranty-icon">✔️ Omaa </p>
                                        <span style="font-size: 12px;">Verified Rate
                                            Card.</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <i
                                            class="fa fa-arrow-right" aria-hidden="true"></i>
                                    </div>
                                </a>
                                <div class="cart-section" id="cart-container">

                                    <div class="empty-cart" id="empty-cart">
                                        <div class="cart-icon">🛒</div>
                                        <div class="cart-text">No Packages Available</div>
                                    </div>


                                    <form id="cart-form" action="{{ route('front.addtocart') }}" method="POST">
                                        @csrf
                                        <!-- Add CSRF token for security -->
                                        <div class="cart-details" id="cart-details" style="display: none;">
                                            <h3>Cart</h3>
                                            <ul id="cart-items"></ul>
                                            <div class="savings-info" id="savings-info"></div>
                                            <button type="submit" class="view-cart-button" id="view-cart-button">₹0 View
                                                Cart</button>
                                        </div>
                                    </form>



                                </div>

                                <script>
                                // Function to get current package ID from URL
                                function getPackageIdFromUrl() {
                                    const urlParts = window.location.pathname.split('/');
                                    return urlParts[urlParts.length - 1]; // Last part is the ID
                                }

                                // Store the current package ID in sessionStorage (if not already stored)
                                const currentPackageId = getPackageIdFromUrl();
                                const storedPackageId = sessionStorage.getItem('packageId');

                                // Check if the package ID has changed
                                if (storedPackageId && storedPackageId !== currentPackageId) {
                                    sessionStorage.removeItem('cart'); // Clear the cart if ID has changed
                                }

                                // Update the stored package ID
                                sessionStorage.setItem('packageId', currentPackageId);

                                // Rest of your cart logic
                                let cart = JSON.parse(sessionStorage.getItem('cart')) || [];

                                function saveCart() {
                                    sessionStorage.setItem('cart', JSON.stringify(cart));
                                }

                                function addItem(packageId, packageName, price, oldPrice, convenience_fee,
                                    visiting_charge, warranty) {
                                    const existingItem = cart.find(item => item.id === packageId);
                                    if (existingItem) {
                                        existingItem.quantity++;
                                    } else {
                                        cart.push({
                                            id: packageId,
                                            name: packageName,
                                            price,
                                            oldPrice,
                                            quantity: 1,
                                            convenience_fee,
                                            visiting_charge,
                                            warranty
                                        });
                                    }
                                    saveCart();
                                    updateCart();
                                }

                                function increment(packageId) {
                                    const item = cart.find(item => item.id === packageId);
                                    if (item) {
                                        item.quantity++;
                                        saveCart(); // Save the cart data
                                        updateCart();
                                    }
                                }

                                function decrement(packageId) {
                                    const item = cart.find(item => item.id === packageId);
                                    if (item) {
                                        if (item.quantity > 1) {
                                            item.quantity--;
                                        } else {
                                            cart = cart.filter(i => i.id !== packageId);
                                        }
                                        saveCart(); // Save the cart data
                                        updateCart();
                                    }
                                }

                                function updateCart() {
                                    const cartItems = document.getElementById('cart-items');
                                    const viewCartButton = document.getElementById('view-cart-button');
                                    const savingsInfo = document.getElementById('savings-info');
                                    const cartDetails = document.getElementById('cart-details');
                                    const emptyCart = document.getElementById('empty-cart');
                                    const cartForm = document.getElementById('cart-form');
                                    let totalAmount = 0;
                                    let totalOldAmount = 0;
                                    let savings = 0;

                                    // Clear the current cart items
                                    cartItems.innerHTML = '';

                                    // Check if cart is empty
                                    if (cart.length === 0) {
                                        cartDetails.style.display = 'none';
                                        emptyCart.style.display = 'block';
                                        return;
                                    } else {
                                        cartDetails.style.display = 'block';
                                        emptyCart.style.display = 'none';
                                    }

                                    // Populate the cart with items
                                    cart.forEach(item => {
                                        const listItem = document.createElement('li');
                                        listItem.className = 'cart-item';
                                        listItem.innerHTML = ` 
                          <div class="cart-item-title col">${item.name} </div>
           
                                   <div class="quantity-control ">
                               <button class="qt-btn" onclick="decrement(${item.id})">-</button>
                               <span class="quantity">${item.quantity}</span>
                               <button class="qt-btn" onclick="increment(${item.id})">+</button>
            </div>
            <div class="price-info col">
                <span class="current-price">₹${item.price * item.quantity}</span>
                <br>
                <span class="old-price">₹${item.oldPrice * item.quantity}</span>
            </div>
        `;
                                        cartItems.appendChild(listItem);

                                        totalAmount += item.price * item.quantity;
                                        totalOldAmount += item.oldPrice * item.quantity;

                                        // Append hidden fields to the form for submission
                                        const inputPackageId = document.createElement('input');
                                        inputPackageId.type = 'hidden';
                                        inputPackageId.name = 'cart[' + item.id + '][package_id]';
                                        inputPackageId.value = item.id;
                                        cartForm.appendChild(inputPackageId);

                                        const inputQuantity = document.createElement('input');
                                        inputQuantity.type = 'hidden';
                                        inputQuantity.name = 'cart[' + item.id + '][quantity]';
                                        inputQuantity.value = item.quantity;
                                        cartForm.appendChild(inputQuantity);

                                        const inputPrice = document.createElement('input');
                                        inputPrice.type = 'hidden';
                                        inputPrice.name = 'cart[' + item.id + '][price]';
                                        inputPrice.value = item.price;
                                        cartForm.appendChild(inputPrice);

                                        const inputOldPrice = document.createElement('input');
                                        inputOldPrice.type = 'hidden';
                                        inputOldPrice.name = 'cart[' + item.id + '][old_price]';
                                        inputOldPrice.value = item.oldPrice;
                                        cartForm.appendChild(inputOldPrice);

                                        const inputconvenience_fee = document.createElement('input');
                                        inputconvenience_fee.type = 'hidden';
                                        inputconvenience_fee.name = 'cart[' + item.id + '][convenience_fee]';
                                        inputconvenience_fee.value = item.convenience_fee;
                                        cartForm.appendChild(inputconvenience_fee);

                                        const inputvisiting_charge = document.createElement('input');
                                        inputvisiting_charge.type = 'hidden';
                                        inputvisiting_charge.name = 'cart[' + item.id + '][visiting_charge]';
                                        inputvisiting_charge.value = item.visiting_charge;
                                        cartForm.appendChild(inputvisiting_charge);

                                        const inputwarranty = document.createElement('input');
                                        inputwarranty.type = 'hidden';
                                        inputwarranty.name = 'cart[' + item.id + '][warranty]';
                                        inputwarranty.value = item.warranty;
                                        cartForm.appendChild(inputwarranty);
                                    });

                                    savings = totalOldAmount - totalAmount;

                                    // Update the cart total and savings message
                                    viewCartButton.textContent = `₹${totalAmount} View Cart`;
                                    if (savings > 0) {
                                        savingsInfo.textContent = `🎉 Congratulations! ₹${savings} saved so far!`;
                                    } else {
                                        savingsInfo.textContent = '';
                                    }

                                    saveCart(); // Save the updated cart data
                                }

                                updateCart();
                                </script>

                                <div class="offer-section">
                                    <div class="offer-title">Buy more save more</div>
                                    <div class="offer-details">₹100 off 2nd item onwards</div>
                                    <a href="#" class="offer-link">View More Offers ▼</a>
                                </div>
                                <div class="promise-section">
                                    <div class="promise-title">OC Promise</div>
                                    <div class="d-flex">
                                        <ul class="promise-list">
                                            <li><span class="promise-icon">✔️</span> Verified Professionals</li>
                                            <li><span class="promise-icon">✔️</span> Hassle Free Booking</li>
                                            <li><span class="promise-icon">✔️</span> Transparent Pricing</li>
                                        </ul>
                                        <div class="p-3"><img src="image/qu.webp" alt=""></div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop3" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="details-section">
                    <div class="unit-price" id="modal-price"></div>
                    <div class="service-title" id="modal-package"></div>

                    <div>
                        <span class="current-price" id="modal-current-price"></span>
                        <span class="old-price" id="modal-old-price"></span>
                        <span class="service-duration" id="modal-duration"></span>
                    </div>
                    <div class="discount-info" id="modal-discount"></div>
                </div>

                <h1>How it works</h1>
                <p><b>Pre-service checks</b></p>
                <p class="review-section"></p>

                <div class="moda mt-3">
                    <span class="rating">4.82</span>
                    <span>1.4M reviews</span>
                </div>
                <div class="review-stats">
                    <!-- Add your review stats here -->
                </div>
                <div class="review-section">
                    <!-- Add your reviews here -->
                </div>
            </div>
        </div>
    </div>
</div>


<script>
// Update modal content dynamically
$('#staticBackdrop3').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget); // The button that triggered the modal
    var title = button.data('title'); // Extract data attributes
    var price = button.data('price');
    var package = button.data('package');
    var duration = button.data('duration');
    var description = button.data('description');
    var image = button.data('image');

    // Update modal content
    var modal = $(this);
    modal.find('.modal-title').text(title);
    modal.find('#modal-price').text('₹' + price);
    modal.find('#modal-package').text(package);
    modal.find('#modal-duration').text('• ' + duration);
    modal.find('#modal-discount').text('Discounts available');
    modal.find('#modal-image').attr('src', image);
    modal.find('.review-section').text(description); // Assuming description goes in review section
});
</script>


<!-- Modal -->
<div class="modal fade " id="staticBackdrop1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body ">
                <div class="moda">
                    <span class="rating">4.82</span>
                    <span>1.4M reviews</span>
                </div>
                <div class="review-stats">
                    <div>
                        <span>5 ★</span>
                        <div class="review-bar">
                            <div class="review-bar-fill" style="width: 90%;"></div>
                        </div>
                        <span>1.3M</span>
                    </div>
                    <div>
                        <span>4 ★</span>
                        <div class="review-bar">
                            <div class="review-bar-fill" style="width: 20%;"></div>
                        </div>
                        <span>30K</span>
                    </div>
                    <div>
                        <span>3 ★</span>
                        <div class="review-bar">
                            <div class="review-bar-fill" style="width: 10%;"></div>
                        </div>
                        <span>13K</span>
                    </div>
                    <div>
                        <span>2 ★</span>
                        <div class="review-bar">
                            <div class="review-bar-fill" style="width: 7%;"></div>
                        </div>
                        <span>10K</span>
                    </div>
                    <div>
                        <span>1 ★</span>
                        <div class="review-bar">
                            <div class="review-bar-fill" style="width: 5%;"></div>
                        </div>
                        <span>35K</span>
                    </div>
                </div>
                <div class="review-section">
                    <span class="h-re">All reviews</span>
                    <button class="filter-button "
                        style="border : none; background-color:#FFFFFF ;color: blue;margin-left: 274px; "
                        onclick="toggleFilterPanel()">Filter</button>

                    <!-- Filter Panel -->
                    <div id="filterPanel" class="filter-panel">
                        <h4>Filter Options</h4>
                        <label><input type="checkbox"> Option 1</label><br>
                        <label><input type="checkbox"> Option 2</label><br>
                        <label><input type="checkbox"> Option 3</label><br>
                    </div>
                    <div>
                        <button class="tab-button" onclick="openTab('mostDetailed')">Most Detailed</button>
                        <button class="tab-button" onclick="openTab('inMyArea')">In My Area</button>
                        <button class="tab-button" onclick="openTab('frequentUsers')">Frequent Users</button>
                    </div>

                    <!-- tab open -->
                    <div id="mostDetailed" class="tab-content">
                        <h6>Most Detailed Reviews</h6>
                        <p class="st">Content for the most detailed reviews goes here...</p>
                    </div>

                    <div id="inMyArea" class="tab-content">
                        <h6>Reviews in My Area</h6>
                        <p class="st">Content for reviews in your area goes here...</p>
                    </div>

                    <div id="frequentUsers" class="tab-content">
                        <h6>Frequent Users</h6>
                        <p class="st">Content for frequent users' reviews goes here...</p>
                    </div>
                    <!-- tab open end-->

                    <div class="review-item">
                        <strong>Rajeev</strong> <span class="re"> 5 ★</span> <br>
                        <small>Nov 1, 2024 • For Split AC</small>
                        <p class="st">Excellent Service done by Nimesh Vasava. His simplicity was an added
                            advantage
                            during the service. Highly recommend!</p>
                    </div>

                    <div class="review-item">
                        <strong>Rajeev</strong> <span class="re"> 5 ★</span> <br>
                        <small>Nov 1, 2024 • For Split AC</small>
                        <p class="st">Excellent Service done by Nimesh Vasava. His simplicity was an added
                            advantage
                            during the service. Highly recommend!</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" style="max-width: 80%;">
        <div class="modal-content" style="border-radius:1px;">
            <div class="modal-header" style="
    background-color: black;
    color: white; border-radius: 1px;">
                <h5 class="modal-title" id="staticBackdropLabel">Rate Card</h5>
                <button type="button" class="" data-bs-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center">
                    <!-- Check if there are products to display -->
                    @if ($products->isEmpty())
                    <p class="text-center">Rate card not available</p>
                    @else

                    @foreach ($products as $subcategory_id => $subcategoryProducts)
                    <div class="subcategory-table">
                        <!-- Apply custom styling for the Subcategory ID heading -->
                        <p class="bg-dark text-white p-2">
                            {{ $subcategoryProducts->first()->subCategory->product_type ?? 'N/A' }}</p>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <!-- Add custom class for table header -->
                                <thead class="bg-dark text-white">
                                    <tr>
                                        <th>Item</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($subcategoryProducts as $value)
                                    <tr>
                                        <td>{{ $value->product_name ?? 'N/A' }}</td>
                                        <td>₹{{ number_format($value->price, 2) ?? '0.00' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endforeach
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade " id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="modal-body">
                <!-- First Card -->

            </div>
        </div>
    </div>

    <script>
    // JavaScript function to toggle the visibility of the filter panel
    function toggleFilterPanel() {
        var panel = document.getElementById("filterPanel");
        if (panel.style.display === "none" || panel.style.display === "") {
            panel.style.display = "block";
        } else {
            panel.style.display = "none";
        }
    }

    // Optional: Close the panel if clicked outside
    document.addEventListener("click", function(event) {
        var panel = document.getElementById("filterPanel");
        var button = document.querySelector(".filter-button");
        if (!panel.contains(event.target) && !button.contains(event.target)) {
            panel.style.display = "none";
        }
    });
    </script>

    <script>
    function openTab(tabId) {
        // Hide all tab contents
        var contents = document.getElementsByClassName('tab-content');
        for (var i = 0; i < contents.length; i++) {
            contents[i].classList.remove('active');
        }

        // Remove 'active' class from all buttons
        var buttons = document.getElementsByClassName('tab-button');
        for (var i = 0; i < buttons.length; i++) {
            buttons[i].classList.remove('active');
        }

        // Show the clicked tab's content and add 'active' class to the clicked button
        document.getElementById(tabId).classList.add('active');
        event.target.classList.add('active');
    }

    // Open the first tab by default
    document.addEventListener("DOMContentLoaded", function() {
        openTab('mostDetailed');
    });
    </script>

<script>
    // Adding click event listener for all service titles
    document.querySelectorAll('.crd-text').forEach(item => {
        item.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target'); // Get the target id
            const targetElement = document.querySelector(targetId); // Find the target element

            if (targetElement) {
                // Scroll the target element into view with smooth scroll behavior
                targetElement.scrollIntoView({ behavior: 'smooth', block: 'start' });

                setTimeout(() => {
                    window.scrollTo({
                        top: window.scrollY - 80, // Scroll 80px up
                        behavior: 'smooth' // Smooth scrolling
                    });
                }, 300); // Adjust delay (in milliseconds) to match scroll duration
            }
        });
    });
</script>
@endsection
 