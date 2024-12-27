@extends('back.admin.layout.app')
@section('content')
<div class="page-content fade-in-up">
    <div class="alert bg-white d-flex justify-content-between align-items-center">
        <h4>List</h4>
        <a href="{{route('admin.service.title.add',['id'=>$service->id])}}" class="btn btn-primary">Add</a>

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
                                    <th>Title</th>
                                    <th>Image</th>

                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($data as $value)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$value->service->service ?? ''}}</td>
                                    <td>{{$value->service_title ?? ''}}</td>
                                    <td><img src="{{ asset('public/front/image/' . $value->image) }}"
                                            alt="Service Image" style="max-height: 100px;"></td>
                                    <td><a href="{{ route('admin.service.title.Edit', $value->id) }}"
                                            class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                            <form method="POST" action="{{ route('admin.service.title.delete', $value->id) }}"
                                            style="display: inline;"
                                            onsubmit="return confirm('Are you sure you want to delete this service?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fa fa-trash font-14"></i>
                                            </button>
                                        </form></td>
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