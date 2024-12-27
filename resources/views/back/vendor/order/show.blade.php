@extends('back.vendor.layout.app')

@section('content')
<div class="page-content fade-in-up">
    <div class="alert bg-white d-flex justify-content-between align-items-center">
        <h4>Order Details</h4>
        <div>
            <a href="{{route('vendor.service.order')}}" class="btn btn-primary">Back</a>
            <a href="{{ route('vendor.order.invoice', $order->id) }}" target="_blank" class="btn btn-primary">Print</a>
        </div>

    </div>


    @php
    $cart = json_decode($order->order->cart, true);
    @endphp
    <div class="ibox">
        <div class="col-xl-12">

            <div class="ibox-head">
                <div>
                    <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#dynamicFieldsModal">
                        Estimate
                    </a>


                </div>

            </div>
            <div class="ibox-body">
                <div class="col">
                    <div class="col-md-8">
                        <strong>Order ID:</strong> {{ $order->order_id }}
                    </div>
                    <div class="col-md-8">
                        <strong>Customer Name:</strong> {{ $order->order->customer->name }}
                    </div>
                    <div class="col-md-8">
                        <strong>Total Price:</strong> {{ $order->order->total_price }}
                    </div>
                    <div class="col-md-8">
                        <strong>Address:</strong>
                        {{ $order->order->customer->address }},{{ $order->order->customer->city }},{{ $order->order->customer->pin_code }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="ibox col-xl-12">


            <div class="ibox-head">
                <div class="ibox-title">Cart Items</div>
            </div>
            <div class="ibox-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Service Name</th>
                            <th>Package Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Old Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($cart && is_array($cart))
                        @php
                        // Initialize variables to accumulate the convenience fee and visiting charge
                        $totalConvenienceFee = 0;
                        $totalVisitingCharge = 0;
                        @endphp

                        @foreach($cart as $index => $item)
                        @php
                        $package = \App\Models\Package::find($item['package_id']);
                        $packageName = $package ? $package->package : 'Package not found';
                        $serviceName = $package ? \App\Models\Service::find($package->service_id)->service ?? 'Service
                        not found' : 'Package not found';

                        // Accumulate the convenience fee and visiting charge
                        $totalConvenienceFee += $item['convenience_fee'] ?? 0;
                        $totalVisitingCharge += $item['visiting_charge'] ?? 0;
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{  $serviceName }}</td>
                            <td>{{ $packageName }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>{{ $item['price'] }}</td>
                            <td>{{ $item['old_price'] }}</td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="6">No items in cart</td>
                        </tr>
                        @endif

                        <!-- Extra Work and Price Added -->
                        @if($order->extra_work)
                        <tr>
                            <td colspan="3"><strong>Extra:</strong> {{ $order->extra_work }}</td>
                            <td><strong>Price Added :</strong> {{ $order->price_added }}</td>
                        </tr>
                        @endif
                    </tbody>

                    <!-- Table Footer with convenience fee and visiting charge -->



                </table>
            </div>


        </div>

        <div class="ibox col-xl-12">
            <div class="ibox-head">
                <div class="ibox-title">Estimate</div>

                @if ($bills->isNotEmpty() && $bills->first()->inspection_data)
                @foreach ($bills as $bill)
                <a href="{{ route('vendorOrder.order.bill.update', $bill->id) }}" class="btn btn-primary">
                Send to Customer
                </a>
                @endforeach
                @else
                <p>No estimate available</p> <!-- Optional message when no bills are available -->
                @endif
            </div>

            @if ($bills->isNotEmpty() && $bills->first()->inspection_data)
            <!-- Check if data exists -->
            <div class="ibox-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Order Id</th>
                            <th>Item</th>
                            <th>Value</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $totalPrice = 0;
                        $serialNumber = 1;
                        @endphp

                        @foreach($bills as $data)
                        {{-- Check if first item's item or value is null --}}
                        @php
                        $firstItemNull = empty($data->inspection_data[0]['item']) ||
                        empty($data->inspection_data[0]['value']);
                        @endphp

                        <tr>
                            <td>{{ $serialNumber++ }}</td>
                            <td>{{ $data->order_id ?? '---' }}</td>

                            <td>
                                @if(!empty($data->inspection_data))
                                @foreach($data->inspection_data as $inspection)
                                {{-- Display items based on conditions --}}
                                @if(
                                ($inspection['item'] !== 'Visiting Charge' || $firstItemNull) &&
                                ($inspection['item'] !== 'Labour Cost' || !$firstItemNull)
                                )
                                <div>{{ $inspection['item']  ?? '---'}}</div>
                                @endif
                                @endforeach
                                @else
                                No inspection data available.
                                @endif
                            </td>

                            <td>
                                @php $rowTotal = 0; @endphp
                                @foreach($data->inspection_data as $inspection)
                                {{-- Include items based on conditions --}}
                                @if(
                                ($inspection['item'] !== 'Visiting Charge' || $firstItemNull) &&
                                ($inspection['item'] !== 'Labour Cost' || !$firstItemNull)
                                )
                                <div>₹{{ number_format($inspection['value'], 2) }}</div>
                                @php $rowTotal += $inspection['value']; @endphp
                                @endif
                                @endforeach
                                @php $totalPrice += $rowTotal; @endphp
                            </td>

                            <td>
                                @if ($data->status == 1)
                                <span class="btn btn-secondary btn-sm">Pending</span>
                                @elseif ($data->status == 2)
                                <span class="btn btn-success btn-sm">Accepted</span>
                                @elseif ($data->status == 3)
                                <span class="btn btn-danger btn-sm">Rejected</span>
                                @else
                                <span class="btn btn-warning btn-sm">Unknown</span>
                                @endif
                            </td>
                        </tr>

                        @endforeach
                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="3"><strong>Total Price:</strong></td>
                            <td>₹{{ number_format($totalPrice, 2) }}</td>
                        </tr>
                        <tr style="background-color: yellow; font-weight: bold; font-size: 1.1em;">
                            <td colspan="3"><strong>Payable Amount:</strong></td>
                            <td>₹{{ number_format($totalPrice, 2) }}</td>
                        </tr>
                    </tfoot>


                </table>
                <form action="{{ route('vendor.service.order.payment', $data->id) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-3">
                            <label for="paymentMethod" class="form-label">Select Payment Method:</label>
                            <select name="payment_method" id="paymentMethod" class="form-control" required>
                                <option value="">-- Select Payment Method --</option>
                                <option value="cash">Cash</option>
                                <option value="online">Online</option>
                            </select>
                        </div>
                        <div class="mb-3 col-3">
                            <label for="totalPrice" class="form-label">Total Price:</label>
                            <input type="text" name="total_price" id="totalPrice"
                                value="{{ number_format($totalPrice, 2) }}" class="form-control" readonly>
                        </div>
                        <div class="col-3">
                            <button type="submit" class="btn btn-primary" style="margin-top:11%;">Pay</button>
                        </div>

                    </div>

                </form>
            </div>
            @endif
        </div>


        <!-- Reviste section  -->
        @if ($bills->isNotEmpty() && $bills->first()->revisite !== null)
        <div class="ibox col-xl-12">
            <div class="ibox-head">
                <div class="ibox-title">Revisite Estimate</div>


                <a href="{{ route('vendorOrder.order.bill.updateRevisite', $bills->first()->id) }}"
                    class="btn btn-primary">
                    Send to Customer
                </a>

            </div>
            @if($reviste->isNotEmpty() && $reviste->first()->inspection_data)
            <div class="ibox-body">
                <!-- Only display the table if reviste data is available -->

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Order Id</th>
                            <th>Item</th>
                            <th>Price</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php
                        $totalPrice = 0;
                        $serialNumber = 1;
                        @endphp

                        @foreach($reviste as $key =>  $data)
                        {{-- Check if first item's item or value is null --}}
                        @php
                        $firstItemNull = empty($data->inspection_data[0]['item']) ||
                        empty($data->inspection_data[0]['value']);
                        @endphp

                        <tr>
                            <td>{{ $serialNumber++ }}</td>
                            <td>{{ $data->order_id ?? '---' }}</td>

                            <td>
                                @if(!empty($data->inspection_data))
                                @foreach($data->inspection_data as $inspection)
                                {{-- Display items based on conditions --}}
                                @if(
                                ($inspection['item'] !== 'Visiting Charge' || $firstItemNull) &&
                                ($inspection['item'] !== 'Labour Cost' || !$firstItemNull)
                                )
                                <div>{{ $inspection['item']  ?? '---'}}</div>
                                @endif
                                @endforeach
                                @else
                                No inspection data available.
                                @endif
                            </td>

                            <td>
                                @php $rowTotal = 0; @endphp
                                @foreach($data->inspection_data as $inspection)
                                {{-- Include items based on conditions --}}
                                @if(
                                ($inspection['item'] !== 'Visiting Charge' || $firstItemNull) &&
                                ($inspection['item'] !== 'Labour Cost' || !$firstItemNull)
                                )
                                <div>₹{{ number_format($inspection['value'], 2) }}</div>
                                @php $rowTotal += $inspection['value']; @endphp
                                @endif
                                @endforeach
                                @php $totalPrice += $rowTotal; @endphp
                            </td>

                            <td>
                                @if ($bill->revisite_sent_status == 1)
                                <span class="btn btn-secondary btn-sm">Pending</span>
                                @elseif ($bill->revisite_sent_status == 2)
                                <span class="btn btn-success btn-sm">Accepted</span>
                                @elseif ($bill->revisite_sent_status == 3)
                                <span class="btn btn-danger btn-sm">Rejected</span>
                                @endif
                            </td>
                        </tr>

                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-right">Total:</th>
                            <th>₹{{ number_format($totalPrice, 2) }}</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>

                <form action="{{ route('vendor.service.order_re.payment', $data->id) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-3">
                            <label for="paymentMethod" class="form-label">Select Payment Method:</label>
                            <select name="payment_method" id="paymentMethod" class="form-control" required>
                                <option value="">-- Select Payment Method --</option>
                                <option value="cash">Cash</option>
                                <option value="online">Online</option>
                            </select>
                        </div>
                        <div class="mb-3 col-3">
                            <label for="totalPrice" class="form-label">Total Price:</label>
                            <input type="text" name="total_price" id="totalPrice"
                                value="{{ number_format($totalPrice, 2) }}" class="form-control" readonly>
                        </div>
                        <div class="col-3">
                            <button type="submit" class="btn btn-primary" style="margin-top:11%;">Pay</button>
                        </div>

                    </div>

                </form>
                @else
                <!-- Show message if no revisite data exists -->
                <div>No revisite data available.</div>

            </div>
            @endif
        </div>
        @else
        @endif


    </div>


    <!-- model  -->

    <div class="modal fade" id="dynamicFieldsModal" tabindex="-1" aria-labelledby="dynamicFieldsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dynamicFieldsModalLabel">Add Items and Values</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="dynamicForm" action="{{ route('vendorOrder.order.inspection.submit', $order->id) }}"
                        method="post">
                        @csrf
                        <div id="inputFieldsContainer">
                            <!-- Initial Input Row -->
                            <div class="row mb-3 align-items-center">
                                <div class="col-5">
                                    <select name="items[]" class="form-control product-select">
                                        <option value="">Select Product</option>
                                        @foreach($products as $product)
                                        <option value="{{ $product->product_name }}" data-price="{{ $product->price }}">
                                            {{ $product->product_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-5">
                                    <input type="number" name="values[]" class="form-control" placeholder="Value"
                                        required readonly>
                                </div>
                                <div class="col-2">
                                    <button type="button" class="btn btn-danger remove-field">-</button>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden Fields for Convenience Fee and Visiting Charge -->
                        <input type="hidden" name="convenience_fee" id="convenienceFee"
                            value="{{ $totalConvenienceFee }}">
                        <input type="hidden" name="visiting_charge" id="visitingCharge"
                            value="{{ $totalVisitingCharge }}">





                        <button type="button" class="btn btn-success" id="addFieldButton">+ Add Row</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="dynamicForm" class="btn btn-primary">Generate</button>
                </div>
            </div>
        </div>
    </div>


    <!-- invoice model  -->
    @if ($bills->isNotEmpty())
    <div class="modal fade" id="invoiceModal" tabindex="-1" aria-labelledby="invoiceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('bills.storeInvoice', ['id' => $bills->first()->id]) }}" method="POST"
                    id="invoiceForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="invoiceModalLabel">Invoice Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Item</th>
                                    <th>Value</th>
                                </tr>
                            </thead>
                            <tbody id="invoiceDetailsBody">
                                <!-- Dynamic content will be inserted here -->
                            <tfoot>
                                <tr>
                                    <td class="text-end"><strong>Service</strong></td>
                                    <td id="convenienceFee">{{  $serviceName }}</td>
                                    <td> ₹{{$item['price']  ?? 0 }}</td>
                                </tr>

                                <tr>
                                    <td colspan="2" class="text-end"><strong>Total Payable</strong></td>
                                    <td id="totalPayable">
                                        <strong>₹0.00</strong>
                                        <small>(₹{{ $item['price'] ?? 0 }})</small>
                                    </td>
                                </tr>
                            </tfoot>
                            </tbody>

                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit Invoice</button>
                    </div>
                    <input type="hidden" id="invoiceData" name="invoice_data">
                </form>
            </div>
        </div>
    </div>

    @else

    @endif


</div>
<style>
.modal-dialog.modal-dialog-end {
    transform: translateX(100%);
    transition: transform 0.3s ease-in-out;
}

.modal.show .modal-dialog.modal-dialog-end {
    transform: translateX(0);
}
</style>
<script>
document.addEventListener("DOMContentLoaded", () => {
    const container = document.getElementById("inputFieldsContainer");
    const addFieldButton = document.getElementById("addFieldButton");

    // Add event listener to populate price when a product is selected
    container.addEventListener("change", (e) => {
        if (e.target.classList.contains("product-select")) {
            const select = e.target;
            const priceField = select.closest(".row").querySelector("input[name='values[]']");
            const selectedOption = select.options[select.selectedIndex];
            const price = selectedOption.getAttribute("data-price");
            priceField.value = price; // Set price field with the selected product's price
        }
    });

    // Add new input row
    addFieldButton.addEventListener("click", () => {
        const row = document.createElement("div");
        row.className = "row mb-3 align-items-center";

        row.innerHTML = `
          <div class="col-5">
            <select name="items[]" class="form-control product-select" required>
              <option value="">Select Product</option>
              @foreach($products as $product)
                  <option value="{{ $product->product_name }}" data-price="{{ $product->price }}">
                      {{ $product->product_name }}
                  </option>
              @endforeach
            </select>
          </div>
          <div class="col-5">
            <input type="number" name="values[]" class="form-control" placeholder="Value" required readonly>
          </div>
          <div class="col-2">
            <button type="button" class="btn btn-danger remove-field">-</button>
          </div>
        `;

        container.appendChild(row);
    });

    // Remove input row
    container.addEventListener("click", (e) => {
        if (e.target.classList.contains("remove-field")) {
            e.target.closest(".row").remove();
        }
    });
});
</script>
<script>
document.addEventListener("DOMContentLoaded", () => {
    const invoiceDetailsBody = document.getElementById("invoiceDetailsBody");
    const convenienceFeeEl = document.getElementById("convenienceFee");
    const visitChargeEl = document.getElementById("visitCharge");
    const totalPayableEl = document.getElementById("totalPayable");
    const invoiceDataInput = document.getElementById("invoiceData");

    // Ensure totalPrice, convenienceFee, visitCharge are set
    let totalPrice = 0;


    document.querySelector('[data-bs-target="#invoiceModal"]').addEventListener("click", () => {
        const billsData = @json($bills);

        // Debugging: Check what is inside billsData
        console.log("Bills Data:", billsData);

        let rows = "";

        // Check if billsData is an array and has data
        if (!Array.isArray(billsData) || billsData.length === 0) {
            console.error("No data found in billsData.");
            return;
        }

        billsData.forEach((data) => {
            let orderTotal = 0;

            if (data.inspection_data && data.inspection_data.length > 0) {
                data.inspection_data.forEach((inspection) => {
                    const inspectionValue = inspection.value != null ? parseFloat(
                        inspection.value) : 0;

                    rows += `
                        <tr>
                            <td>${data.order_id || ""}</td>
                            <td>${inspection.item || "No Item"}</td>
                            <td>₹${inspectionValue.toFixed(2)}</td>
                        </tr>
                    `;
                    orderTotal += inspectionValue;
                });
            } else {
                rows += `
                    <tr>
                        <td>${data.order_id || ""}</td>
                        <td>No inspection data available.</td>
                        <td>₹0.00</td>
                    </tr>
                `;
            }

            // Add a row for the order total
            rows += `
                <tr>
                    <td colspan="2" class="text-end"><strong>Payable Amount</strong></td>
                    <td>₹${orderTotal.toFixed(2)}</td>
                </tr>
            `;

            totalPrice += orderTotal; // Add to overall total
        });

        // Update table body
        invoiceDetailsBody.innerHTML = rows;

        // Log values to ensure proper calculation
        console.log("Total Price:", totalPrice);


        // Update tfoot values
        const totalAmount = totalPrice;
        const itemPrice = @json($item['price'] ?? 0);
        console.log("Total Payable (with fee and charge):", totalAmount);

        // Update the "Total Payable" field
        totalPayableEl.innerHTML = `
            <strong>₹${totalAmount.toFixed(2)}</strong>
            <small>(₹${itemPrice.toFixed(2)})</small>
        `;
        // Prepare the invoice data
        const invoiceData = {
            items: billsData.map((data) => ({
                order_id: data.order_id,
                inspection_data: data.inspection_data.map((inspection) => ({
                    item: inspection.item,
                    value: inspection.value
                }))
            })),
            totalPayable: totalAmount
        };

        // Set hidden input value for form submission
        invoiceDataInput.value = JSON.stringify(invoiceData);
    });

    document.getElementById("submitInvoiceButton").addEventListener("click", function(e) {
        e.preventDefault();
        const form = document.getElementById("invoiceForm");
        form.submit();
    });
});
</script>
<!-- Bootstrap CSS -->
<!-- Bootstrap JS (with Popper.js for modals) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>



@endsection

                    