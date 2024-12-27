@extends('back.admin.layout.app')
@section('content')
<div class="page-content fade-in-up">
    <div class="alert bg-white d-flex justify-content-between align-items-center">
        <h4>Partner List</h4>
        <form action="{{ route('admin.vendor.list') }}" method="GET" class="mb-3">
    <div class="input-group">
        <input 
            type="text" 
            name="search" 
            class="form-control" 
            placeholder="Search by name or phone" 
            value="{{ request('search') }}" 
        />
        <button type="submit" class="btn btn-primary">Search</button>
    </div><br>
</form>

    </div>
    <div class="ibox">

        <div class="row">
            <div class="col-xl-12">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">All Partner</div>
                        <a href="{{ route('admin.vendor.add') }}" class="btn btn-primary">Add New Partner</a>
                    </div>
                    <div class="ibox-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($vendor as $v)
                                <tr>
                                 
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$v->name ?? ''}}</td>
                                    <td>{{$v->last_name ?? ''}}</td>
                                    <td>{{$v->phone ?? ''}}</td>

                                    <td>
                                        <div class="dropdown">
                                            <button
                                                class="btn btn-{{ $v->status == 1 ? 'success' : ($v->status == 0 ? 'danger' : 'danger') }} btn-sm dropdown-toggle"
                                                type="button" id="dropdownMenuButton_{{$v->id }}" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                @if ($v->status == 0)
                                                {{ __('Disable') }}
                                                @elseif ($v->status == 1)
                                                {{ __('Enable') }}
                                                @else

                                                @endif
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <!-- Accept Form -->
                                                <form action="{{ route('admin.vendor.status', $v->id) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="status" value="0">
                                                    <button type="submit"
                                                        class="dropdown-item">{{ __('Disable') }}</button>
                                                </form>

                                                <!-- Reject Form -->
                                                <form action="{{ route('admin.vendor.status', $v->id) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="status" value="1">
                                                    <button type="submit"
                                                        class="dropdown-item">{{ __('Enable') }}</button>
                                                </form>



                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-success dropdown-toggle" data-toggle="dropdown"
                                                aria-expanded="false">Actions
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu" x-placement="bottom-start"
                                                style="position: absolute; transform: translate3d(0px, 33px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                <li>
                                                    <a href="{{ route('admin.vendor.profile', $v->id) }}"
                                                        class="btn btn-primary dropdown-item">View Profile</a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('admin.vendor.cat', $v->id) }}"
                                                        class="btn btn-primary dropdown-item">Assign Cat</a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('admin.vendor.order_history', $v->id) }}"
                                                        class="btn btn-primary dropdown-item">Order History</a>
                                                </li>
                                               
                                            </ul>
                                        </div>
</td>



                                </tr>

                                @endforeach
                            </tbody>
                        </table>
                        {{ $vendor->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection