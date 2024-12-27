@extends('back.admin.layout.app')
@section('content')
<div class="page-content fade-in-up">
    <div class="alert bg-white d-flex justify-content-between align-items-center">
        <h4>List</h4>
        <a href="{{route('admin.service.create')}}" class="btn btn-primary">Add</a>

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
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th>Title</th>
                                    <th>Issue</th>
                                    <th> Rate Card</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach ($services as $service)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $service->service ?? 'N/A' }}</td>
                                    <td><img src="{{ asset('public/front/image/' . $service->image) }}"
                                            alt="{{ $service->name }}" class="img-fluid"></td>
                                    <td>{{ $service->status == 1 ? 'Enabled' : 'Disabled' }}</td>
                                    <td><a href="{{route('admin.service.title.list',$service->id)}}" class="btn btn-primary">Add Title</a></td>
                                    <td><a href="{{route('admin.issue.list',$service->id)}}" class="btn btn-primary">Add Issue</a></td>
                                    <td><a href="{{route('admin.product_type.list',$service->id)}}" class="btn btn-primary">Add Rate Card</a></td>

                                    <td><a href="{{ route('admin.service.edit', $service->id) }}"
                                            class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                        <form method="POST" action="{{ route('admin.service.delete', $service->id) }}"
                                            style="display: inline;"
                                            onsubmit="return confirm('Are you sure you want to delete this service?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fa fa-trash font-14"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                                </tr>

                            </tbody>
                        </table>
                        {{ $services->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection