<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CartController extends Controller
{
    // Tampilkan Keranjang Belanja Dikelompokkan per Toko
    public function index()
    {
        $cartItems = Cart::with(['product.store'])
            ->where('user_id', Auth::id())
            ->get();

        // Mengelompokkan item berdasarkan toko (store_id)
        $groupedCart = $cartItems->groupBy(function($item) {
            return $item->product->store_id;
        });

        return view('cart.index', compact('groupedCart'));
    }

    // Tambah Produk ke Keranjang
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

        // Cek jika produk sudah ada di keranjang, cukup update quantity
        $cart = Cart::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($cart) {
            $cart->increment('quantity', $request->quantity);
        } else {
            Cart::create([
                'user_id'    => Auth::id(),
                'product_id' => $product->id,
                'quantity'   => $request->quantity,
            ]);
        }

        return redirect('/cart')->with('success', 'Berhasil ditambahkan ke keranjang!');
    }

    // Hapus Item dari Keranjang
    public function destroy($id)
    {
        Cart::where('user_id', Auth::id())->where('id', $id)->delete();
        return back()->with('success', 'Item berhasil dihapus.');
    }

    // Process Checkout Split Order Per Toko
    public function checkout()
    {
        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();

        if ($cartItems->isEmpty()) {
            return redirect('/cart')->with('error', 'Keranjang belanja Anda kosong.');
        }

        // Kelompokkan item berdasarkan toko
        $groupedByStore = $cartItems->groupBy(function($item) {
            return $item->product->store_id;
        });

        \Illuminate\Support\Facades\DB::transaction(function () use ($groupedByStore) {
            foreach ($groupedByStore as $storeId => $items) {
                
                // 1. Buat 1 KODE PICKUP UNIK untuk SATU TOKO
                $pickupCode = 'LC-' . strtoupper(\Illuminate\Support\Str::random(6));

                foreach ($items as $item) {
                    $product = $item->product;

                    // Potong stok produk
                    $product->decrement('stock', $item->quantity);

                    // Simpan Order
                    $order = new Order();
                    $order->user_id     = Auth::id();
                    $order->store_id    = $storeId;
                    $order->product_id  = $product->id;
                    $order->quantity    = $item->quantity;
                    $order->total_price = $product->discount_price * $item->quantity;
                    $order->pickup_code = $pickupCode; // <-- Pakai kode pickup yang sama
                    $order->status      = 'pending';
                    $order->save();
                }
            }

            // Hapus keranjang
            Cart::where('user_id', Auth::id())->delete();
        });

        return redirect('/orders')->with('success', 'Pesanan berhasil dibuat! Produk dari toko yang sama dijadikan 1 struk.');
    }
}