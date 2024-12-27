@extends('back.admin.layout.app')
@section('content')
<div class="page-content fade-in-up">
    <div class="alert bg-white d-flex justify-content-between align-items-center">
        <h4>QR List</h4>
        <a href="{{route('admin.qr_code.add')}}" class="btn btn-primary">Add</a>

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
                            <th>UPI ID</th>
                            <th>QR Code</th>
                       
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @foreach ($data as $value)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $value->upi_id ?? 'N/A' }}</td>
                            <td><img src="{{ asset('storage/app/public/' . $value->image) }}" alt="img" class="img-fluid" style="width: 100px; height: 100px;"></td>
                            <td>
            <a href="{{ route('admin.qr.edit', $value->id) }}" class="btn btn-warning btn-sm">Edit</a>
            <form action="{{route('admin.qr.delete',$value->id)}}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
            </form>
        </td>
                           
                        </tr>
                        @endforeach
                        </tr>

                    </tbody>
                </table>
               
            </div>
        </div>
    </div>
</div>
</div>

</div>

@endsection