@extends('back.vendor.layout.app')
@section('content')
<div class="page-content fade-in-up">
    <div class="alert bg-white d-flex justify-content-between align-items-center">
        <h4>Recharge List</h4>
        <a href="{{route('vendor.wallet.recharge')}}" class="btn btn-primary">Add balance</a>

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
                                    <th>Amount</th>
                                    <th>Transaction id</th>
                                    <th>Status</th>


                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $value)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{ $value->amount ?? 'N/A' }}</td>
                                    <td>{{ $value->transaction_id ?? 'N/A' }}</td>
                                    <td>
                                        @if($value->status == 'pending')
                                        <button class="btn btn-danger">Pending</button> <!-- Red button for pending -->
                                        @elseif($value->status == 'completed')
                                        <button class="btn btn-success">Completed</button>
                                        <!-- Green button for completed -->
                                        @elseif($value->status == 'failed')
                                        <button class="btn btn-warning">Failed</button>
                                        <!-- Yellow/orange button for failed -->
                                        @else
                                        <span>N/A</span> <!-- Default text if status is not set -->
                                        @endif
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