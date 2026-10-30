<x-app-layout>
    <!-- Banner Hero (Sama Persis dengan welcome.blade.php) -->
    <section class="bg-orange-600 text-white py-12 px-4 text-center">
        <h1 class="text-3xl sm:text-4xl font-black mb-2">Safe The Food, Catch The Lastcall!</h1>
        <p class="text-orange-100 max-w-xl mx-auto text-sm sm:text-base">Dapatkan makanan surplus berkualitas dari toko favoritmu dengan harga diskon khusus sebelum toko tutup.</p>
    </section>

    <!-- Katalog Produk Surplus -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h2 class="text-xl font-bold text-stone-900 mb-6">Pilihan Makanan Surplus Hari Ini</h2>

        <!-- Grid Katalog Produk Surplus -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse ($products as $product)
                <div style="background-color: #ffffff; border-radius: 0.75rem; border: 1px solid #e7e5e4; overflow: hidden; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
                    <div>
                        <!-- Wrapper Gambar Presisi 1:1 (Persegi) -->
                        <div style="width: 100%; padding-top: 100%; position: relative; background-color: #f5f5f4; overflow: hidden;">
                            @if ($product->image)
                                <img src="{{ \Illuminate\Support\Str::startsWith($product->image, ['http://', 'https://']) ? $product->image : asset('storage/' . $product->image) }}" 
                                     alt="{{ $product->name }}"
                                     style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #a8a29e; font-size: 0.75rem;">
                                    Tanpa Gambar
                                </div>
                            @endif
                            
                            <!-- Badge Diskon Khas LastCall -->
                            @if ($product->normal_price > 0 && $product->normal_price > $product->discount_price)
                                <span style="position: absolute; top: 10px; right: 10px; z-index: 10; background-color: #ea580c; color: #ffffff; font-size: 0.75rem; font-weight: 700; padding: 4px 8px; border-radius: 6px;">
                                    Diskon {{ round((($product->normal_price - $product->discount_price) / $product->normal_price) * 100) }}%
                                </span>
                            @endif
                        </div>

                        <!-- Detail Produk -->
                        <div style="padding: 1rem;">
                            <p style="font-size: 0.75rem; font-weight: 700; color: #ea580c; margin-bottom: 0.25rem;">
                                🏪 {{ $product->store->name ?? 'Toko Berkah Jaya' }}
                            </p>
                            <h3 style="font-size: 1rem; font-weight: 800; color: #1c1917; margin-bottom: 0.25rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                {{ $product->name }}
                            </h3>
                            <p style="font-size: 0.75rem; color: #78716c; margin-bottom: 0.75rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 2.1rem; line-height: 1.05rem;">
                                {{ $product->description ?? 'Makanan lezat siap di-pickup sebelum toko tutup.' }}
                            </p>
                            
                            <!-- Harga -->
                            <div style="display: flex; align-items: baseline; gap: 0.5rem; margin-top: 0.5rem;">
                                <span style="font-size: 1.15rem; font-weight: 900; color: #ea580c;">
                                    Rp {{ number_format($product->discount_price, 0, ',', '.') }}
                                </span>
                                <span style="font-size: 0.75rem; color: #a8a29e; text-decoration: line-through;">
                                    Rp {{ number_format($product->normal_price, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Card: Stok & Jam Pickup -->
                    <div style="padding: 0.75rem 1rem; background-color: #fafaf9; border-top: 1px solid #f5f5f4; font-size: 0.75rem; display: flex; align-items: center; justify-content: space-between;">
                        <span style="color: #57534e;">Stok: <strong style="color: #1c1917;">{{ $product->stock }}</strong> porsi</span>
                        <span style="background-color: #fef3c7; color: #92400e; padding: 2px 8px; border-radius: 6px; font-weight: 700;">
                            Pickup {{ $product->store->closing_time ?? '20:00' }} WIB
                        </span>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 4rem 1rem; background-color: #ffffff; border-radius: 1.25rem; border: 2px dashed #e7e5e4;">
                    <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">🍲</div>
                    <p style="font-size: 1rem; font-weight: 700; color: #44403c;">Belum ada makanan surplus yang tersedia saat ini.</p>
                    <p style="font-size: 0.75rem; color: #a8a29e; margin-top: 0.25rem;">Cek kembali nanti mendekati jam operasional toko selesai!</p>
                </div>
            @endforelse
        </div>
    </main>
</x-app-layout>