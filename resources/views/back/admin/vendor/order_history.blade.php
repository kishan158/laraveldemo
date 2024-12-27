@extends('back.admin.layout.app')
@section('content')
<div class="page-content fade-in-up">
    <div class="alert bg-white d-flex justify-content-between align-items-center">
        <h4>Partner Order History</h4><form action="{{ route('admin.vendor.order_history', $data->id) }}" method="GET" class="mb-3">
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


        <a href="{{route('admin.vendor.list')}}" class="btn btn-primary">Back</a>
    </div>

    <div class="col p-0">
    @foreach($orders as $data)
    <div class="col-md-12 col-lg-12 mb-4 p-0"> <!-- Adjust column width as needed -->
        <div class="card shadow-sm">
            <div class="card-body order" style="display:flex; justify-content:space-between;">
                <div >
                    <h5 class="card-title">Order ID: <strong>{{ $data->order_id ?? 'N/A' }} @if($data->revisite_status ==1)Re @endif</strong></h5>
                    
                    <p class="card-text">
                        Status: 
                        @if($data->status == 1)
                            <span class="badge bg-warning">Accepted</span>
                        @elseif($data->status == 3)
                            <span class="badge bg-success">Completed</span>
                        @endif
                    </p>
                </div>
                <div>
                    <!-- Pass the order_id to the route -->
                    <a href="{{ route('admin.vendor.orderhistory_show', $data->order_id) }}" class="btn btn-light">View</a>
                    <p class="card-text">Date: {{ \Carbon\Carbon::parse($data->created_at)->format('d-m-Y') }}</p>
                </div>
            </div>
        </div>
    </div>
@endforeach
    </div>
    <!-- Pagination -->
    <div class="mt-4">
        {{$orders->links('pagination::bootstrap-4')}}
    </div>



    @endsection