@extends('layouts.app')

@section('content')
<div class="container  d-flex justify-content-center mt-3">
    <div class="w-100">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1 class="">クレジットカード設定</h1>

                <hr>

                @if($credit_datas->first())
                    @foreach($credit_datas as $credit)
                    <div class="card mt-3">
                        <div class="card-header d-flex align-items-center">
                            <span>種類：</span>
                            <i class="text-success fa-2x {{ $credit->brand_icon }}"></i>
                            ｜{{ $credit->brand }}
                            <div class="ms-auto">
                                <a href="#" class="btn btn-danger fw-bold btn-sm" data-bs-toggle="modal" data-bs-target="#del_credit_modal{{ $credit->id }}">削除</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <p>Eメールアドレス： {{ $credit->email }}</p>
                            <p class="text-primary">カード番号： {{ $credit->card_number }}</p>
                            <p class="text-primary">有効期限： {{ explode('/', $credit->cc_exp)[1] }}年／{{ explode('/', $credit->cc_exp)[0] }} 月</p>
                            <p>登録日： {{ $credit->created_at }}</p>
                        </div>
                    </div>

                    {{-- del_credit_modal --}}
                    <div class="modal fade" id="del_credit_modal{{ $credit->id }}" tabindex="-1" data-keybord="false">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <div class="modal-title">
                                        以下のクレジットカードデータを削除します、よろしいですか？
                                    </div>
                                </div>
                                <div class="modal-body">
                                    <div class="card mt-3">
                                        <div class="card-header d-flex align-items-center">
                                            <span>種類：</span>
                                            <i class="text-success fa-2x {{ $credit->brand_icon }}"></i>
                                            ｜{{ $credit->brand }}
                                            <div class="ms-auto">
                                                <a href="#" class="btn btn-danger fw-bold btn-sm" data-bs-toggle="modal" data-bs-target="#del_credit_modal{{ $credit->id }}">削除</a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <p>Eメールアドレス： {{ $credit->email }}</p>
                                            <p class="text-primary">カード番号： {{ $credit->card_number }}</p>
                                            <p class="text-primary">有効期限： {{ explode('/', $credit->cc_exp)[1] }}年／{{ explode('/', $credit->cc_exp)[0] }} 月</p>
                                            <p>登録日： {{ $credit->created_at }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <form action="{{ route('credit_card.destroy', $credit) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <span class="btn btn-secondary" data-bs-dismiss="modal">閉じる</span>
                                        <button type="submit" class="btn btn-danger">削除する</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                @endforeach
                    @if($credit_datas->count() < 3)
                    <form action="{{ route('credit_card.store') }}" method="post" class="mt-3">
                        @csrf
                        <script
                            src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                            data-key="{{ env('STRIPE_PUBLIC_KEY') }}"
                            data-name="クレジットカード情報を登録"
                            data-email="{{ $user->email }}"
                            data-label="カード情報の追加"
                            data-panel-label="カードを登録する"
                            data-description="登録できるカードは3枚までです"
                            data-image="{{ asset('img/credit_card.png') }}"
                            data-locale="auto"
                            data-currency="jpy"
                        >
                        </script>
                    </form>
                    @else
                    <button class="btn btn-secondary fw-bold mt-3 disabled">これ以上は追加できません</button>
                    @endif
                @else
                <h5 class="text-center">
                    <i class="fa-5x fa-solid fa-triangle-exclamation"></i>
                    <p class="mt-3">カードデータは未登録です</p>
                    <form action="{{ route('credit_card.store') }}" method="post">
                        @csrf
                        <script
                            src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                            data-key="{{ env('STRIPE_PUBLIC_KEY') }}"
                            data-name="クレジットカード情報を登録"
                            data-email="{{ $user->email }}"
                            data-label="カード情報の追加"
                            data-panel-label="カードを登録する"
                            data-description="登録できるカードは3枚までです"
                            data-image="{{ asset('img/credit_card.png') }}"
                            data-locale="auto"
                            data-currency="jpy"
                        >
                        </script>
                    </form>
                </h5>
                @endif
            </div>
        </div>

        <hr>
    </div>
</div>
@endsection
