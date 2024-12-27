@extends('front.layout.app')
@section('content')
<div class="section">
    <div class="container p-5">
        <div class="row">
            <!-- Sidebar Section -->
            <div class="d-flex flex-column flex-shrink-0 p-3 bg-dark text-black"
                style="width: 250px; border-radius: 10px;">
                <a href="" class="text-decoration-none text-black mb-3">
                    <span class="fs-4">Dashboard</span>
                </a>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="{{route('user.front.dashboard')}}"
                            class="nav-link text-black {{ Request::is('dashboard') ? 'active' : '' }}">
                            <i class="bi bi-house-door"></i> Home
                        </a>
                    </li>
                    <li>
                        <a href="{{route('user.front.booking')}}"
                            class="nav-link text-black {{ Request::is('products*') ? 'active' : '' }}">
                            <i class="bi bi-box"></i> Booking
                        </a>
                    </li>
                    <li>
                        <a href="{{route('user.front.order.history')}}"
                            class="nav-link text-black {{ Request::is('orders*') ? 'active' : '' }}">
                            <i class="bi bi-cart"></i> Orders
                        </a>
                    </li>
                    <li>
                        <a href="{{route('user.front.profile')}}"
                            class="nav-link text-black {{ Request::is('users*') ? 'active' : '' }}">
                            <i class="bi bi-people"></i> Users
                        </a>
                    </li>
                    <li>
                    <a href="{{route('user.front.wallet')}}"
                        class="nav-link text-black {{ Request::is('wallet*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i> Wallet
                    </a>
                </li>
                <li>
                    <a href="{{route('user.front.widthrawHistory')}}"
                        class="nav-link text-black {{ Request::is('Widthraw*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i>Widthraw History
                    </a>
                </li>
                    <li>
                        <a href="{{route('user.front.setting')}}"
                            class="nav-link text-black {{ Request::is('settings') ? 'active' : '' }}">
                            <i class="bi bi-gear"></i> Settings
                        </a>
                    </li>
                </ul>
                <hr>
                <a href="{{ route('front.user.logout') }}" class="btn btn-danger">Logout</a>
            </div>

            <!-- Styling for Booking Heading -->

            <!-- Main Content Section -->
            <div class="col">
                <div class="p-4">
                    <div class="page-content fade-in-up">
                        <!-- Booking Header -->
                        <div class="alert user d-flex justify-content-between align-items-center">
                            <h4>Payment Summary</h4>
                        </div>
                        @if ($reviste->isNotEmpty() && in_array($reviste->first()->revisite_sent_status, [1, 2]))

                        <div class="container mt-4 p-4" style="background-color:#F7F7F7; border-radius:10px;">
                            @foreach ($reviste as $order)
                            <div class="mb-4 p-3">
                                <!-- Order Header -->
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h5 class="mb-1">Order ID: {{ $order->order_id ?? 'N/A' }}Re</h5>
                                    </div>
                                    <div>
                                        @if ($order->revisite_sent_status == 0 || $order->revisite_sent_status == 1)
                                        <a href="{{ route('user.front.bill_update.revisite', ['id' => $order->id, 'status' => 2]) }}"
                                            class="btn btn-sm btn-success me-2"
                                            onclick="return confirm('Are you sure you want to accept this bill?');">Accept</a>
                                        <a href="{{ route('user.front.bill_update.revisite', ['id' => $order->id, 'status' => 3]) }}"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure you want to reject this bill?');">Reject</a>
                                        @elseif ($order->revisite_sent_status == 2)
                                        <button class="btn btn-sm btn-success" disabled>Accepted</button>
                                        @elseif ($order->revisite_sent_status == 3)
                                        <button class="btn btn-sm btn-danger" disabled>Rejected</button>
                                        @endif
                                    </div>
                                </div>

                                @if ($order->revisite)
                                @php
                                $inspectionData = json_decode($order->revisite, true);
                                $totalPrice = 0;
                                $labourCost = 0;
                                $visitingCharge = 0;
                                $otherItems = [];

                                // Check if the first item has null values
                                $firstItemNull = isset($inspectionData[0]) &&
                                (empty($inspectionData[0]['item']) || empty($inspectionData[0]['value']));

                                foreach ($inspectionData as $inspection) {
                                if ($inspection['item'] === 'Labour Cost') {
                                $labourCost += $inspection['value'];
                                } elseif ($inspection['item'] === 'Visiting Charge') {
                                $visitingCharge += $inspection['value'];
                                } else {
                                $otherItems[] = $inspection;
                                }
                                }

                                // Calculate the total price based on the conditions
                                if ($firstItemNull) {
                                $totalPrice = $visitingCharge + array_sum(array_column($otherItems, 'value'));
                                $labourCost = 0; // Do not include Labour Cost
                                } else {
                                $totalPrice = $labourCost + array_sum(array_column($otherItems, 'value'));
                                $visitingCharge = 0; // Do not include Visiting Charge
                                }
                                @endphp

                                <!-- Visiting Charge -->
                                @if ($visitingCharge > 0)
                                <div class="d-flex justify-content-between border-bottom py-2">
                                    <div><strong>Visiting Charge</strong></div>
                                    <div>₹{{ number_format($visitingCharge, 2) }}</div>
                                </div>
                                @endif

                                <!-- Labour Cost -->
                                @if ($labourCost > 0)
                                <div class="d-flex justify-content-between border-bottom py-2">
                                    <div><strong>Labour Cost</strong></div>
                                    <div>₹{{ number_format($labourCost, 2) }}</div>
                                </div>
                                @endif

                                <!-- Other Items -->
                                @foreach ($otherItems as $item)
                                <div class="d-flex justify-content-between border-bottom py-2">
                                    <div>{{ $item['item'] ?? '---' }}</div>
                                    <div>₹{{ number_format($item['value'], 2) }}</div>
                                </div>
                                @endforeach

                                <!-- Total -->
                                <div class="text-end mt-3">
                                    <strong>Total: ₹{{ number_format($totalPrice, 2) }}</strong>
                                </div>

                                @else
                                <p>No inspection data available.</p>
                                @endif
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p>No revisite data available or invalid status.</p>
                        @endif



                        <div class="container mt-4 p-4" style="background-color:#F7F7F7; border-radius:10px;">
                            @if($userOrders->isNotEmpty() && $userOrders->every(function($order) { return $order->status
                            != 0; }))

                            @forelse ($userOrders as $order)
                            <div class="mb-4 p-3">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h5 class="mb-1"> {{ $order->order_id ?? 'N/A' }}</h5>
                                    </div>
                                    <div>
                                        <!-- Action Buttons -->
                                        @if($order->status == 0 || $order->status == 1)
                                        <a href="{{ route('user.front.bill_update', ['id' => $order->id, 'status' => 2]) }}"
                                            class="btn btn-sm btn-success me-2"
                                            onclick="return confirm('Are you sure you want to accept this bill?');">Accept</a>
                                        <a href="{{ route('user.front.bill_update', ['id' => $order->id, 'status' => 3]) }}"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure you want to reject this bill?');">Reject</a>
                                        @elseif($order->status == 2)
                                        <button class="btn btn-sm btn-success" disabled>Accepted</button>
                                        @elseif($order->status == 3)
                                        <button class="btn btn-sm btn-danger" disabled>Rejected</button>
                                        @endif
                                    </div>
                                </div>

                                @if ($order->bill)
                                @php
                                $inspectionData = json_decode($order->bill, true);
                                $totalOrderPrice = 0;
                                $firstItemNull = empty($inspectionData[0]['item']) ||
                                empty($inspectionData[0]['value']);
                                @endphp

                                @if (is_array($inspectionData))
                                <div class="mb-2">
                                    <strong>Items:</strong>
                                </div>
                                <div>
                                    @foreach ($inspectionData as $inspection)
                                    <div class="d-flex justify-content-between">
                                        @if(
                                        ($inspection['item'] !== 'Visiting Charge' || $firstItemNull) &&
                                        ($inspection['item'] !== 'Labour Cost' || !$firstItemNull)
                                        )
                                        <span>{{ $inspection['item'] ?? 'N/A' }}</span>
                                        <span>₹{{ number_format($inspection['value'], 2) }}</span>
                                        @php $totalOrderPrice += $inspection['value']; @endphp
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                                @else
                                <div>No data available.</div>
                                @endif

                                <div class="mt-3">
                                    <strong>Total Price:</strong> ₹{{ number_format($totalOrderPrice, 2) }}
                                </div>
                            </div>
                            @empty
                            <div class="text-center">No records found.</div>
                            @endforelse

                            @else
                            <p>No Estimate available.</p>
                            @endif


                        </div>
                        <div class="row">

                        @if($vendorOrders->filter(fn($vendor) => $vendor->status == 3)->isNotEmpty())
    <div class="mt-5 p-4 col-6 mx-auto" style="background-color:#F7F7F7; border-radius:10px;">
        <h5 class="mb-4 text-left" style=" font-size: 1.5rem; color: #333;">
            Partner Details</h5>

        @php
            $firstVendor = true;
        @endphp

        @foreach($vendorOrders->filter(fn($vendor) => $vendor->status == 3) as $vendor)
            @if($firstVendor)
                <div class="justify-content-between align-items-center mb-4">
                    <div>
                        @if($vendor->vendor->image)
                            <img src="{{ asset('storage/app/public/' . $vendor->vendor->image) }}" alt="Profile Image" class="img-fluid" width="80" style="border-radius: 50%; object-fit: cover;">
                        @endif
                    </div>
                    <div>
                        <p class="mb-1" style="color: #555;">
                            {{ $vendor->vendor->name ?? 'N/A' }} {{ $vendor->vendor->last_name ?? 'N/A' }}
                        </p>
                    </div>
                </div>
                @php
                    $firstVendor = false;
                @endphp
            @endif
        @endforeach
    </div>
