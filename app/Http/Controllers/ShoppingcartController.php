<?php

namespace App\Http\Controllers;

use App\Models\Shoppingcart;
use App\Models\Orderhistory;
use App\Models\Earning;
use App\Models\CreditCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\StripeClient;

class ShoppingcartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carts = Auth::user()->shoppingcarts()->orderBy('created_at', 'DESC')->get();
        $credit_cards = Auth::user()->credit_cards()->orderBy('created_at', 'DESC')->get();

        $total = 0;
        $has_carriage_cost = false;
        $carriage_cost = 0;
        foreach($carts as $cart) {
            $total += $cart->quantity * $cart->price;
            if($cart->carriage_flag) {
                $has_carriage_cost = true;
            }
        }

        if($has_carriage_cost) {
            $carriage_cost = env('CARRIAGE');
            $total += $carriage_cost;
        }

        return view('carts.index', compact('carts', 'total', 'carriage_cost', 'credit_cards'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cart = new Shoppingcart();

        $cart->user_id = Auth::id();
        $cart->product_id = $request->input('product_id');
        $cart->name = $request->input('name');
        $cart->quantity = $request->input('quantity');
        $cart->price = $request->input('price');
        $cart->carriage_flag = $request->input('carriage_flag');
        $cart->save();

        return to_route('products.show', $request->input('product_id'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shoppingcart  $shoppingcart
     * @return \Illuminate\Http\Response
     */
    public function buy(Request $request)
    {
        $carts = Auth::user()->shoppingcarts()->get();
        $order_code = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 15);

        $sales_amount = 0;
        $total_quantity = 0;
        $has_carriage_cost = false;
        // 注文履歴にデータ追加＆カート内削除
        foreach($carts as $cart) {
            $order = new Orderhistory();
            $order->user_id = Auth::id();
            $order->product_id = $cart->product_id;
            $order->order_code = $order_code;
            $order->name = $cart->name;
            $order->quantity = $cart->quantity;
            $order->carriage_flag = $cart->carriage_flag;
            $order->total_price = $cart->price * $cart->quantity;

            if($cart->carriage_flag) {
                $has_carriage_cost = true;
            }
            $sales_amount += $cart->price * $cart->quantity;
            $total_quantity += $cart->quantity;

            $order->save();
            $cart->delete();
        }

        // 送料金額追加
        $carriage_cost = env('CARRIAGE');
        if($has_carriage_cost) {
            $sales_amount += $carriage_cost;
        }

        // Stripe支払い処理
        $stripe = new StripeClient(env('STRIPE_SECRET_KEY'));
        if($request->has('credit_id')) {
            // 登録クレジット有り
            $customer_id = CreditCard::find($request->input('credit_id'))->customer_id;
            $stripe->charges->create([
                'description' => '注文コード：'.$order_code,
                'amount' => $sales_amount,
                'currency' => 'jpy',
                'customer' => $customer_id,
            ]);
        } else {
            // 登録クレジット無し
            $stripe->charges->create([
                'description' => '注文コード：'.$order_code,
                'amount' => $sales_amount,
                'currency' => 'jpy',
                'source' => $request->input('stripeToken'),
            ]);
        }


        // 売上データ追加
        $earning = new Earning();
        $earning->user_id = Auth::id();
        $earning->order_code = $order_code;
        $earning->sales_amount = $sales_amount;
        $earning->total_quantity = $total_quantity;
        $earning->save();

        return to_route('products.index')->with('success_msg', '購入が完了しました');
    }
}
