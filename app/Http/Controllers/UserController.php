<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function mypage()
    {
        $user = Auth::user();

        return view('users.mypage', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = Auth::user();

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request)
    {
        $user = Auth::user();

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->postal_code = $request->input('postal_code');
        $user->address = $request->input('address');
        $user->phone = $request->input('phone');
        $user->update();

        return to_route('mypage');
    }

    public function edit_password()
    {
        return view('users.edit_password');
    }

    public function update_password(Request $request)
    {
        $user = Auth::user();

        if(! password_verify($request->input('current_password'), $user->password)) {
            return to_route('mypage.edit_password')->with('error_msg', '現在のパスワードと一致しません');
        }

        $request->validate([
            'password' => 'required|min:8|confirmed'
        ], [
            'password.required' => 'パスワードを入力してください',
            'password.min' => '最低 :min 文字以上で登録してください',
            'password.confirmed' => '確認用パスワードと一致しません'
        ]);

        $user->password = bcrypt($request->input('password'));
        $user->update();

        return to_route('mypage');
    }

    public function favorite()
    {
        $favorites = Auth::user()->favorites()->orderBy('created_at', 'DESC')->get();

        return view('users.favorite', compact('favorites'));
    }

    public function orders()
    {
        $orders = Auth::user()->earnings()->orderBy('created_at', 'DESC')->paginate(15);

        return view('users.orders', compact('orders'));
    }

    public function show_order(string $order_code)
    {
        $order_info = Auth::user()->earnings()->where('order_code', $order_code)->first();
        $orders = Auth::user()->orderhistories()->where('order_code', $order_code)->get();

        return view('users.show_order', compact('order_info', 'orders'));
    }

    public function deleted()
    {
        $user = Auth::user();

        $user->deleted = true;
        $user->update();
        Auth::logout();

        return redirect('/');
    }

}
