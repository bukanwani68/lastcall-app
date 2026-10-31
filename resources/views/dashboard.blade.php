<x-app-layout>
    <x-slot name="header">
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 0.5rem;">
            <div>
                <h2 style="font-size: 1.25rem; font-weight: 800; color: #0f172a; margin-top: 1rem;">
                    Katalog Makanan Surplus
                </h2>
                <p style="font-size: 0.75rem; color: #78716c; margin-top: 0.25rem; margin-bottom: 1rem;">Pesan makanan surplus favoritmu, ambil langsung di toko dan bayar di kasir!</p>
            </div>
            <a href="{{ url('/orders') }}" style="background-color: #fff7ed; color: #ea580c; border: 1px solid #ffedd5; font-size: 0.8rem; font-weight: 800; padding: 0.5rem 1rem; border-radius: 0.75rem; text-decoration: none; display: inline-flex; align-items: center; gap: 0.375rem;">
                📋 Pesanan Saya
            </a>
        </div>
    </x-slot>

    <div style="padding: 2rem 0; background-color: #f8fafc; min-height: 85vh;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Flash Alert -->
            @if(session('success'))
                <div style="background-color: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 0.875rem 1.25rem; border-radius: 1rem; font-size: 0.825rem; font-weight: 700;">
                    🎉 {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div style="background-color: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 0.875rem 1.25rem; border-radius: 1rem; font-size: 0.825rem; font-weight: 700;">
                    ⚠️ {{ session('error') }}
                </div>
            @endif

            <h3 style="font-size: 1.125rem; font-weight: 800; color: #0f172a; margin-bottom: 1rem;">
                Pilihan Makanan Surplus Hari Ini
            </h3>

            <!-- Grid Produk -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($products as $product)
                    <div style="background-color: #ffffff; border-radius: 1.25rem; border: 1px solid #e2e8f0; overflow: hidden; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 2px 8px rgba(0,0,0,0.03);">
                        <div>
                            <!-- Aspect Ratio Square Image -->
                            <div style="width: 100%; padding-top: 100%; position: relative; background-color: #f8fafc; overflow: hidden;">
                                @if($product->image)
                                    <img src="{{ \Illuminate\Support\Str::startsWith($product->image, ['http://', 'https://']) ? $product->image : asset('storage/' . $product->image) }}" 
                                         alt="{{ $product->name }}"
                                         style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; background-color: #ffedd5; color: #ea580c;">
                                        🍲
                                    </div>
                                @endif

                                @if($product->normal_price > 0 && $product->normal_price > $product->discount_price)
                                    <span style="position: absolute; top: 12px; right: 12px; background-color: #ea580c; color: #ffffff; font-size: 0.75rem; font-weight: 800; padding: 4px 10px; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.2);">
                                        Diskon {{ round((($product->normal_price - $product->discount_price) / $product->normal_price) * 100) }}%
                                    </span>
                                @endif
                            </div>

                            <!-- Body Detail -->
                            <div style="padding: 1rem;">
                                <div style="font-size: 0.8rem; font-weight: 700; color: #ea580c; margin-bottom: 0.35rem; display: flex; align-items: center; gap: 4px;">
                                    <span>🏪</span> {{ $product->store->name ?? 'Toko Merchant' }}
                                </div>

                                <h4 style="font-size: 1rem; font-weight: 800; color: #0f172a; margin-bottom: 0.35rem; line-height: 1.3;" title="{{ $product->name }}">
                                    {{ $product->name }}
                                </h4>

                                <p style="font-size: 0.8rem; color: #64748b; margin-bottom: 0.75rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 2.2rem; line-height: 1.1rem;">
                                    {{ $product->description ?? 'Makanan surplus berkualitas siap diambil hari ini.' }}
                                </p>

                                <div style="display: flex; align-items: baseline; gap: 0.5rem; margin-top: 0.25rem;">
                                    <span style="font-size: 1.125rem; font-weight: 900; color: #ea580c;">
                                        Rp {{ number_format($product->discount_price, 0, ',', '.') }}
                                    </span>
                                    <span style="font-size: 0.8rem; color: #94a3b8; text-decoration: line-through;">
                                        Rp {{ number_format($product->normal_price, 0, ',', '.') }}
                                    </span>
                                </div>

                                <!-- Pickup Time & Stock info -->
                                <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 0.75rem; font-size: 0.75rem; font-weight: 700; color: #475569;">
                                    <span>Stok: {{ $product->stock }} porsi</span>
                                    <span style="color: #ea580c; background-color: #fff7ed; padding: 2px 6px; border-radius: 4px; border: 1px solid #ffedd5;">
                                        Pickup: {{ $product->store->closing_time ?? '18:00' }} WIB
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Footer Card: Form Button Order (Pay at Outlet) -->
                        <div style="padding: 0.875rem 1rem; background-color: #f8fafc; border-top: 1px solid #f1f5f9;">
                            <form action="{{ url('/orders') }}" method="POST" style="margin: 0;">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                
                                <a href="{{ url('/orders/confirm/' . $product->id) }}" 
                                style="display: block; text-align: center; background: {{ $product->stock > 0 ? 'linear-gradient(135deg, #ea580c 0%, #c2410c 100%)' : '#cbd5e1' }}; color: #ffffff; font-weight: 800; font-size: 0.825rem; padding: 0.625rem; border-radius: 0.625rem; text-decoration: none; pointer-events: {{ $product->stock > 0 ? 'auto' : 'none' }};">
                                    {{ $product->stock > 0 ? '🛍️ Pesan Makanan' : '🚫 Stok Habis' }}
                                </a>
                            </form>
                        </div>
                    </div>
                @empty
                    <div style="grid-column: 1 / -1; text-align: center; padding: 4rem 1rem; color: #64748b;">
                        <div style="font-size: 3rem; margin-bottom: 0.5rem;">🍱</div>
                        <h4 style="font-weight: 800; color: #0f172a; font-size: 1.125rem;">Belum Ada Makanan Surplus Tersedia</h4>
                        <p style="font-size: 0.85rem;">Silakan cek kembali beberapa saat lagi mendekati jam operasional tutup toko.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>