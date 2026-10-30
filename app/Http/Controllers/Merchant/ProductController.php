<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Tampilkan daftar produk milik toko merchant
    public function index()
    {
        $store = Store::where('user_id', Auth::id())->first();
        $products = $store ? Product::where('store_id', $store->id)->latest()->get() : collect();

        return view('merchant.products.index', compact('products', 'store'));
    }

    // Form Tambah Produk
    public function create()
    {
        $store = Store::where('user_id', Auth::id())->first();
        if (!$store) {
            return redirect()->route('merchant.store.index')->with('warning', 'Silakan isi profil toko terlebih dahulu!');
        }

        return view('merchant.products.create');
    }

    // Simpan Produk Baru
   public function store(Request $request)
    {
        // Cari toko milik merchant yang sedang login
        $store = Store::where('user_id', Auth::id())->first();

        if (!$store) {
            return redirect()->route('merchant.store.index')->with('error', 'Silakan lengkapi profil toko terlebih dahulu.');
        }

        // Validasi data input
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'normal_price'   => 'required|numeric',
            'discount_price' => 'required|numeric',
            'stock'          => 'required|integer',
            'image'          => 'nullable',
            'description'    => 'nullable|string',
        ]);

        // Olah upload gambar (file lokal maupun link URL)
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        } else {
            $validated['image'] = $request->image;
        }

        // Masukkan store_id
        $validated['store_id'] = $store->id;

        // Simpan ke database
        Product::create($validated);

        return redirect()->route('merchant.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }
}