<x-app-layout>
    <x-slot name="header">
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 0.5rem;">
            <div>
                <h2 class="font-extrabold text-xl text-stone-900 leading-tight" style="display: flex; align-items: center; gap: 0.5rem; margin-top: 1rem">
                    <span>Dashboard Merchant</span>
                    <span style="background-color: #ffedd5; color: #ea580c; font-size: 0.75rem; font-weight: 800; padding: 2px 8px; border-radius: 9999px; border: 1px solid #fed7aa;">
                        LastCall Partner 🥐
                    </span>
                </h2>
                <p style="font-size: 0.75rem; color: #78716c; margin-top: 0.25rem; margin-bottom: 1rem;">Kelola toko dan makanan surplus harianmu dengan mudah.</p>
            </div>
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <span style="display: inline-flex; align-items: center; gap: 0.375rem; background-color: #f0fdf4; color: #166534; font-size: 0.75rem; font-weight: 700; padding: 4px 10px; border-radius: 9999px; border: 1px solid #bbf7d0;">
                    <span style="width: 8px; height: 8px; background-color: #22c55e; border-radius: 9999px; display: inline-block;"></span>
                    Toko Aktif Hari Ini
                </span>
            </div>
        </div>
    </x-slot>

    <div style="padding: 2rem 0; background-color: #f8fafc; min-height: 85vh;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- 1. Banner Info Toko Modern -->
            @if(isset($store) && $store)
                <div style="background: linear-gradient(135deg, #ffffff 0%, #fff7ed 100%); border-radius: 1.25rem; padding: 1.25rem 1.5rem; display: flex; align-items: center; justify-content: space-between; gap: 1rem; border: 1px solid #fed7aa; box-shadow: 0 4px 20px -2px rgba(234, 88, 12, 0.08); flex-wrap: wrap;">
                    
                    <div style="display: flex; align-items: center; gap: 1rem; text-align: left;">
                        @if($store->image)
                            <img src="{{ \Illuminate\Support\Str::startsWith($store->image, ['http://', 'https://']) ? $store->image : asset('storage/' . $store->image) }}" 
                                 alt="{{ $store->name }}"
                                 style="width: 52px; height: 52px; object-fit: cover; border-radius: 1rem; border: 2px solid #ea580c; box-shadow: 0 2px 8px rgba(234,88,12,0.15); flex-shrink: 0;">
                        @else
                            <div style="width: 52px; height: 52px; background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%); color: #ffffff; font-weight: 900; font-size: 1.25rem; border-radius: 1rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 2px 8px rgba(234,88,12,0.25);">
                                {{ substr($store->name, 0, 1) }}
                            </div>
                        @endif
                        
                        <div style="text-align: left;">
                            <div style="display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap;">
                                <h3 style="font-size: 1.125rem; font-weight: 800; color: #1c1917; margin: 0;">{{ $store->name }}</h3>
                                <span style="font-size: 0.65rem; background-color: #ea580c; color: #ffffff; font-weight: 800; padding: 2px 6px; border-radius: 4px;">VERIFIED MERCHANT</span>
                            </div>
                            <p style="font-size: 0.75rem; color: #57534e; margin: 2px 0 0 0; display: flex; align-items: center; gap: 4px;">
                                <span>📍</span> {{ $store->address }}
                            </p>
                            <p style="font-size: 0.75rem; color: #ea580c; font-weight: 700; margin: 4px 0 0 0; display: flex; align-items: center; gap: 4px;">
                                <span>⏰</span> Pickup Sampai: <strong>{{ $store->closing_time }} WIB</strong>
                            </p>
                        </div>
                    </div>

                    <div>
                        <a href="{{ url('/merchant/store') }}" 
                           style="background-color: #ffffff; color: #ea580c; font-size: 0.825rem; font-weight: 800; padding: 0.625rem 1.125rem; border-radius: 0.875rem; text-decoration: none; display: inline-flex; align-items: center; gap: 0.375rem; border: 1.5px solid #ea580c; box-shadow: 0 2px 6px rgba(234,88,12,0.1); transition: all 0.2s;">
                            ⚙️ Edit Profil Toko
                        </a>
                    </div>
                </div>
            @else
                <div style="background-color: #fffbeb; border: 1px solid #fde68a; padding: 1.25rem; border-radius: 1.25rem; display: flex; align-items: center; justify-content: space-between; gap: 1rem; width: 100%; text-align: left;">
                    <div style="text-align: left;">
                        <h4 style="font-weight: 800; color: #78350f; font-size: 0.95rem; margin: 0;">⚠️ Profil Toko Belum Diatur</h4>
                        <p style="font-size: 0.8rem; color: #92400e; margin: 4px 0 0 0;">Lengkapi profil toko Anda agar produk dapat dilihat oleh calon pembeli di katalog LastCall.</p>
                    </div>
                    <a href="{{ url('/merchant/store') }}" style="background-color: #d97706; color: #ffffff; font-size: 0.8rem; font-weight: 800; padding: 0.625rem 1.25rem; border-radius: 0.75rem; text-decoration: none; white-space: nowrap;">
                        Atur Profil Sekarang
                    </a>
                </div>
            @endif

            <!-- 2. Ringkasan Statistik Interaktif & Quick Action -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                
                <!-- Stat 1 -->
                <div style="background-color: #ffffff; border-radius: 1.25rem; padding: 1.25rem; border: 1px solid #e2e8f0; box-shadow: 0 2px 10px rgba(0,0,0,0.02); display: flex; align-items: center; justify-content: space-between;">
                    <div>
                        <p style="font-size: 0.7rem; font-weight: 800; uppercase; tracking-wider; color: #64748b; margin: 0;">TOTAL PRODUK SURPLUS</p>
                        <div style="display: flex; align-items: baseline; gap: 0.375rem; margin-top: 0.375rem;">
                            <span style="font-size: 2rem; font-weight: 900; color: #0f172a;">{{ $products->count() }}</span>
                            <span style="font-size: 0.8rem; font-weight: 600; color: #64748b;">Varian Menu</span>
                        </div>
                    </div>
                    <div style="width: 48px; height: 48px; background-color: #f1f5f9; border-radius: 1rem; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                        🥗
                    </div>
                </div>

                <!-- Stat 2 -->
                <div style="background-color: #ffffff; border-radius: 1.25rem; padding: 1.25rem; border: 1px solid #e2e8f0; box-shadow: 0 2px 10px rgba(0,0,0,0.02); display: flex; align-items: center; justify-content: space-between;">
                    <div>
                        <p style="font-size: 0.7rem; font-weight: 800; uppercase; tracking-wider; color: #64748b; margin: 0;">TOTAL STOK TERSEDIA</p>
                        <div style="display: flex; align-items: baseline; gap: 0.375rem; margin-top: 0.375rem;">
                            <span style="font-size: 2rem; font-weight: 900; color: #ea580c;">{{ $products->sum('stock') }}</span>
                            <span style="font-size: 0.8rem; font-weight: 600; color: #ea580c;">Porsi</span>
                        </div>
                    </div>
                    <div style="width: 48px; height: 48px; background-color: #ffedd5; border-radius: 1rem; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                        📦
                    </div>
                </div>

                <!-- Quick Action Card -->
                <div style="background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%); border-radius: 1.25rem; padding: 1.25rem; color: #ffffff; box-shadow: 0 4px 15px rgba(234, 88, 12, 0.25); display: flex; flex-direction: column; justify-content: space-between; sm:col-span-2 lg:col-span-1;">
                    <div>
                        <div style="display: flex; items-center; justify-content: space-between;">
                            <p style="font-size: 0.7rem; font-weight: 800; letter-spacing: 0.05em; color: #ffedd5; margin: 0;">AKSI CEPAT MERCHANT</p>
                            <span style="font-size: 0.75rem;">🚀</span>
                        </div>
                        <p style="font-size: 0.8rem; color: #ffffff; margin-top: 0.25rem; opacity: 0.95;">
                            Punya makanan sisa hari ini? Obral sebelum toko tutup!
                        </p>
                    </div>
                    <a href="{{ url('/merchant/products/create') }}" 
                       style="margin-top: 0.875rem; background-color: #ffffff; color: #ea580c; text-align: center; font-weight: 800; font-size: 0.825rem; padding: 0.625rem 1rem; border-radius: 0.75rem; text-decoration: none; display: block; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                        + Tambah Produk Surplus Baru
                    </a>
                </div>

            </div>

            <!-- 3. Header Seksi & Katalog Produk -->
            <div style="background-color: #ffffff; border-radius: 1.25rem; border: 1px solid #e2e8f0; padding: 1.5rem; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
                
                <div style="display: flex; items-center; justify-content: space-between; flex-wrap: wrap; gap: 0.75rem; margin-bottom: 1.25rem; padding-bottom: 1rem; border-bottom: 1px solid #f1f5f9;">
                    <div>
                        <h3 style="font-size: 1.125rem; font-weight: 800; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                            🛒 Daftar Produk Surplus Aktif
                            <span style="font-size: 0.7rem; background-color: #f1f5f9; color: #475569; font-weight: 700; padding: 2px 8px; border-radius: 9999px;">
                                {{ $products->count() }} Item
                            </span>
                        </h3>
                        <p style="font-size: 0.75rem; color: #64748b; margin-top: 0.25rem;">Atur stok, ubah harga diskon, atau perbarui deskripsi menu jualanmu.</p>
                    </div>
                    <a href="{{ url('/merchant/products') }}" style="font-size: 0.8rem; color: #ea580c; font-weight: 800; text-decoration: none; display: flex; align-items: center; gap: 0.25rem;">
                        Kelola Semua Produk &rarr;
                    </a>
                </div>

                <!-- Grid Produk 4 - 5 Kolom -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                    @forelse($products as $product)
                        <div style="background-color: #ffffff; border-radius: 1rem; border: 1px solid #e2e8f0; overflow: hidden; display: flex; flex-direction: column; justify-content: space-between; transition: all 0.2s; box-shadow: 0 2px 6px rgba(0,0,0,0.02);">
                            <div>
                                <!-- Wrapper Gambar 1:1 Presisi (Square) -->
                                <div style="width: 100%; padding-top: 100%; position: relative; background-color: #f8fafc; overflow: hidden;">
                                    @if($product->image)
                                        <img src="{{ \Illuminate\Support\Str::startsWith($product->image, ['http://', 'https://']) ? $product->image : asset('storage/' . $product->image) }}" 
                                             alt="{{ $product->name }}"
                                             style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #94a3b8; font-size: 0.75rem;">
                                            <span style="font-size: 1.5rem; margin-bottom: 0.25rem;">🖼️</span>
                                            Tanpa Gambar
                                        </div>
                                    @endif

                                    <!-- Badge Diskon Vibrant -->
                                    @if($product->normal_price > 0 && $product->normal_price > $product->discount_price)
                                        <span style="position: absolute; top: 8px; right: 8px; z-index: 10; background-color: #ea580c; color: #ffffff; font-size: 0.65rem; font-weight: 900; padding: 3px 7px; border-radius: 6px; box-shadow: 0 2px 6px rgba(0,0,0,0.2);">
                                            -{{ round((($product->normal_price - $product->discount_price) / $product->normal_price) * 100) }}%
                                        </span>
                                    @endif
                                </div>

                                <!-- Detail Produk -->
                                <div style="padding: 0.875rem;">
                                    <h4 style="font-size: 0.875rem; font-weight: 800; color: #0f172a; margin-bottom: 0.25rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $product->name }}">
                                        {{ $product->name }}
                                    </h4>
                                    <p style="font-size: 0.7rem; color: #64748b; margin-bottom: 0.625rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 1.9rem; line-height: 0.95rem;">
                                        {{ $product->description ?? 'Tidak ada deskripsi makanan.' }}
                                    </p>
                                    
                                    <!-- Pricing -->
                                    <div style="display: flex; align-items: baseline; gap: 0.35rem; margin-top: 0.25rem;">
                                        <span style="font-size: 1rem; font-weight: 900; color: #ea580c;">
                                            Rp {{ number_format($product->discount_price, 0, ',', '.') }}
                                        </span>
                                        <span style="font-size: 0.7rem; color: #94a3b8; text-decoration: line-through;">
                                            Rp {{ number_format($product->normal_price, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Footer Card: Status Stok & Action Edit -->
                            <div style="padding: 0.625rem 0.875rem; background-color: #f8fafc; border-top: 1px solid #f1f5f9; font-size: 0.7rem; display: flex; align-items: center; justify-content: space-between;">
                                <span style="color: #475569; font-weight: 600; display: flex; align-items: center; gap: 4px;">
                                    Stok: <strong style="color: {{ $product->stock > 0 ? '#0f172a' : '#dc2626' }}; font-weight: 800;">{{ $product->stock }}</strong>
                                </span>
                                <a href="{{ url('/merchant/products/' . $product->id . '/edit') }}" 
                                   style="background-color: #fff7ed; color: #ea580c; font-weight: 800; padding: 3px 8px; border-radius: 6px; text-decoration: none; border: 1px solid #ffedd5;">
                                    ✏️ Edit
                                </a>
                            </div>
                        </div>
                    @empty
                        <div style="grid-column: 1 / -1; text-align: center; padding: 3.5rem 1rem; background-color: #f8fafc; border-radius: 1rem; border: 2px dashed #cbd5e1;">
                            <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">🍲</div>
                            <h4 style="font-weight: 800; color: #334155; font-size: 1rem; margin: 0;">Belum Ada Produk Surplus</h4>
                            <p style="font-size: 0.75rem; color: #64748b; margin-top: 0.25rem;">Tambahkan makanan siap jual sekarang agar pelanggan bisa langsung memesan.</p>
                            <a href="{{ url('/merchant/products/create') }}" style="background-color: #ea580c; color: #ffffff; font-weight: 800; font-size: 0.75rem; padding: 0.5rem 1rem; border-radius: 0.625rem; text-decoration: none; display: inline-block; margin-top: 0.75rem; box-shadow: 0 2px 6px rgba(234,88,12,0.2);">
                                + Tambah Produk Pertama
                            </a>
                        </div>
                    @endforelse
                </div>

            </div>

        </div>
    </div>
</x-app-layout>