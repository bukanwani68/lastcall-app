<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil produk surplus yang stoknya lebih dari 0 beserta info tokonya
        $products = Product::with('store')->where('stock', '>', 0)->latest()->get();

        return view('welcome', compact('products'));
    }
}