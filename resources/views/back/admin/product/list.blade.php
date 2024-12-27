@extends('back.admin.layout.app')

@section('content')
<div class="page-content fade-in-up">
    <div class="alert bg-white d-flex justify-content-between align-items-center">
        <h4>Product List</h4>
        <div>
        <a href="{{route('admin.Part.add',['id'=>$subcategories->id])}}" class="btn btn-primary">Add Product</a>
 
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

                                    <th>Service Name</th>
                                    <th>Product Category</th>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $product)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{ $product->service->service ?? 'N/A' }}</td>
                                    <td>{{ $product->subCategory->product_type ?? 'N/A' }}</td>
                                    <td>{{$product->product_name ?? 'N/A'}}</td>
                                    <td>₹{{ $product->price ?? '' }}</td>
                                    <td><img src="{{ asset('storage/app/public/' . $product->image) }}"
                                            alt="{{ $product->product_name }}" class="img-fluid" style="width:100px;"></td>
                                            <td><a href="{{ route('admin.Part.edit', $product->id) }}" class="btn btn-primary"><i
                                        class="fa fa-edit"></i></a>
                                        <form method="POST" action="{{ route('admin.Part.delete', $product->id) }}"
                                    style="display: inline;"
                                    onsubmit="return confirm('Are you sure you want to delete this Product?');">
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


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection