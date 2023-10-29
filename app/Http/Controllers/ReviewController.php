<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Http\Requests\ReviewRequest;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReviewRequest $request)
    {
        $review = new Review();
        $review->product_id = $request->input('product');
        $review->user_id = Auth::id();
        $review->score = $request->input('score');
        $review->content = $request->input('content');
        $review->save();

        return back();
    }
}
