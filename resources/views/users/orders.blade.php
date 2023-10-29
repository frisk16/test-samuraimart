@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <span>
                <a href="{{ route('mypage') }}">マイページ</a> > 注文履歴
            </span>

            <div class="container mt-4">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">注文番号</th>
                            <th scope="col">購入日時</th>
                            <th scope="col">合計金額</th>
                            <th scope="col">詳細</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->order_code }}</td>
                            <td>{{ $order->created_at }}</td>
                            <td>{{ $order->sales_amount }}</td>
                            <td>
                                <a href="{{ route('mypage.show_order', $order->order_code) }}">
                                    詳細を確認する
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $orders->links() }}
        </div>
    </div>
</div>

@endsection
