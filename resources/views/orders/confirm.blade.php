<x-app-layout>
    <x-slot name="header">
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 0.5rem;">
            <div>
                <h2 style="font-size: 1.25rem; font-weight: 800; color: #0f172a; margin-top: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                    <span>Konfirmasi Pesanan</span>
                    <span style="background-color: #ffedd5; color: #ea580c; font-size: 0.75rem; font-weight: 800; padding: 2px 8px; border-radius: 9999px; border: 1px solid #fed7aa;">
                        Self-Pickup 🏪
                    </span>
                </h2>
                <p style="font-size: 0.75rem; color: #78716c; margin-top: 0.25rem; margin-bottom: 1rem;">
                    Periksa kembali rincian pesanan dan lokasi pickup Anda sebelum menyelesaikan pemesanan.
                </p>
            </div>
            <a href="{{ url('/dashboard') }}" style="background-color: #e2e8f0; color: #334155; font-size: 0.75rem; font-weight: 800; padding: 0.5rem 1rem; border-radius: 0.75rem; text-decoration: none;">
                &larr; Batal & Kembali
            </a>
        </div>
    </x-slot>

    <div style="padding: 2rem 0; background-color: #f8fafc; min-height: 85vh;">
        <div style="max-width: 1250px; margin: 0 auto; padding: 0 1rem;">

            <div style="background-color: #ffffff; border-radius: 1.25rem; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
                
                <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid #f1f5f9; background-color: #ffffff;">
                    <h3 style="font-size: 1rem; font-weight: 800; color: #0f172a; margin: 0;">Ringkasan Makanan Surplus</h3>
                </div>

                <!-- Pembungkus Utama Menggunakan DIV (Bukan FORM) -->
                <div style="padding: 1.5rem;">
                    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                        
                        <!-- Info Toko & Produk -->
                        <div style="display: flex; gap: 1.25rem; align-items: flex-start; background-color: #f8fafc; padding: 1.25rem; border-radius: 1rem; border: 1px solid #e2e8f0; flex-wrap: wrap;">
                            <div style="width: 100px; height: 100px; border-radius: 0.875rem; overflow: hidden; background-color: #e2e8f0; border: 2px solid #ea580c; flex-shrink: 0;">
                                @if($product->image)
                                    <img src="{{ \Illuminate\Support\Str::startsWith($product->image, ['http://', 'https://']) ? $product->image : asset('storage/' . $product->image) }}" 
                                         alt="{{ $product->name }}"
                                         style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 2.25rem; background-color: #ffedd5; color: #ea580c;">
                                        🍲
                                    </div>
                                @endif
                            </div>

                            <div style="flex: 1; min-width: 220px;">
                                <span style="font-size: 0.8rem; font-weight: 800; color: #ea580c; display: block; margin-bottom: 0.25rem;">
                                    🏪 {{ $product->store->name ?? 'Toko Merchant' }}
                                </span>
                                <h4 style="font-size: 1.125rem; font-weight: 800; color: #0f172a; margin: 0 0 0.25rem 0;">
                                    {{ $product->name }}
                                </h4>
                                <p style="font-size: 0.8rem; color: #64748b; margin: 0 0 0.5rem 0;">
                                    📍 {{ $product->store->address ?? 'Alamat toko belum diatur' }}
                                </p>
                                <span style="background-color: #fff7ed; color: #ea580c; border: 1px solid #ffedd5; font-size: 0.75rem; font-weight: 800; padding: 4px 10px; border-radius: 6px;">
                                    ⏰ Batas Pickup: {{ $product->store->closing_time ?? '18:00' }} WIB
                                </span>
                            </div>
                        </div>

                        <!-- Pilihan Jumlah & Rincian Harga -->
                        <div style="background-color: #ffffff; border: 1px solid #e2e8f0; border-radius: 1rem; padding: 1.25rem; display: flex; flex-direction: column; gap: 0.875rem;">
                            
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <label for="quantitySelect" style="font-size: 0.85rem; font-weight: 800; color: #334155;">
                                    Jumlah Porsi:
                                </label>
                                <select id="quantitySelect" onchange="updateTotalAndQuantity(this.value, {{ $product->discount_price }})"
                                        style="font-size: 0.85rem; font-weight: 800; padding: 0.375rem 0.75rem; border-radius: 0.5rem; border: 1px solid #cbd5e1; outline: none;">
                                    @for($i = 1; $i <= min($product->stock, 10); $i++)
                                        <option value="{{ $i }}">{{ $i }} Porsi</option>
                                    @endfor
                                </select>
                            </div>

                            <div style="border-top: 1px dashed #e2e8f0; padding-top: 0.75rem; display: flex; align-items: center; justify-content: space-between;">
                                <span style="font-size: 0.85rem; color: #64748b;">Harga per Porsi:</span>
                                <span style="font-size: 0.85rem; font-weight: 700; color: #0f172a;">
                                    Rp {{ number_format($product->discount_price, 0, ',', '.') }}
                                </span>
                            </div>

                            <div style="border-top: 1px solid #e2e8f0; padding-top: 0.75rem; display: flex; align-items: center; justify-content: space-between;">
                                <span style="font-size: 0.95rem; font-weight: 800; color: #0f172a;">Total Tagihan:</span>
                                <span id="total-price-display" style="font-size: 1.35rem; font-weight: 900; color: #ea580c;">
                                    Rp {{ number_format($product->discount_price, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <!-- Informasi Pembayaran di Outlet -->
                        <div style="background-color: #fff7ed; border: 1px solid #ffedd5; border-radius: 1rem; padding: 1rem; display: flex; align-items: flex-start; gap: 0.75rem;">
                            <span style="font-size: 1.25rem;">💵</span>
                            <div>
                                <h5 style="font-size: 0.85rem; font-weight: 800; color: #c2410c; margin: 0;">Metode Pembayaran: Bayar di Outlet</h5>
                                <p style="font-size: 0.75rem; color: #9a3412; margin: 2px 0 0 0; line-height: 1.3;">
                                    Anda tidak perlu bayar sekarang. Cukup tunjukkan riwayat pesanan ke kasir saat mengambil makanan dan bayar menggunakan <b>Tunai atau QRIS</b>.
                                </p>
                            </div>
                        </div>

                        <!-- Tombol Aksi Mandiri (Masing-masing Form Terpisah) -->
                        <div style="display: flex; gap: 1rem; flex-wrap: wrap; margin-top: 0.5rem;">
                            
                            <!-- Opsi 1: Masukkan ke Keranjang / Troli -->
                            <form action="{{ url('/cart') }}" method="POST" style="flex: 1; min-width: 200px;">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" class="hiddenQuantity" value="1">
                                <button type="submit" style="width: 100%; background-color: #fff7ed; color: #ea580c; border: 2px solid #ffedd5; font-weight: 800; padding: 0.85rem; border-radius: 0.85rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                                    🛒 Masukkan Keranjang
                                </button>
                            </form>

                            <!-- Opsi 2: Beli Langsung (Langsung Pesan Instant) -->
                            <form action="{{ url('/orders') }}" method="POST" style="flex: 1; min-width: 200px;">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" class="hiddenQuantity" value="1">
                                <button type="submit" style="width: 100%; background-color: #ea580c; color: white; font-weight: 800; padding: 0.85rem; border-radius: 0.85rem; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                                    ⚡ Beli Langsung
                                </button>
                            </form>

                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- Script Pengubah Total & Sync Jumlah Porsi -->
    <script>
        function updateTotalAndQuantity(qty, pricePerUnit) {
            // Update tampilan total tagihan
            const total = qty * pricePerUnit;
            document.getElementById('total-price-display').innerText = 'Rp ' + total.toLocaleString('id-ID');

            // Sync jumlah porsi ke kedua form aksi
            document.querySelectorAll('.hiddenQuantity').forEach(input => {
                input.value = qty;
            });
        }
    </script>
</x-app-layout>