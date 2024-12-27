@extends('back.admin.layout.app')
@section('content')
<div class="page-content fade-in-up">
    <div class="alert bg-white d-flex justify-content-between align-items-center">
        <h4>Order List</h4>
        <form action="{{ route('admin.order') }}" method="GET" class="mb-3">
    <div class="input-group">
        <input 
            type="text" 
            name="search" 
            class="form-control" 
            placeholder="Search by Order ID" 
            value="{{ request('search') }}" 
        />
        <button type="submit" class="btn btn-primary">Search</button>
    </div>
</form>

    </div>
    <div class="col-md-12 p-0">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">Transfer Job</div>
            </div>
            <div class="ibox-body">
           
    <div class="form-group">
        <label for="category">Select Category</label>
        <select name="category_id" id="category" class="form-control" required onchange="window.location.href='{{ url()->current() }}?category_id='+this.value">
            <option value="" selected disabled>Select a category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->category }}
                </option>
            @endforeach
        </select>
    </div>


<!-- Form for Order Submission -->
    <div id="availabilityMessage" class="text-info mt-2"></div>
    <form id="bulkTransferForm" action="{{ route('admin.transfer.admin') }}" method="POST">
        @csrf
        <input type="hidden" name="selected_orders" id="selectedOrders">

        <div class="form-group">
            <label for="partner">Select Partner</label>
            <select name="vendor_id" id="partner" class="form-control" required>
                <option value="" selected disabled>Select a partner</option>
                @foreach($vendors as $vendor)
                    <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-primary" type="submit">Submit</button>
    </form>
</div>
            </div>
        </div>

        <div class="ibox">
            <div class="ibox-head">

            </div>
            <div class="ibox-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>
                                    <!-- Checkbox to Select All -->
                                    <input type="checkbox" id="selectAll">
                                </th>
                                <th>Order ID</th>
                                <th>Service</th>
                                <th>Customer</th>
                                <th>Address</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Time Slot</th>
                                <th>Partner Status</th>
                                
                                <th>Status</th>
                              
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($data as $order)
                            <tr>

                               
                                    <!-- Concatenate order_id and customer_id -->
                                <td>
                                    <!-- Checkbox with order_id and customer_id as data attributes -->
                                    <input type="checkbox" class="order-checkbox" data-order-id="{{ $order->order_id }}"
                                        data-customer-id="{{ $order->customer_id }}">
                                </td>
                                <td><strong>{{ $order->order_id ?? '' }}</strong> </td>
                                <td>
        @php
            $cart = json_decode($order->cart, true); // Decode the cart JSON
            $packageData = [];  // Array to store package and service information
            
            // Loop through the cart and collect package_id, service_id, and service name
            foreach ($cart as $item) {
                if (isset($item['package_id'])) {
                    // Retrieve package from Package model using the package_id
                    $package = App\Models\Package::find($item['package_id']);
                    if ($package) {
                        // Retrieve service using service_id from the Service model
                        $service = App\Models\Service::find($package->service_id);
                        $packageData[] = [
                            'package_id' => $item['package_id'],
                            'service_name' => $service ? $service->service : 'N/A' // Get service name or 'N/A' if not found
                        ];
                    }
                }
            }
            
            // If there are any package-data, format it for display
            $packageDisplay = '';
            foreach ($packageData as $data) {
                $packageDisplay .= " {$data['service_name']}<br>";
            }

            // If no package data, show N/A
            $packageDisplay = $packageDisplay ?: 'N/A';
        @endphp
        <small>{!! $packageDisplay !!}</small>
    </td>

                                <td><small>{{$order->customer->name ?? ''}}</small></td>
                                <td><small>{{$order->address ?? ''}}</small></td>
                                <td><small>{{ $order->total_price ?? '' }}</small></td>
                                <td><small>{{ $order->date ?? '' }}</small></td>
                                <td><small>{{ $order->time ?? '' }}</small></td>
                               
                                <td>
                                    @if($order->status == 0)
                                    <button class="btn btn-secondary btn-sm">Pending</button>
                                    @elseif($order->status == 1)
                                    <button class="btn btn-success btn-sm">Accepted</button>
                                    @elseif($order->status == 2)
                                    <button class="btn btn-danger btn-sm">Rejected</button>
                                    @elseif($order->status == 3)
                                    <button class="btn btn-success btn-sm">Job Done</button>
                                    @else
                                    <button class="btn btn-secondary btn-sm">{{ $order->status }}</button>
                                    @endif
                                </td>
                                <td>
                                    @if($order->Order_status == "Transferred")
                                    <i class="fa fa-check text-success"></i>
                                    @elseif($order->Order_status == "Awating")
                                    <i class="fa fa-times text-danger"></i>

                                    @endif
                                </td>



                                <td>
                                    <!-- Delete Button -->
                                    <form action="{{ route('admin.order.delete', $order->id) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <!-- This is necessary to simulate the DELETE request -->

                                        <button type="submit" class="btn btn-danger btn-xs" data-toggle="tooltip"
                                            data-original-title="Delete">
                                            <i class="fa fa-trash font-14"></i>
                                        </button>
                                    </form>


                                </td>
                            </tr>
                            @endforeach
                        </tbody>


                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAllCheckbox = document.getElementById('selectAll');
        const orderCheckboxes = document.querySelectorAll('.order-checkbox');
        const bulkTransferForm = document.getElementById('bulkTransferForm');
        const selectedOrdersInput = document.getElementById('selectedOrders');

        // Handle "Select All" functionality
        selectAllCheckbox.addEventListener('change', function() {
            orderCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        // Handle form submission
        bulkTransferForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Collect selected orders (order_id and customer_id)
            const selectedOrders = Array.from(orderCheckboxes)
                .filter(checkbox => checkbox.checked)
                .map(checkbox => ({
                    order_id: checkbox.dataset.orderId,
                    customer_id: checkbox.dataset.customerId
                }));

            if (selectedOrders.length === 0) {
                alert('Please select at least one order.');
                return;
            }

            // Set the selected orders in the hidden input
            selectedOrdersInput.value = JSON.stringify(selectedOrders);

            // Submit the form
            this.submit();
        });
    });
    </script>
    <script>
    
    $('#partner').on('change', function () {
        let vendorId = $(this).val();
        let messageBox = $('#availabilityMessage');

        $.ajax({
            url: '{{ route('check.availability') }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                vendor_id: vendorId
            },
            success: function (response) {
                if (response.status === 'available') {
                    messageBox.removeClass('text-danger').addClass('text-success').text(response.message);
                } else {
                    messageBox.removeClass('text-success').addClass('text-danger').text(response.message);
                }
            },
            error: function () {
                messageBox.removeClass('text-success').addClass('text-danger').text('Error checking availability.');
            }
        });
    });

    </script>
    @endsection