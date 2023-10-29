@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <span>
                <a href="{{ route('mypage') }}">マイページ</a> > <a href="{{ route('mypage.orders') }}">注文履歴</a> > 注文履歴詳細
            </span>

            <h1 class="mt-3">注文履歴詳細</h1>

            <h4 class="mt-3">ご注文情報</h4>

            <hr>

            <div class="row">
                <div class="col-5 mt-2">
                    注文番号
                </div>
                <div class="col-7 mt-2">
                    {{ $order_info->order_code }}
                </div>

                <div class="col-5 mt-2">
                    注文日時
                </div>
                <div class="col-7 mt-2">
                    {{ $order_info->created_at }}
                </div>

                <div class="col-5 mt-2">
                    合計金額
                </div>
                <div class="col-7 mt-2">
                    {{ $order_info->sales_amount }}円
                </div>

                <div class="col-5 mt-2">
                    合計数量
                </div>
                <div class="col-7 mt-2">
                    {{ $order_info->total_quantity }}
                </div>
            </div>

            <hr>

            <div class="row">
                @foreach ($orders as $order)
                <div class="col-md-5 mt-2">
                    <a href="{{route('products.show', $order->product_id)}}" class="ml-4">
                        @if ($order->product->image)
                        <img src="{{ asset($order->product->image) }}" class="img-fluid w-75">
                        @else
                        <img src="{{ asset('img/dummy.png')}}" class="img-fluid w-75">
                        @endif
                    </a>
                </div>
                <div class="col-md-7 mt-2">
                    <div class="flex-column">
                        <p class="mt-4">{{$order->product->name}}</p>
                        <div class="row">
                            <div class="col-2 mt-2">
                                数量
                            </div>
                            <div class="col-10 mt-2">
                                {{$order->quantity}}
                            </div>

                            <div class="col-2 mt-2">
                                小計
                            </div>
                            <div class="col-10 mt-2">
                                ￥{{$order->quantity * $order->product->price}}
                            </div>

                            <div class="col-2 mt-2">
                                送料
                            </div>
                            <div class="col-10 mt-2">
                                @if ($order->carriage_flag)
                                ￥800
                                @else
                                ￥0
                                @endif
                            </div>

                            <div class="col-2 mt-2">
                                合計
                            </div>
                            <div class="col-10 mt-2">
                                @if ($order->carriage_flag)
                                ￥{{($order->quantity * $order->product->price) + 800}}
                                @else
                                ￥{{$order->quantity * $order->product->price}}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection
