<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StoreController extends Controller
{
    public function index()
    {
        $store = Store::where('user_id', Auth::id())->first();
        return view('merchant.store.index', compact('store'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'closing_time' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Max 2MB
        ]);

        $store = Store::where('user_id', Auth::id())->first();
        $imagePath = $store->image ?? null;

        // Jika user mengunggah foto baru
        if ($request->hasFile('image')) {
            // Hapus foto lama jika ada
            if ($store && $store->image) {
                Storage::disk('public')->delete($store->image);
            }
            // Simpan foto baru ke folder public/stores
            $imagePath = $request->file('image')->store('stores', 'public');
        }

        Store::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'name' => $request->name,
                'address' => $request->address,
                'closing_time' => $request->closing_time,
                'image' => $imagePath,
            ]
        );

        return redirect()->back()->with('success', 'Data & Foto profil toko berhasil disimpan!');
    }
}