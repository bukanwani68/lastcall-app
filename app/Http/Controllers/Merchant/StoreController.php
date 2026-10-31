<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    /**
     * Menampilkan Dashboard Merchant
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Ambil data toko milik merchant yang sedang login
        $store = Store::where('user_id', $user->id)->first();
        
        // Ambil daftar produk surplus milik toko tersebut
        $products = $store ? Product::where('store_id', $store->id)->latest()->get() : collect();

        return view('merchant.dashboard', compact('store', 'products'));
    }

    /**
     * Menampilkan Form Profil Toko
     */
    public function index()
    {
        $store = Store::where('user_id', Auth::id())->first();
        return view('merchant.store.index', compact('store'));
    }

    /**
     * Menyimpan/Memperbarui Data Toko
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'address'      => 'required|string',
            'closing_time' => 'required',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();
        $store = Store::where('user_id', $user->id)->first() ?? new Store();

        $store->user_id = $user->id;
        $store->name = $request->name;
        $store->address = $request->address;
        $store->closing_time = $request->closing_time;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('stores', 'public');
            $store->image = $imagePath;
        }

        $store->save();

        return back()->with('success', 'Profil toko berhasil diperbarui!');
    }
}