@extends('back.vendor.layout.app')
@section('content')
<div class="page-content fade-in-up">
    <div class="alert bg-white d-flex justify-content-between align-items-center">
        <h4>Provider List</h4>
        <a href="{{route('vendor.service.add')}}">Add</a>

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
                                    <th>Service</th>
                                    <th>Package</th>
                                    <th>Price</th>
                                    <th>City</th>
                                    <th>PinCode</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $service)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{ $service->service->service ?? 'N/A' }}</td>
                                    <!-- Assuming you have a relation with Service -->
                                    <td>{{ $service->package->package ?? 'N/A' }}</td>
                                    <!-- Assuming you have a relation with Package -->
                                    <td>{{ $service->price ?? 'N/A' }}</td>
                                    <td>{{ $service->city ?? 'N/A' }}</td>
                                    <td>{{ $service->pincode ?? 'N/A' }}</td>
                                    <td>{{ $service->status == 1 ? 'Enabled' : 'Disabled' }}</td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                        {{ $data->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection