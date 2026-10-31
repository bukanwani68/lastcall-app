<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str; // <-- Tambahkan import ini di atas

class OrderController extends Controller
{
    /**
     * Menampilkan daftar pesanan milik pelanggan.
     */
    public function index()
    {
        $orders = Order::with(['product.store'])
        ->where('user_id', Auth::id())
        ->latest()
        ->get()
        ->groupBy('pickup_code'); // <-- Kelompokkan per Struk/Kode Pickup

    return view('orders.index', compact('orders'));
    }

    /**
     * Menampilkan Halaman Konfirmasi Pesanan.
     */
    public function confirm($product_id)
    {
        $product = Product::with('store')->findOrFail($product_id);

        if ($product->stock <= 0) {
            return redirect('/dashboard')->with('error', 'Maaf, stok produk ini sudah habis.');
        }

        return view('orders.confirm', compact('product'));
    }

    /**
     * Menyimpan Pesanan ke Database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Stok makanan tidak mencukupi!');
        }

        // 1. Potong stok produk
        $product->decrement('stock', $request->quantity);

        // 2. Simpan Order
        $order = new Order();
        $order->user_id     = Auth::id();
        $order->product_id  = $product->id;
        $order->store_id    = $product->store_id;
        $order->quantity    = $request->quantity;
        $order->total_price = $product->discount_price * $request->quantity;
        $order->pickup_code = 'LC-' . strtoupper(Str::random(6));
        $order->status      = 'pending'; // <-- Diubah ke 'pending' sesuai enum MySQL

        $order->save();

        return redirect('/orders')->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pickup di toko.');
    }

    public function complete($id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'completed';
        $order->save();

        return back()->with('success', 'Pesanan #' . $order->id . ' berhasil diselesaikan!');
    }
}