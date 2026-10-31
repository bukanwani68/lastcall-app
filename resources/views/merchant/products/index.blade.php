<x-app-layout>
    <x-slot name="header">
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 0.5rem;">
            <div>
                <h2 class="font-extrabold text-xl text-stone-900 leading-tight" style="display: flex; align-items: center; gap: 0.5rem; margin-top: 1rem; margin-bottom: 0.25rem;">
                    <span>Kelola Produk Surplus</span>
                    <span style="background-color: #ffedd5; color: #ea580c; font-size: 0.75rem; font-weight: 800; padding: 2px 8px; border-radius: 9999px; border: 1px solid #fed7aa;">
                        Catalog Management 📦
                    </span>
                </h2>
                <p style="font-size: 0.75rem; color: #78716c; margin-top: 0.25rem; margin-bottom: 1rem;">Daftar seluruh menu makanan surplus yang kamu tawarkan hari ini.</p>
            </div>
            <a href="{{ url('/merchant/products/create') }}" 
               style="background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%); color: #ffffff; font-weight: 800; font-size: 0.825rem; padding: 0.625rem 1.25rem; border-radius: 0.875rem; text-decoration: none; display: inline-flex; align-items: center; gap: 0.375rem; box-shadow: 0 4px 12px rgba(234,88,12,0.25); transition: all 0.2s;">
                + Tambah Produk Baru
            </a>
        </div>
    </x-slot>

    <div style="padding: 2rem 0; background-color: #f8fafc; min-height: 85vh;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Flash Alert Success -->
            @if(session('success'))
                <div style="background-color: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 0.875rem 1.25rem; border-radius: 1rem; font-size: 0.825rem; font-weight: 700; display: flex; align-items: center; justify-content: space-between;">
                    <span>🎉 {{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div style="background-color: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 0.875rem 1.25rem; border-radius: 1rem; font-size: 0.825rem; font-weight: 700;">
                    ⚠️ {{ session('error') }}
                </div>
            @endif

            <!-- Tabel Produk Surplus Modern -->
            <div style="background-color: #ffffff; border-radius: 1.25rem; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
                <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 0.5rem;">
                    <h3 style="font-size: 1rem; font-weight: 800; color: #0f172a; margin: 0;">
                        Daftar Produk Jualan ({{ $products->count() }})
                    </h3>
                </div>

                <div style="overflow-x: auto;">
                    <table style="width: 100%; text-align: left; border-collapse: collapse;">
                        <thead>
                            <tr style="background-color: #f8fafc; border-bottom: 1px solid #e2e8f0; font-size: 0.7rem; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">
                                <th style="padding: 1rem 1.25rem; width: 80px;">Foto</th>
                                <th style="padding: 1rem 1.25rem;">Nama & Deskripsi Makanan</th>
                                <th style="padding: 1rem 1.25rem; width: 180px;">Harga Asli / LastCall</th>
                                <th style="padding: 1rem 1.25rem; width: 130px;">Sisa Stok</th>
                                <th style="padding: 1rem 1.25rem; width: 160px; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                                <tr style="border-bottom: 1px solid #f1f5f9; transition: background-color 0.15s;">
                                    
                                    <!-- 1. Foto Produk (Thumbnail Presisi 56x56 px) -->
                                    <td style="padding: 1rem 1.25rem; vertical-align: middle;">
                                        <div style="width: 56px; height: 56px; border-radius: 0.75rem; overflow: hidden; background-color: #f1f5f9; border: 1px solid #e2e8f0; flex-shrink: 0; position: relative;">
                                            @if($product->image)
                                                <img src="{{ \Illuminate\Support\Str::startsWith($product->image, ['http://', 'https://']) ? $product->image : asset('storage/' . $product->image) }}" 
                                                     alt="{{ $product->name }}"
                                                     style="width: 100%; height: 100%; object-fit: cover;">
                                            @else
                                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 1.25rem;">
                                                    🍲
                                                </div>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- 2. Nama & Deskripsi -->
                                    <td style="padding: 1rem 1.25rem; vertical-align: middle;">
                                        <h4 style="font-size: 0.9rem; font-weight: 800; color: #0f172a; margin: 0; line-height: 1.3;">
                                            {{ $product->name }}
                                        </h4>
                                        <p style="font-size: 0.75rem; color: #64748b; margin: 4px 0 0 0; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; max-width: 420px; line-height: 1.15rem;">
                                            {{ $product->description ?? 'Tidak ada deskripsi makanan.' }}
                                        </p>
                                    </td>

                                    <!-- 3. Harga Asli & Diskon LastCall -->
                                    <td style="padding: 1rem 1.25rem; vertical-align: middle;">
                                        <div style="display: flex; flex-direction: column; gap: 2px;">
                                            <span style="font-size: 0.95rem; font-weight: 900; color: #ea580c;">
                                                Rp {{ number_format($product->discount_price, 0, ',', '.') }}
                                            </span>
                                            <span style="font-size: 0.7rem; color: #94a3b8; text-decoration: line-through;">
                                                Rp {{ number_format($product->normal_price, 0, ',', '.') }}
                                            </span>
                                            @if($product->normal_price > 0 && $product->normal_price > $product->discount_price)
                                                <span style="font-size: 0.65rem; background-color: #fff7ed; color: #ea580c; font-weight: 800; padding: 2px 6px; border-radius: 4px; display: inline-block; width: fit-content; border: 1px solid #ffedd5; margin-top: 2px;">
                                                    Hemat {{ round((($product->normal_price - $product->discount_price) / $product->normal_price) * 100) }}%
                                                </span>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- 4. Stok Produk -->
                                    <td style="padding: 1rem 1.25rem; vertical-align: middle;">
                                        @if($product->stock > 5)
                                            <span style="background-color: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; font-size: 0.75rem; font-weight: 800; padding: 4px 10px; border-radius: 9999px; display: inline-flex; align-items: center; gap: 4px;">
                                                📦 {{ $product->stock }} porsi
                                            </span>
                                        @elseif($product->stock > 0)
                                            <span style="background-color: #fffbeb; color: #92400e; border: 1px solid #fde68a; font-size: 0.75rem; font-weight: 800; padding: 4px 10px; border-radius: 9999px; display: inline-flex; align-items: center; gap: 4px;">
                                                ⚠️ {{ $product->stock }} porsi
                                            </span>
                                        @else
                                            <span style="background-color: #fef2f2; color: #991b1b; border: 1px solid #fecaca; font-size: 0.75rem; font-weight: 800; padding: 4px 10px; border-radius: 9999px; display: inline-flex; align-items: center; gap: 4px;">
                                                🚫 Habis
                                            </span>
                                        @endif
                                    </td>

                                    <!-- 5. Tombol Aksi (Edit & Hapus) -->
                                    <td style="padding: 1rem 1.25rem; vertical-align: middle; text-align: center;">
                                        <div style="display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                                            <a href="{{ url('/merchant/products/' . $product->id . '/edit') }}" 
                                               style="background-color: #f1f5f9; color: #334155; font-size: 0.75rem; font-weight: 700; padding: 6px 12px; border-radius: 0.5rem; text-decoration: none; transition: all 0.2s; border: 1px solid #e2e8f0;"
                                               title="Edit Produk">
                                                ✏️ Edit
                                            </a>
                                            
                                            <form action="{{ url('/merchant/products/' . $product->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');" style="margin: 0;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        style="background-color: #fef2f2; color: #dc2626; font-size: 0.75rem; font-weight: 700; padding: 6px 12px; border-radius: 0.5rem; border: 1px solid #fecaca; cursor: pointer; transition: all 0.2s;"
                                                        title="Hapus Produk">
                                                    🗑️ Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align: center; padding: 3.5rem 1rem; color: #64748b;">
                                        <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">🍪</div>
                                        <h4 style="font-size: 1rem; font-weight: 800; color: #0f172a; margin: 0;">Belum Ada Produk Surplus</h4>
                                        <p style="font-size: 0.75rem; color: #64748b; margin-top: 0.25rem;">Mulai tambahkan produk jualanmu agar pembeli bisa melakukan pemesanan.</p>
                                        <a href="{{ url('/merchant/products/create') }}" 
                                           style="background-color: #ea580c; color: #ffffff; font-size: 0.75rem; font-weight: 800; padding: 0.5rem 1rem; border-radius: 0.625rem; text-decoration: none; display: inline-block; margin-top: 0.75rem;">
                                            + Tambah Produk Sekarang
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>