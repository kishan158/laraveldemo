@extends('back.vendor.layout.app')
@section('content')
<div class="page-content fade-in-up">
    <div class="alert bg-white d-flex justify-content-between align-items-center">
        <h4>Order History View</h4>
        <a href="{{route('vendor.order.history')}}" class="btn btn-primary">Back</a>

    </div>

    <div class="page-content fade-in-up">
        <div class="row">
            <div class="col-lg-12 col-md-8">
                <div class="ibox">
                    <div class="ibox-body">
                        <ul class="nav nav-tabs tabs-line">
                            <!-- Order Details Tab -->
                            <li class="nav-item">
                                <a class="nav-link active" href="#tab-1" data-toggle="tab">
                                    <i class="ti-bar-chart"></i> Order Details
                                </a>
                            </li>

                            <!-- Order Estimate Tab -->
                            <li class="nav-item">
                                <a class="nav-link" href="#tab-2" data-toggle="tab">
                                    <i class="ti-bar-chart"></i> Order Estimate
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#tab-3" data-toggle="tab">
                                    <i class="ti-bar-chart"></i>Re visite Order Estimate
                                </a>
                            </li>

                        </ul>

                        <div class="tab-content">
                            <!-- Tab 1: Order Details -->
                            <div class="tab-pane fade show active" id="tab-1">
                                <!-- Order Details and Cart Items -->
                                <ul class="media-list media-list-divider m-0">
                                    <!-- Order ID -->
                                    <li class="media">
                                        <div class="media-img"><i class="ti-user font-18 text-muted"></i></div>
                                        <div class="media-body">
                                            <div class="media-heading text-success">Order ID</div>
                                            <div class="font-13">{{ $order->order_id ?? '' }}</div>
                                        </div>
                                        @if(!empty($paymentData))
                                        <div class="media-body">
                                            <div class="media-heading text-success">
                                                Payment:{{ ucfirst($paymentData['method'] ?? 'N/A') }}</div>
                                            <div class="font-13">₹ {{ $paymentData['total_price'] ?? 'N/A' }}</div>
                                        </div>
                                        @else
                                        <div class="media-body">
                                            <div class="media-heading text-success">No payment available.</div>

                                        </div>

                                        @endif
                                        <div class="media-body">
                                            <div class="media-heading text-success">Date</div>
                                            <div class="font-13">
                                                {{ \Carbon\Carbon::parse($order->date)->format('d-m-Y') }}</div>
                                        </div>
                                    </li>

                                    <!-- Product Issue, Quantity, Price, and Slot Time Headings -->
                                    <li class="media">
                                        <div class="media-body row">
                                            <div class="col-md-3">
                                                <div class="media-heading text-success">Product Issue</div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="media-heading text-success">Quantity</div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="media-heading text-success">Labour Cost</div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="media-heading text-success">Slot Time</div>
                                            </div>
                                        </div>
                                    </li>

                                    <!-- Cart Items -->
                                    @php
                                    $totalPrice = 0; // Initialize total value variable
                                    @endphp

                                    @if(!empty($cartItems))
                                    @foreach($cartItems as $item)
                                    @php
                                    $package = \App\Models\Package::find($item['package_id']);
                                    @endphp
                                    <li class="media">
                                        <div class="media-body row">
                                            <!-- Product Issue (Package Name) -->
                                            <div class="col-md-3">
                                                <div class="font-13">{{ $package->package ?? 'N/A' }}</div>
                                            </div>

                                            <!-- Quantity -->
                                            <div class="col-md-3">
                                                <div class="font-13">{{ $item['quantity'] ?? 'N/A' }}</div>
                                            </div>

                                            <!-- Price -->
                                            <div class="col-md-3">
                                                <div class="font-13">{{ $item['price'] ?? 'N/A' }}</div>
                                            </div>

                                            <!-- Slot Time -->
                                            <div class="col-md-3">
                                                <div class="font-13">{{ $order->time ?? 'N/A' }}</div>
                                            </div>
                                        </div>
                                    </li>

                                    @php
                                    // Add the current item price (quantity * price) to totalPrice
                                    $totalPrice += (float)$item['quantity'] * (float)$item['price'];
                                    @endphp
                                    @endforeach

                                    <!-- Total Price -->
                                   

                                    @else
                                    <li class="media">
                                        <div class="media-img"><i class="ti-email font-18 text-muted"></i></div>
                                        <div class="media-body">
                                            <div class="font-13">No cart items available.</div>
                                        </div>
                                    </li>
                                    @endif
                                </ul>
                            </div>

                            <!-- Tab 2: Order Estimate -->
                            <div class="tab-pane fade" id="tab-2">
                                <h5 class="text-info m-b-20 m-t-20"><i class="fa fa-bullhorn"></i> Order Estimate</h5>
                                <ul class="media-list media-list-divider m-0">
                                    <!-- Order ID -->
                                    <li class="media">
                                        <div class="media-img"><i class="ti-user font-18 text-muted"></i></div>
                                        <div class="media-body">
                                            <div class="media-heading text-success">Order ID</div>
                                            <div class="font-13">{{ $data->order_id ?? '' }}</div>
                                        </div>
                                    </li>

                                    <!-- Product Issue, Quantity, Date, and Slot Time Headings -->
                                    <li class="media">
                                        <div class="media-body row">
                                            <div class="col-md-3">
                                                <div class="media-heading text-success">Item</div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="media-heading text-success">Value</div>
                                            </div>
                                        </div>
                                    </li>

                                    <!-- Bill Data -->
                                    @if(!empty($billData))
                                    @php
                                    $totalValue = 0; // Initialize total value variable
                                    $labourCost = 0;
                                    $visitingCharge = 0;
                                    $otherItems = [];

                                    // Extract values from the data
                                    foreach ($billData as $index => $bill) {
                                    if ($bill['item'] === 'Labour Cost') {
                                    $labourCost += (float) $bill['value'];
                                    } elseif ($bill['item'] === 'Visiting Charge') {
                                    $visitingCharge += (float) $bill['value'];
                                    } elseif (!empty($bill['item']) && !empty($bill['value'])) {
                                    $otherItems[] = $bill;
                                    }
                                    }

                                    // Determine if the first item's item and value are null
                                    $firstItemNull = empty($billData[0]['item']) || empty($billData[0]['value']);

                                    // Calculate the total based on the condition
                                    if ($firstItemNull) {
                                    $totalValue += $visitingCharge; // Include Visiting Charge
                                    } else {
                                    $totalValue += $labourCost; // Include Labour Cost
                                    }

                                    // Add the values of other items to the total
                                    $totalValue += array_sum(array_column($otherItems, 'value'));
                                    @endphp

                                    <!-- Display Items -->
                                    @foreach($billData as $index => $bill)
                                    @php
                                    // Skip Labour Cost if first item is null
                                    if ($firstItemNull && $bill['item'] === 'Labour Cost') continue;

                                    // Skip Visiting Charge if first item is not null
                                    if (!$firstItemNull && $bill['item'] === 'Visiting Charge') continue;
                                    @endphp

                                    <li class="media">
                                        <div class="media-body row">
                                            <div class="col-md-3">
                                                <div class="font-13">{{ $bill['item'] ?? '---' }}</div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="font-13">{{ $bill['value'] ?? '---' }}</div>
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach

                                    <!-- Footer for Total Value -->
                                    <li class="media">
                                        <div class="media-body row">
                                            <div class="col-md-3">
                                                <div class="media-heading text-success">Total</div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="font-13">
                                                    <strong>{{ number_format( $totalValue, 2) }}</strong></div>
                                            </div>
                                        </div>
                                    </li>


                                    @else
                                    <li class="media">
                                        <div class="media-img"><i class="ti-email font-18 text-muted"></i></div>
                                        <div class="media-body">
                                            <div class="font-13">No Estimate available.</div>
                                        </div>
                                    </li>
                                    @endif
                                </ul>
                            </div>

                            <div class="tab-pane fade" id="tab-3">
                                <h5 class="text-info m-b-20 m-t-20"><i class="fa fa-bullhorn"></i> Order Estimate</h5>
                                <ul class="media-list media-list-divider m-0">
                                    <!-- Order ID -->
                                    <li class="media">
                                        <div class="media-img"><i class="ti-user font-18 text-muted"></i></div>
                                        <div class="media-body">
                                            <div class="media-heading text-success">Order ID</div>
                                            <div class="font-13">{{ $data->order_id ?? '' }}</div>
                                        </div>
                                        @if(!empty($RepaymentData))
                                        <div class="media-body">
                                            <div class="media-heading text-success">
                                                Payment:{{ ucfirst($RepaymentData['method'] ?? 'N/A') }}</div>
                                            <div class="font-13">₹ {{ $RepaymentData['total_price'] ?? 'N/A' }}</div>
                                        </div>
                                        @else
                                        <div class="media-body">
                                            <div class="media-heading text-success">No payment available.</div>

                                        </div>

                                        @endif
                                    </li>

                                    <!-- Product Issue, Quantity, Date, and Slot Time Headings -->
                                    <li class="media">
                                        <div class="media-body row">
                                            <div class="col-md-3">
                                                <div class="media-heading text-success">Item</div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="media-heading text-success">Value</div>
                                            </div>
                                        </div>
                                    </li>

                                    <!-- Bill Data -->
                                    @if(!empty($RebillData))
                                    @php
                                    $RetotalValue = 0; // Initialize total value variable
                                    $labourCost = 0;
                                    $visitingCharge = 0;
                                    $otherItems = [];

                                    // Extract values from the data
                                    foreach ($RebillData as $index => $rebill) {
                                    if ($rebill['item'] === 'Labour Cost') {
                                    $labourCost += (float) $rebill['value'];
                                    } elseif ($rebill['item'] === 'Visiting Charge') {
                                    $visitingCharge += (float) $rebill['value'];
                                    } elseif (!empty($rebill['item']) && !empty($rebill['value'])) {
                                    $otherItems[] = $rebill;
                                    }
                                    }

                                    // Determine if the first item's item and value are null
                                    $firstItemNull = empty($RebillData[0]['item']) || empty($RebillData[0]['value']);

                                    // Calculate the total based on the condition
                                    if ($firstItemNull) {
                                    $RetotalValue += $visitingCharge; // Include Visiting Charge
                                    } else {
                                    $RetotalValue += $labourCost; // Include Labour Cost
                                    }

                                    // Add the values of other items to the total
                                    $RetotalValue += array_sum(array_column($otherItems, 'value'));
                                    @endphp

                                    <!-- Display Items -->
                                    @foreach($RebillData as $index => $rebill)
                                    @php
                                    // Skip Labour Cost if first item is null
                                    if ($firstItemNull && $rebill['item'] === 'Labour Cost') continue;

                                    // Skip Visiting Charge if first item is not null
                                    if (!$firstItemNull && $rebill['item'] === 'Visiting Charge') continue;
                                    @endphp

                                    <li class="media">
                                        <div class="media-body row">
                                            <div class="col-md-3">
                                                <div class="font-13">{{ $rebill['item'] ?? '---' }}</div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="font-13">{{ $rebill['value'] ?? '---' }}</div>
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach

                                    <!-- Footer for Total Value -->
                                    <li class="media">
                                        <div class="media-body row">
                                            <div class="col-md-3">
                                                <div class="media-heading text-success">Total</div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="font-13">
                                                    <strong>{{ number_format($RetotalValue, 2) }}</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </li>


                                    @else
                                    <li class="media">
                                        <div class="media-img"><i class="ti-email font-18 text-muted"></i></div>
                                        <div class="media-body">
                                            <div class="font-13">No Estimate available.</div>
                                        </div>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <style>
        .profile-social a {
            font-size: 16px;
            margin: 0 10px;
            color: #999;
        }

        .profile-social a:hover {
            color: #485b6f;
        }

        .profile-stat-count {
            font-size: 22px;
        }
        </style>
    </div>

    @endsection