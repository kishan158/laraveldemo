@extends('back.admin.layout.app')
@section('content')
<div class="page-content fade-in-up">
    <div class="alert bg-white d-flex justify-content-between align-items-center">
        <h4>Partner List</h4>
        <form action="{{ route('admin.vendor.list') }}" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search by name or phone"
                    value="{{ request('search') }}" />
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>

    </div>

    <div class="ibox">

        <div class="row">
            <div class="col-xl-12">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">All Partner</div>
                    </div>
                    <div class="ibox-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Partner Name</th>
                                    <th>Partner Phone</th>
                                    <th>Recharge Amount</th>
                                    <th>Transaction Id</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $v)
                                <tr>
                                   
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$v->vendor->name ?? ''}}</td>
                                    <td>{{$v->vendor->phone ?? ''}}</td>
                                    <td>{{$v->amount ?? ''}}</td>
                                    <td>{{$v->transaction_id ?? ''}}</td>
                                    <td>
                                        @if($v->status == 'pending')
                                        <button class="btn btn-danger">Pending</button>
                                        @elseif($v->status == 'completed')
                                        <button class="btn btn-success">Completed</button>
                                        @elseif($v->status == 'failed')
                                        <button class="btn btn-warning">Failed</button>
                                        @else
                                        <span>N/A</span>
                                        @endif
                                    </td>

                                    <td>
                                        <!-- Action Dropdown Button -->
                                        <div class="btn-group">
                                            <button class="btn btn-success dropdown-toggle" data-toggle="dropdown"
                                                aria-expanded="false">Actions
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu" x-placement="bottom-start"
                                                style="position: absolute; transform: translate3d(0px, 33px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                <li>
                                                    <form action="{{ route('admin.recharge.updateStatus', $v->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="pending">
                                                        <button type="submit" class="dropdown-item">Pending</button>
                                                    </form>
                                                </li>
                                                <li>
                                                    <form action="{{ route('admin.recharge.updateStatus', $v->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="completed">
                                                        <button type="submit" class="dropdown-item">Accpect</button>
                                                    </form>
                                                </li>
                                                <li>
                                                    <form action="{{ route('admin.recharge.updateStatus', $v->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="failed">
                                                        <button type="submit" class="dropdown-item">Reject</button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
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