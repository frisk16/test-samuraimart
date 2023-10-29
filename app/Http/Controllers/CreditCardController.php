<?php

namespace App\Http\Controllers;

use App\Models\CreditCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\StripeClient;

class CreditCardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $credit_datas = $user->credit_cards()->orderBy('created_at', 'DESC')->get();

        return view('users.show_credit', compact('user', 'credit_datas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $my_credit_cards = Auth::user()->credit_cards();
        if($my_credit_cards->get()->count() < 3) {
            $stripe = new StripeClient(env('STRIPE_SECRET_KEY'));
            $token = $request->input('stripeToken');
            $card_data = $stripe->tokens->retrieve($token)->card;

            if($my_credit_cards->where('brand', $card_data->brand)->where('card_number', 'LIKE', '%'.$card_data->last4)->first()) {
                return back()->with('error_msg', 'そのカードは既に登録されています');
            }

            $customer = $stripe->customers->create([
                'source' => $token,
                'email' => Auth::user()->email,
                'name' => Auth::user()->name,
            ]);

            $credit_card = new CreditCard();
            $credit_card->user_id = Auth::id();
            $credit_card->customer_id = $customer->id;
            $credit_card->email = Auth::user()->email;
            $credit_card->card_number = '**** **** **** ' . $card_data->last4;
            $credit_card->brand = $card_data->brand;
            $credit_card->cc_exp = $card_data->exp_month . '/' . $card_data->exp_year;
            $credit_card->save();

            return back()->with('success_msg', 'カードを追加しました');
        } else {
            return back()->with('error_msg', '登録できるカードは3枚までです');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CreditCard  $creditCard
     * @return \Illuminate\Http\Response
     */
    public function destroy(CreditCard $credit)
    {
        $stripe = new StripeClient(env('STRIPE_SECRET_KEY'));
        $stripe->customers->delete($credit->customer_id);

        CreditCard::find($credit->id)->delete();

        return back()->with('success_msg', 'カードを削除しました');
    }
}
