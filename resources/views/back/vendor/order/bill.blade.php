@extends('back.vendor.layout.app')
@section('content')

<div class="page-content fade-in-up">
    <div class="alert bg-white d-flex justify-content-between align-items-center">
        <h4>Venor Order List</h4>


    </div>

    <div class="ibox">

        <div class="row">
            <div class="col-xl-12">
                <div class="ibox">

                    <div class="ibox-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Order Id</th>
                                    <th>User</th>
                                    <th>Inspection Work</th> <!-- Displaying the Work -->
                                    <th>Inspection Price</th> <!-- Displaying the Price -->
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $totalPrice = 0; // Initialize total price counter
                                @endphp

                                @foreach($bills as $data)
                                <tr>
                                    <td>#</td>
                                    <td>{{ $data->order_id ?? '' }}</td>
                                    <td>{{ $data->user_id ?? '' }}</td>

                                    <!-- Displaying Inspection Work -->
                                    <td>
                                        @if($data->inspection_data)
                                        @foreach($data->inspection_data as $inspection)
                                        <div>
                                            <strong>Work:</strong> {{ $inspection['work'] }} <br>
                                        </div>
                                        @endforeach
                                        @else
                                        No inspection data available.
                                        @endif
                                    </td>

                                    <!-- Displaying Inspection Price -->
                                    <td>
                                        @php
                                        $rowTotal = 0; // Initialize row total
                                        @endphp
                                        @if($data->inspection_data)
                                        @foreach($data->inspection_data as $inspection)
                                        <div>
                                            {{ $inspection['price'] }} <br>
                                            @php
                                            $rowTotal += $inspection['price']; // Add to row total
                                            @endphp
                                        </div>
                                        @endforeach
                                        @else
                                        No inspection data available.
                                        @endif
                                        @php
                                        $totalPrice += $rowTotal; // Add row total to the global total
                                        @endphp
                                    </td>

                                    <td>
                                        @if($data->status == 0)
                                        <button class="btn btn-secondary">Pending</button>
                                        @elseif($data->status == 1)
                                        <button class="btn btn-warning">Sent</button>
                                        @elseif($data->status == 2)
                                        <button class="btn btn-success">Accepted</button>
                                        @elseif($data->status == 3)
                                        <button class="btn btn-danger">Rejected</button>
                                        @endif
                                    </td>

                                    <!-- Conditionally disable the "To User" button based on status -->
                                    <td>
                                        <a href="{{ route('vendorOrder.order.bill.update', $data->id) }}"
                                            class="btn btn-primary" @if(!in_array($data->status, [0, 1])) disabled
                                            @endif>
                                            To User
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>

                            <tfoot>
                                <tr>
                                    <td colspan="4"><strong>Total Price:</strong></td>
                                    <td> ₹{{ number_format($totalPrice, 2) }}</td>
                                </tr>
                            </tfoot>


                        </table>
                    </div>


                </div>
            </div>
        </div>
    </div>

</div>

@endsection