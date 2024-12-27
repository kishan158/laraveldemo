@extends('back.admin.layout.app')

@section('content')
<div class="page-content fade-in-up">
    <div class="alert bg-white d-flex justify-content-between align-items-center">
        <h4>Category List</h4>
        <a href="{{route('admin.category.add')}}" class="btn btn-primary">Add Category</a>
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
                                    <th>Category Name</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $value)
                                <tr id="category-{{ $value->id }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $value->category ?? 'N/A' }}</td>
                                    <td><img src="{{ asset('public/category/image/' . $value->image) }}"
                                            alt="{{ $value->category }}" class="img-fluid"></td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{route('category.update.status',$value->id)}}" class="btn btn-primary">
                                                <i class="fa fa-cogs"></i> Update
                                            </a>
                                        </div>
                                        <form method="POST" action="{{ route('admin.category.delete', $value->id) }}"
                                    style="display: inline;"
                                    onsubmit="return confirm('Are you sure you want to delete this Category?');">
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