@endif


@if($vendorOrders->filter(fn($vendor) => $vendor->status == 3)->isNotEmpty())
    <div class="mt-5 p-4 col-4 mx-auto" style="background-color:#F7F7F7; border-radius:10px;">
        <h5 class="mb-4 text-left" style="font-size: 1.5rem; color: #333;">
            Warranty Card
        </h5>

        {{-- Display warranty details --}}
        <p>Warranty: {{$reviste->first()->warranty ?? '0'}} months</p>

        {{-- Calculate expiry date and compare with the current date --}}
        @php
        $warrantyExpire = \Carbon\Carbon::parse($reviste->first()->warranty_expire);
        $currentDate = \Carbon\Carbon::now();
        @endphp

        {{-- Show warranty expiry and revisite form only if warranty has not expired --}}
        @if($currentDate->lessThanOrEqualTo($warrantyExpire))
            <p class="text-success">Warranty Expire: {{$warrantyExpire->format('Y-m-d')}}</p>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <form action="{{ route('user.front.revisite', $vendorOrders->first()->order_id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-secondary" style="border-radius:2px;">
                            Revisite
                        </button>
                    </form>
                </div>
            </div>
        @else
            <p class="text-danger">Warranty Expired</p>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    {{-- Disable the button after warranty expiry --}}
                    <button class="btn btn-secondary" style="border-radius:2px;" disabled>
                        Revisite (Expired)
                    </button>
                </div>
            </div>
        @endif
    </div>
