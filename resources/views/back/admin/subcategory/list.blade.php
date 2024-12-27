@extends('back.admin.layout.app')

@section('content')
<div class="page-content fade-in-up">
    <div class="alert bg-white d-flex justify-content-between align-items-center">
        <h4>Product  List</h4>
        <div>
        <a href="{{route('admin.product_type.add',['id' => $service->id])}}" class="btn btn-primary">Add Product</a>
        <a href="{{route('admin.service.list')}}" class="btn btn-primary">Back</a>
        </div>
       
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
            <th>Product Name </th>
            <th>Image</th>
            <th>Product Part</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $value)
        <tr >
            <td>{{ $loop->iteration }}</td>
            <td>{{ $value->product_type ?? 'N/A' }}</td> <!-- Display the Category Name -->
            <td><img src="{{ asset('public/category/image/' . $value->image) }}" alt="{{ $value->subcategory }}" class="img-fluid" style="width:100px;"></td>
            <td><a href="{{route('admin.Part.list',$value->id)}}" class="btn btn-primary">Add Part</a></td>
            <td>
                <div class="btn-group">
                    <a href="{{route('admin.product_type.edit',$value->id)}}" class="btn btn-primary">
                        <i class="fa fa-cogs"></i> Edit
                    </a>
                </div>
                <form method="POST" action="{{ route('admin.product_type.delete', $value->id) }}"
                                    style="display: inline;"
                                    onsubmit="return confirm('Are you sure you want to delete this Product Category?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fa fa-trash font-14"></i>
                                    </button>
                                </form>
            </td>
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



