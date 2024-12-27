@extends('back.vendor.layout.app')
@section('content')
<div class="page-content fade-in-up">
    <div class="alert bg-white d-flex justify-content-between align-items-center">
        <h4>My Wallet: {{$balance}} Balance</h4>
        <a href="{{route('vendor.wallet.recharge')}}" class="btn btn-primary">Add Balance</a>

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
                                    <th>Order ID</th>
                                    <th>Debit</th>
                                    <th>Date</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $item)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{ $item->order_id }}</td>

                                    <td>{{ $item->debit }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td>
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


    @endsection

