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

        // TAMBAHKAN BARIS RETURN INI:
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

    public function confirm($product_id)
    {
        $product = Product::with('store')->findOrFail($product_id);

        if ($product->stock <= 0) {
            return redirect('/dashboard')->with('error', 'Maaf, stok produk ini sudah habis.');
        }

        return view('orders.confirm', compact('product'));
    }
    
    // Simpan Produk Baru
    public function store(Request $request)
    {
        $store = Store::where('user_id', Auth::id())->first();

        if (!$store) {
            return redirect()->back()->with('error', 'Toko belum ditemukan. Silakan isi profil toko lebih dulu!');
        }

        // Validasi dengan kunci normal_price
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'normal_price'   => 'required|numeric|min:0', // <-- Ubah 'price' jadi 'normal_price'
            'discount_price' => 'required|numeric|min:0',
            'stock'          => 'required|integer|min:1',
            'description'    => 'nullable|string',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $validated['store_id'] = $store->id;

        Product::create($validated);

        return redirect('/merchant/products')->with('success', 'Produk surplus berhasil ditambahkan!');
    }

    // 1. Menampilkan Form Edit
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('merchant.products.edit', compact('product'));
    }

    // 2. Memproses Simpan Perubahan (Update)
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name'           => 'required|string|max:255',
            'normal_price'   => 'required|numeric|min:0',
            'discount_price' => 'required|numeric|min:0',
            'stock'          => 'required|integer|min:0',
            'description'    => 'nullable|string',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->only(['name', 'normal_price', 'discount_price', 'stock', 'description']);

        // Jika user mengunggah foto baru
        if ($request->hasFile('image')) {
            // Hapus foto lama dari storage jika ada
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            // Simpan foto baru
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect('/merchant/products')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // 1. Hapus file gambar dari storage jika produk memiliki gambar
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        // 2. Hapus data produk dari database
        $product->delete();

        // 3. Kembali ke halaman daftar produk dengan notifikasi sukses
        return redirect('/merchant/products')->with('success', 'Produk berhasil dihapus!');
    }
}