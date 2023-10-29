@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <h3 class="text-center">会員登録ありがとうございます！</h3>

            <p class="text-center">
                現在、仮会員の状態です。
            </p>

            <p class="text-center">
                ただいま、ご入力いただいたメールアドレス宛に、ご本人様確認用のメールをお送りしました。
            </p>

            <p class="text-center">
                メール本文内のURLをクリックすると本会員登録が完了となります。
            </p>

            <p class="text-center">
                もしメールが届かない、もしくは紛失した場合は以下のボタンから確認用メールの再送信を行ってください。
            </p>
            <div class="text-center">
                <form action="{{ route('verification.send') }}" method="post">
                    @csrf
                    <button type="submit" class="btn samuraimart-submit-button w-50 text-white">確認用メールの再送信</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
