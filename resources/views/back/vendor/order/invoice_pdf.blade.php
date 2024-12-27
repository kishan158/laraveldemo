<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Order Invoice</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 20px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            width: 120px;
            margin-bottom: 10px;
        }

        .header h2 {
            margin: 0;
            font-size: 24px;
        }

        .ibox {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            background-color: #f9f9f9;
        }

        .ibox-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
            border-bottom: 2px solid #ddd;
            padding-bottom: 5px;
        }

        .table th,
        .table td {
            padding: 8px;
            text-align: left;
        }

        .footer {
            margin-top: 20px;
            font-size: 14px;
            text-align: right;
        }

        .small-text {
            font-size: 14px;
        }
    </style>
</head>

<body>
    <!-- Header Section with Logo -->
    <div class="header">
        <img src="{{ asset('path-to-your-logo/logo.png') }}" alt="Company Logo">
        <h2>OMAA COMPANY</h2>
    </div>

    <!-- Order and Company Details Section in a Row (using Bootstrap Grid) -->
    <div class="ibox  d-flex justify-content-between align-items-center">
       
            <div class="col-md-6">
                <h4>Order Details</h4>
                <p class="small-text"><strong>Order ID:</strong> {{ $order->order_id }}</p>
                <p class="small-text"><strong>Customer Name:</strong> {{ $order->order->customer->name }}</p>
                <p class="small-text"><strong>Total Price:</strong> ₹{{ $order->order->total_price }}</p>
                <p class="small-text"><strong>Address:</strong> {{ $order->order->customer->address }}, {{ $order->order->customer->city }}, {{ $order->order->customer->pin_code }}</p>
            </div>
            <div class="col-md-6">
                <h4>Company Details</h4>
                <p class="small-text"><strong>Company Name:</strong> OMAA COMPANY</p>
                <p class="small-text"><strong>Address:</strong> Noida</p>
                <p class="small-text"><strong>GSTIN:</strong> 1234567890</p>
            </div>
        
    </div>

    <!-- Service Description Table (using Bootstrap Table) -->
    <div class="ibox">
        <div class="ibox-title">Service Description</div>
        <table class="table table-bordered">
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
                    @foreach($cart as $index => $item)
                        @php
                            $package = \App\Models\Package::find($item['package_id']);
                            $packageName = $package ? $package->package : 'Package not found';
                            $serviceName = $package ? \App\Models\Service::find($package->service_id)->service ?? 'Service not found' : 'Service not found';
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $serviceName }}</td>
                            <td>{{ $packageName }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>₹{{ $item['price'] }}</td>
                            <td>₹{{ $item['old_price'] }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6">No items in cart</td>
                    </tr>
                @endif

                <!-- Extra Work Row -->
                @if($order->extra_work)
                    <tr>
                        <td colspan="4"><strong>Extra:</strong> {{ $order->extra_work }}</td>
                        <td colspan="2"><strong>Price Added:</strong> ₹{{ $order->price_added }}</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Total Price Section -->
    <div class="footer">
        <h3>Total Amount: ₹{{ $order->order->total_price + ($order->price_added ?? 0) }}</h3>
    </div>
</body>

</html>