@endif




                        </div>










                    </div>
                </div>
                <!-- Modal HTML Structure -->
                <div class="modal fade" id="invoiceModal" tabindex="-1" aria-labelledby="invoiceModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="invoiceModalLabel">Invoice Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Order ID Section -->
                                <div class="mb-3">
                                    <h6><strong>Order ID:</strong> <span id="modalOrderId"></span></h6>
                                </div>

                                <!-- Invoice Items Table -->
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Value</th>
                                        </tr>
                                    </thead>
                                    <tbody id="invoiceDetails">
                                        <!-- Dynamic content will be inserted here -->
                                    </tbody>
                                </table>

                                <!-- Charges -->
                                <div class="mt-3">
                                    <div><strong>Convenience Fee:</strong> ₹<span id="convenienceFee"></span></div>
                                    <div><strong>Visit Charge:</strong> ₹<span id="visitCharge"></span></div>
                                    <div><strong>Total Payable:</strong> ₹<span id="totalPayable"></span></div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>



            </div>

        </div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const invoiceModal = document.getElementById('invoiceModal');

        invoiceModal.addEventListener('show.bs.modal', (event) => {
            const button = event.relatedTarget; // Button that triggered the modal
            const orderId = button.getAttribute('data-order-id');
            const invoiceData = JSON.parse(button.getAttribute('data-invoice'));

            const modalOrderId = invoiceModal.querySelector('#modalOrderId');
            const modalInvoiceDetails = invoiceModal.querySelector('#invoiceDetails');
            const convenienceFeeEl = invoiceModal.querySelector('#convenienceFee');
            const visitChargeEl = invoiceModal.querySelector('#visitCharge');
            const totalPayableEl = invoiceModal.querySelector('#totalPayable');

            // Set the Order ID
            modalOrderId.textContent = orderId;

            let invoiceHtml = '';
            let totalValue = 0;

            if (Array.isArray(invoiceData.items)) {
                invoiceData.items.forEach(item => {
                    if (Array.isArray(item.inspection_data)) {
                        item.inspection_data.forEach(inspection => {
                            invoiceHtml +=
                                `<tr><td>${inspection.item}</td><td>₹${inspection.value}</td></tr>`;
                            totalValue += parseFloat(inspection.value);
                        });
                    }
                });
            }

            modalInvoiceDetails.innerHTML = invoiceHtml;

            const convenienceFee = parseFloat(invoiceData.convenienceFee) || 0;
            const visitCharge = parseFloat(invoiceData.visitCharge) || 0;
            convenienceFeeEl.textContent = convenienceFee.toFixed(2);
            visitChargeEl.textContent = visitCharge.toFixed(2);

            const totalPayable = totalValue + convenienceFee + visitCharge;
            totalPayableEl.textContent = totalPayable.toFixed(2);
        });
    });
    </script>
    <style>
    .modal-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }

    .modal-body {
        font-size: 14px;
        color: #495057;
    }

    .table th,
    .table td {
        padding: 10px;
        text-align: center;
    }

    .mt-3 {
        margin-top: 15px;
    }

    #submitInvoiceButton {
        background-color: #007bff;
        border-color: #007bff;
    }

    #submitInvoiceButton:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }
    </style>
    <style>
    .user {
        color: black;
        background-color: #F7F7F7;
        border-radius: 10px;
        padding: 24px 20px;
        text-align: center;
        border: none;
        cursor: pointer;
        display: inline-block;
        transition: background-color 0.3s ease;
        margin-top: -23px;
    }

    .bg-dark {
        --bs-bg-opacity: 1;
        background-color: #F7F7F7 !important;
        color: black;
    }

    .section {
        background: #ffffff;
    }

    .user1 {
        color: white;
        background-color: #607d8b;
        border-radius: 8px;
        padding: 1px 10px;
        margin-top: 10px;
    }

    .user1:hover {
        background-color: #384a52;
    }

    .tb-data {
        padding: 21px;
        background: white;
        border-radius: 4px;
    }

    a.nav-link {
        padding: 5px 22px !important;
        font-size: 15px;
    }
    </style>

    @endsection