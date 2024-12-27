@extends('back.vendor.layout.app')
@section('content')
<div class="page-content fade-in-up">
    <div class="alert bg-white d-flex justify-content-between align-items-center">
        <h4>Partner Order List</h4>


    </div>

    <div class="row">
        <div class="col-xl-12">

            <div class="container mt-4 p-0">
                @if ($orders->isEmpty())
                <div class="alert alert-warning text-center">
                    No Job Today
                </div>
                @else
                @foreach($orders as $data)
                @if($data->status != 3)
                <div class="card mb-3">
                    <div class="card-header" style="display:flex; justify-content:space-between;">
                        <div>
                            <strong>Order ID: {{ $data->order_id ?? '' }}@if ($data->revisite_status != 0):Re @endif</strong>
                        </div>
                        <div class="d-flex">
    <span>
        <div class="">
            <!-- Conditionally display the Diagnose button based on status -->
            @if ($data->status != 0) <!-- Check if status is not 0 (Pending) -->
                <a href="{{ route('vendorOrder.otp.user', $data->id) }}"
                    class="btn btn-primary btn-sm" style="margin-right:3px;">Diagnose</a>
            @endif
        </div>
    </span>
    <span>
        <div class="dropdown">
            <button
                class="btn btn-{{ $data->status == 1 ? 'success' : ($data->status == 3 ? 'primary' : ($data->status == 0 ? 'warning' : 'danger')) }} btn-sm dropdown-toggle"
                type="button" id="dropdownMenuButton_{{ $data->id }}" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                @if ($data->status == 0)
                    {{ __('Pending') }}
                @elseif ($data->status == 1)
                    {{ __('Accept') }}
                @elseif ($data->status == 3)
                    {{ __('Done') }}
                @else
                    {{ __('Reject') }}
                @endif
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <!-- Accept Form -->
                <form action="{{ route('vendorOrder.updateStatus', $data->id) }}" method="POST"
                    style="display:inline;">
                    @csrf
                    <input type="hidden" name="status" value="1">
                    <button type="submit" class="dropdown-item">{{ __('Accept') }}</button>
                </form>

                <!-- Reject Form -->
                <form action="{{ route('vendorOrder.updateStatus', $data->id) }}" method="POST"
                    style="display:inline;">
                    @csrf
                    <input type="hidden" name="status" value="2">
                    <button type="submit" class="dropdown-item">{{ __('Reject') }}</button>
                </form>

                <!-- Done Form -->
                <form action="{{ route('vendorOrder.updateStatus', $data->id) }}" method="POST"
                    style="display:inline;">
                    @csrf
                    <input type="hidden" name="status" value="3">
                    <button type="submit" class="dropdown-item">{{ __('Done') }}</button>
                </form>
            </div>
        </div>
    </span>
</div>


                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <strong>Location:</strong>
                                <p class="m-0">{{ $data->order->address ?? '' }}</p>
                            
                            </div>
                            <div class="col">
                                <strong>User:</strong>
                                <p>{{ $data->order->customer->name ?? '' }}</p>
                            </div>
                            <div class="col">
                                <strong>Service:</strong>
                                @if($data->service)
                                <p>{{ $data->service->service }}</p>
                                @else
                                <p class="text-warning">No Service Found</p>
                                @endif
                            </div>


                            <div class="col">
                                <strong>Date:</strong>
                                <p>{{ \Carbon\Carbon::parse($data->order->date ?? '')->format('d-m-y') }}</p>
                            </div>
                            <div class="col">
                                <strong>Time:</strong>
                                <p>{{ \Carbon\Carbon::parse($data->order->time ?? '')->format('h:i A') }}</p>
                            </div>
                        </div>
                    </div>




                </div>
                @endif
                @endforeach
                @if ($orders->where('status', '!=', 3)->isEmpty())
                <div class="alert alert-warning text-center mt-3">
                    No Job Today
                </div>
                @endif
                @endif

                <!-- Pagination -->
                @if ($orders->isNotEmpty())
                <div class="mt-4">
                    {{ $orders->links('pagination::bootstrap-4') }}
                </div>
                @endif
            </div>


        </div>
    </div>



</div>

<script>

</script>


@endsection