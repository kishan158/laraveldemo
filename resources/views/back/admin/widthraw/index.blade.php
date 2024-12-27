@extends('back.admin.layout.app')
@section('content')
<div class="page-content fade-in-up">
    <div class="alert bg-white d-flex justify-content-between align-items-center">
        <h4>Widthraw List</h4>


    </div>

    <div class="ibox">

        <div class="row">
            <div class="col-xl-12">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Widthraw Request</div>
                    </div>
                    <div class="ibox-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Bank Name</th>
                                    <th>Account No</th>
                                    <th>Branch</th>
                                    <th>IFSC Code</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($data as $value)

                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$value->kyc->name ?? ''}}</td>
                                    <td>{{$value->kyc->bank_name ?? ''}}</td>
                                    <td>{{$value->account_no ?? ''}}</td>
                                    <td>{{$value->kyc->bank_branch ?? ''}}</td>
                                    <td>{{$value->kyc->bank_ifsc ?? ''}}</td>
                                    <td>{{$value->amount ?? ''}}</td>
                                    <td>
                                        <form action="{{ route('admin.widthraw.request.update', $value->id) }}"
                                            method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="btn btn-{{ $value->status == 1 ? 'success' : 'warning' }}"
                                                @if($value->status == 1) disabled @endif>
                                                @if($value->status == 0)
                                                Pending
                                                @elseif($value->status == 1)
                                                Success
                                                @else
                                                {{ $value->status ?? 'N/A' }}
                                                @endif
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