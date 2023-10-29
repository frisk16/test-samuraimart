@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center mt-3">
    <div class="w-75">
        <h1>ショッピングカート</h1>

        <div class="row">
            <div class="offset-8 col-4">
                <div class="row">
                    <div class="col-6">
                        <h2>数量</h2>
                    </div>
                    <div class="col-6">
                        <h2>合計</h2>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="row">
            @foreach ($carts as $cart)
            <div class="col-md-2 mt-2">
                <a href="{{route('products.show', $cart->product_id)}}">
                    @if($cart->product->image !== '')
                        <img src="{{ asset($cart->product->image) }}" class="img-fluid w-100">
                    @else
                        <img src="{{ asset('img/dummy.png')}}" class="img-fluid w-100">
                    @endif
                </a>
            </div>
            <div class="col-md-6 mt-4">
                <h3 class="mt-4">{{$cart->name}}</h3>
            </div>
            <div class="col-md-2">
                <h3 class="w-100 mt-4">{{$cart->quantity}}</h3>
            </div>
            <div class="col-md-2">
                <h3 class="w-100 mt-4">￥{{$cart->quantity * $cart->price}}</h3>
            </div>
            @endforeach
        </div>

        <hr>

        <div class="offset-8 col-4">
            <div class="row">
                <div class="col-6">
                    <h2>送料</h2>
                </div>
                <div class="col-6">
                    <h2>￥{{ $carriage_cost }}</h2>
                </div>
            </div>
        </div>

        <hr>

        <div class="offset-8 col-4">
            <div class="row">
                <div class="col-6">
                    <h2>合計</h2>
                </div>
                <div class="col-6">
                    <h2>￥{{$total}}</h2>
                </div>
                <div class="col-12 d-flex justify-content-end">
                    表示価格は税込みです
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end mt-3">
            <a href="{{ route('products.index') }}" class="btn samuraimart-favorite-button border-dark text-dark mr-3">
                買い物を続ける
            </a>
            @if($total > 0)
                @if($credit_cards->count() > 0)
                    <div class="btn btn-primary text-white fw-bold" data-bs-toggle="modal" data-bs-target="#my-credit-payment-modal">登録済みのクレジットカードで支払う</div>
                @else
                    <div class="btn samuraimart-submit-button" data-bs-toggle="modal" data-bs-target="#buy-confirm-modal">購入を確定する</div>
                @endif
            @else
                <div class="btn samuraimart-submit-button disabled" data-bs-toggle="modal" data-bs-target="#buy-confirm-modal">購入を確定する</div>
            @endif
        </div>

        {{-- my-credit-payment-modal --}}
        <div class="modal fade" id="my-credit-payment-modal" tabindex="-1" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="modal-title">使用するカードを選択</div>
                    </div>
                    <form action="{{ route('shoppingcarts.buy') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            @foreach($credit_cards as $credit)
                            <label for="{{ $credit->id }}" class="w-100">
                                <div class="card mt-3">
                                    <div class="card-header d-flex align-items-center">
                                        <span>種類：</span>
                                        <i class="text-success fa-2x {{ $credit->brand_icon }}"></i>
                                        ｜{{ $credit->brand }}
                                        <div class="ms-auto">
                                            選択：
                                            <input type="radio" name="credit_id" id="{{ $credit->id }}" value="{{ $credit->id }}" required>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <p>Eメールアドレス： {{ $credit->email }}</p>
                                        <p class="text-primary">カード番号： {{ $credit->card_number }}</p>
                                        <p class="text-primary">有効期限： {{ explode('/', $credit->cc_exp)[1] }}年／{{ explode('/', $credit->cc_exp)[0] }} 月</p>
                                        <p>登録日： {{ $credit->created_at }}</p>
                                    </div>
                                </div>
                            </label>
                            @endforeach
                            <p class="mt-3 text-center fw-bold">購入を確定しますか？</p>
                        </div>
                        <div class="modal-footer">
                            <span class="btn btn-secondary" data-bs-dismiss="modal">閉じる</span>
                            <button type="submit" class="btn btn-primary text-white fw-bold">購入を確定する</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- buy-confirm-modal --}}
        <div class="modal fade" id="buy-confirm-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">購入を確定しますか？</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn samuraimart-favorite-button border-dark text-dark" data-bs-dismiss="modal">閉じる</button>
                        <form action="{{ route('shoppingcarts.buy') }}" method="post">
                            @csrf
                            <script
                                src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                data-key="{{ env('STRIPE_PUBLIC_KEY') }}"
                                data-amount="{{ $total }}"
                                data-name="支払いフォーム"
                                data-email="{{ Auth::user()->email }}"
                                data-label="購入を確定する"
                                data-description="クレジットカードのデータを入力してください"
                                data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                                data-locale="auto"
                                data-currency="JPY"
                            >
                            </script>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
