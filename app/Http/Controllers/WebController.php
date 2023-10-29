<?php

namespace App\Http\Controllers;

use App\Models\MajorCategory;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class WebController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        $major_category_names = MajorCategory::all()->pluck('name')->unique();
        $recently_products = Product::orderBy('created_at', 'DESC')->limit(4)->get();
        $recommend_products = Product::where('recommend', true)->limit(3)->get();

        return view('index', compact(
            'categories', 'major_category_names', 'recently_products',
            'recommend_products'
        ));
    }

}
