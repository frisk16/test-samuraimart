@extends('layouts.app')

@section('content')
<div class="container  d-flex justify-content-center mt-3">
    <div class="w-75">
        <h1>お気に入り</h1>

        <hr>

        <div class="row">
            @foreach ($favorites as $fav)
            <div class="col-md-7 mt-2">
                <div class="d-inline-flex">
                    <a href="{{route('products.show', $fav->product_id)}}" class="w-25">
                        @if($fav->product->image !== '')
                            <img src="{{ asset($fav->product->image) }}" class="img-fluid w-100">
                        @else
                            <img src="{{ asset('img/dummy.png')}}" class="img-fluid w-100">
                        @endif
                    </a>
                    <div class="container mt-3">
                        <h5 class="w-100 samuraimart-favorite-item-text">{{$fav->product->name}}</h5>
                        <h6 class="w-100 samuraimart-favorite-item-text">&yen;{{$fav->product->price}}</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-2 d-flex align-items-center justify-content-end">
                <a href="{{ route('products.toggle_favorite', $fav->product_id) }}" class="samuraimart-favorite-item-delete">
                    削除
                </a>
            </div>
            <div class="col-md-3 d-flex align-items-center justify-content-end">
                <form action="{{ route('shoppingcarts.store') }}" method="post" class="m-3 align-items-end">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $fav->product_id }}">
                    <input type="hidden" name="name" value="{{ $fav->product->name }}">
                    <input type="hidden" name="price" value="{{ $fav->product->price }}">
                    <input type="hidden" name="carriage_flag" value="{{ $fav->product->carriage_flag }}">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="btn samuraimart-favorite-add-cart">カートに入れる</button>
                </form>
            </div>
            @endforeach
        </div>

        <hr>
    </div>
</div>
@endsection
