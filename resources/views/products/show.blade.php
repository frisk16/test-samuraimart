@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-center">
    <div class="row w-75">
        <div class="col-5 offset-1">
            @if($product->image !== '')
                <img src="{{ asset($product->image) }}" class="w-100 img-fluid">
            @else
                <img src="{{ asset('img/dummy.png')}}" class="w-100 img-fluid">
            @endif
        </div>
        <div class="col">
            <div class="d-flex flex-column">
                <h1 class="">
                    {{$product->name}}
                </h1>
                <p class="">
                    {{$product->description}}
                </p>
                <hr>
                <p class="d-flex align-items-end">
                    ￥{{$product->price}}(税込)
                </p>
                <hr>
            </div>
            @auth
            <form method="POST" action="{{ route('shoppingcarts.store') }}" class="m-3 align-items-end">
                @csrf
                <input type="hidden" name="product_id" value="{{$product->id}}">
                <input type="hidden" name="name" value="{{$product->name}}">
                <input type="hidden" name="price" value="{{$product->price}}">
                <input type="hidden" name="carriage_flag" value="{{ $product->carriage_flag }}">
                <div class="form-group row">
                    <label for="quantity" class="col-sm-2 col-form-label">数量</label>
                    <div class="col-sm-10">
                        <input type="number" id="quantity" name="quantity" min="1" value="1" class="form-control w-25">
                    </div>
                </div>
                <div class="row">
                    <div class="col-7">
                        <button type="submit" class="btn samuraimart-submit-button w-100">
                            <i class="fas fa-shopping-cart"></i>
                            カートに追加
                        </button>
                    </div>
                    <div class="col-5">
                        <a href="{{ route('products.toggle_favorite', $product) }}" class="btn samuraimart-favorite-button text-favorite w-100">
                            <i class="fa-solid fa-heart"></i>
                            @if($myFavorite)
                                お気に入り解除
                            @else
                                お気に入り
                            @endif
                        </a>
                    </div>
                </div>
            </form>
            @endauth
        </div>

        <div class="offset-1 col-11">
            <hr class="w-100">
            <h3 class="float-left">カスタマーレビュー</h3>
        </div>

        <div class="offset-1 col-10">
            <!-- レビューを実装する箇所になります -->
            <div class="row">
                @foreach($reviews as $review)
                <div class="offset-md-5 col-md-5">
                    <h3 class="review-score-color">{{ str_repeat('★', $review->score) }}</h3>
                    <p class="h3">{{$review->content}}</p>
                    <label>{{$review->created_at}} {{$review->user->name}}</label>
                </div>
                @endforeach
            </div><br />

            @auth
            <div class="row">
                <div class="offset-md-5 col-md-5">
                    <form method="POST" action="{{ route('reviews.store') }}">
                        @csrf
                        <h4>評価</h4>
                        <select name="score" class="form-select m-2 review-score-color">
                            @for($i = 5; $i > 0; $i--)
                                <option value="{{ $i }}" class="review-score-color">{{ str_repeat('★', $i) }}</option>
                            @endfor
                        </select>
                        <h4>レビュー内容</h4>
                        <textarea name="content" class="form-control m-2 @error('content') is-invalid @enderror"></textarea>
                        @error('content')
                        <small class="invalid-feedback" role="alert">
                            {{ $message }}
                        </small>
                        @enderror
                        <input type="hidden" name="product" value="{{$product->id}}">
                        <button type="submit" class="btn samuraimart-submit-button ml-2 mt-3">レビューを追加</button>
                    </form>
                </div>
            </div>
            @endauth
        </div>
    </div>
</div>
@endsection
