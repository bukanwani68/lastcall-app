<?php

namespace App\Http\Controllers; 

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Stok makanan tidak mencukupi.');
        }

        $totalPrice = $product->discount_price * $request->quantity;
        $pickupCode = 'LC-' . strtoupper(Str::random(6));

        Order::create([
            'user_id'     => Auth::id(),
            'store_id'    => $product->store_id,
            'product_id'  => $product->id,
            'quantity'    => $request->quantity,
            'total_price' => $totalPrice,
            'pickup_code' => $pickupCode,
            'status'      => 'pending',
        ]);

        // Kurangi stok produk
        $product->decrement('stock', $request->quantity);

        return back()->with('success', 'Pesanan berhasil! Kode Pickup Anda: ' . $pickupCode);
    }
}