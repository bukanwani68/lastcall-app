<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Tampilkan daftar pesanan masuk dikelompokkan per Kode Pickup (Struk).
     */
    public function index()
    {
        $store = Store::where('user_id', Auth::id())->first();

        $orders = $store 
            ? Order::with(['user', 'product'])
                ->where('store_id', $store->id)
                ->latest()
                ->get()
                ->groupBy('pickup_code') // Grouping per Struk / Kode Pickup
            : collect();

        return view('merchant.orders.index', compact('orders', 'store'));
    }

    /**
     * Mengubah status SEMUA makanan dalam Kode Pickup menjadi Selesai.
     */
    public function complete($pickup_code)
    {
        Order::where('pickup_code', $pickup_code)->update(['status' => 'completed']);

        return back()->with('success', 'Pesanan [' . $pickup_code . '] berhasil diselesaikan!');
    }
}