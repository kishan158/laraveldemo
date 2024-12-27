@extends('back.admin.layout.app')
@section('content')
<div class="page-content fade-in-up">
    <div class="alert bg-white d-flex justify-content-between align-items-center">
        <h4>Page List</h4>
        <a href="{{route('admin.back.page.add')}}" class="btn btn-primary">Add</a>

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
                            <th>Page</th>
                         
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @foreach ($data as $p)
                        <tr>
                            <td>{{ $loop->iteration}}</td>
                            <td>{{ $p->title ?? 'N/A' }}</td>
                            
                        
                          
                            <td><a href="{{ route('admin.back.page.edit', $p->id) }}" class="btn btn-primary"><i
                                        class="fa fa-edit"></i></a>
                                <form method="POST" action="{{ route('admin.page.delete', $p->id) }}"
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
                {{ $data->links('pagination::bootstrap-4') }}

            </div>
        </div>
    </div>
</div>
</div>


</div>
@endsection