@extends('back.admin.layout.app')
@section('content')
<div class="page-content fade-in-up">
    <div class="alert bg-white d-flex justify-content-between align-items-center">
        <h4>Order History</h4>

        <form action="{{ route('admin.order.history') }}" method="GET" class="mb-3">
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
    <div class="col p-0">
        @foreach($data as $value)
        <div class="col-md-12 col-lg-12 mb-4 p-0"> <!-- Adjust column width as needed -->
            <div class="card shadow-sm">
                <div class="card-body order" style="display:flex; justify-content:space-between;">
                    <div >
                    <h5 class="card-title">Order ID: <strong>{{ $value->order_id ?? 'N/A' }} </strong></h5>
                  

                    
                    <p class="card-text">
                        Status: 
                        @if($value->status == 1)
                        <span class="badge bg-danger">Rejected</span>
                        @elseif($value->status == 3)
                        <span class="badge bg-success">Completed</span>
                        @endif
                    </p>
                    </div>
                  <div>
                  <a href="{{ route('admin.vendor.orderhistory_show', $value->order_id) }}">View</a>
                  <p class="card-text">Date: {{ \Carbon\Carbon::parse($value->created_at)->format('d-m-Y') }}</p>

                  </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <!-- Pagination -->
    <div class="mt-4">
    {{ $data->links('pagination::bootstrap-4') }}
    </div>

@endsection