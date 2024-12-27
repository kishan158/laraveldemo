@extends('back.admin.layout.app')
@section('content')
<div class="page-content fade-in-up">
    <div class="alert bg-white d-flex justify-content-between align-items-center">
        <h4>Issues List</h4>
        <div>
        <a href="{{ route('admin.issue.add', ['id' => $service->id]) }}" class="btn btn-primary" style="margin-bottom: 20px;">Add</a>
        <a href="{{ route('admin.service.list') }}" class="btn btn-primary" style="margin-bottom: 20px;">Back</a>
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
                                    <th>Issue Name</th>
                                    <th>Title</th>
                                    <th>Image</th>
                                    <th>Labour Cost</th>
                                    <th>Warranty</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach ($package as $p)
                                <tr>
                                    <td>{{ $loop->iteration}}</td>
                                    
                                    <td>{{ $p->package ?? 'N/A' }}</td>
                                    <td>{{$service_title->service_title ?? ''}}</td>
                                    <td><img src="{{ asset('public/front/image/' . $p->image) }}" alt="{{ $p->name }}"
                                            class="img-fluid" style="width:100px;"></td>
                                    <td>{{ $p->price ?? 'N/A' }}</td>
                                    <td>{{ $p->warranty ?? '0' }} Days</td>
                                    <td>{{ $p->status == 1 ? 'Enabled' : 'Disabled' }}</td>
                                    <td><a href="{{ route('admin.issue.edit', $p->id) }}" class="btn btn-primary"><i
                                                class="fa fa-edit"></i></a>
                                        <form method="POST" action="{{ route('admin.issue.delete', $p->id) }}"
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
                     

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection