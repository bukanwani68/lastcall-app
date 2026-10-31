<x-app-layout>
    <x-slot name="header">
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 0.5rem;">
            <div>
                <h2 style="font-size: 1.25rem; font-weight: 800; color: #0f172a; margin-top: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                    <span>Edit Produk Surplus</span>
                    <span style="background-color: #ffedd5; color: #ea580c; font-size: 0.75rem; font-weight: 800; padding: 2px 8px; border-radius: 9999px; border: 1px solid #fed7aa;">
                        Update Menu ✏️
                    </span>
                </h2>
                <p style="font-size: 0.75rem; color: #78716c; margin-top: 0.25rem; margin-bottom: 1rem;">Perbarui detail harga, stok, atau foto produk makanan surplus Anda.</p>
            </div>
            <a href="{{ url('/merchant/products') }}" 
               style="background-color: #e2e8f0; color: #334155; font-size: 0.75rem; font-weight: 800; padding: 0.5rem 1rem; border-radius: 0.75rem; text-decoration: none;">
                &larr; Kembali ke Daftar Produk
            </a>
        </div>
    </x-slot>

    <div style="padding: 2rem 0; background-color: #f8fafc; min-height: 85vh;">
        <!-- Container dilebarkan menjadi 1150px -->
        <div style="max-width: 1250px; margin: 0 auto; padding: 0 1rem;">

            <!-- Alert Validation Error -->
            @if($errors->any())
                <div style="background-color: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 0.875rem 1.25rem; border-radius: 1rem; font-size: 0.825rem; font-weight: 700; margin-bottom: 1.5rem;">
                    <ul style="margin: 0; padding-left: 1rem;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Card Utama Form Edit Produk (Lebar Pas Layar) -->
            <div style="background-color: #ffffff; border-radius: 1.25rem; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
                
                <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid #f1f5f9; background-color: #ffffff;">
                    <h3 style="font-size: 1rem; font-weight: 800; color: #0f172a; margin: 0;">Form Perubahan Data Produk</h3>
                    <p style="font-size: 0.75rem; color: #64748b; margin-top: 0.25rem;">Ubah informasi produk <strong>{{ $product->name }}</strong>.</p>
                </div>

                <form action="{{ url('/merchant/products/' . $product->id) }}" method="POST" enctype="multipart/form-data" style="padding: 1.75rem;">
                    @csrf
                    @method('PUT')

                    <div style="display: flex; flex-direction: row; gap: 2.5rem; align-items: flex-start; flex-wrap: wrap;">
                        
                        <!-- KOLOM KIRI: Foto Produk -->
                        <div style="width: 200px; flex-shrink: 0; background-color: #f8fafc; padding: 1.25rem; border-radius: 1rem; border: 1px solid #e2e8f0; text-align: center;">
                            <label style="display: block; font-size: 0.75rem; font-weight: 800; color: #475569; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.75rem;">
                                Foto Saat Ini
                            </label>

                            <div style="width: 120px !important; height: 120px !important; max-width: 120px !important; max-height: 120px !important; border-radius: 1rem; overflow: hidden; background-color: #e2e8f0; border: 2px solid #ea580c; margin: 0 auto 1rem auto; box-shadow: 0 2px 8px rgba(234,88,12,0.15); position: relative;">
                                @if($product->image)
                                    <img src="{{ \Illuminate\Support\Str::startsWith($product->image, ['http://', 'https://']) ? $product->image : asset('storage/' . $product->image) }}" 
                                         alt="{{ $product->name }}"
                                         style="width: 120px !important; height: 120px !important; max-width: 120px !important; max-height: 120px !important; object-fit: cover !important; display: block;">
                                @else
                                    <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 2rem; background-color: #ffedd5; color: #ea580c; font-weight: 900;">
                                        🍲
                                    </div>
                                @endif
                            </div>

                            <div style="text-align: left;">
                                <label for="image" style="display: block; font-size: 0.725rem; font-weight: 700; color: #334155; margin-bottom: 0.375rem;">
                                    Ganti Foto Produk:
                                </label>
                                <input type="file" name="image" id="image" accept="image/*"
                                       style="width: 100%; font-size: 0.7rem; color: #475569; background-color: #ffffff; border: 1px solid #cbd5e1; border-radius: 0.5rem; padding: 0.375rem; cursor: pointer;">
                                <p style="font-size: 0.65rem; color: #94a3b8; margin-top: 0.375rem; line-height: 1.2;">
                                    Kosongkan jika tidak ingin mengubah foto.
                                </p>
                            </div>
                        </div>

                        <!-- KOLOM KANAN: Form Input Detail Produk (Lebih Luas) -->
                        <div style="flex: 1; min-width: 300px; display: flex; flex-direction: column; gap: 1.25rem;">
                            
                            <!-- Input Nama Produk -->
                            <div>
                                <label for="name" style="display: block; font-size: 0.8rem; font-weight: 800; color: #334155; margin-bottom: 0.375rem;">
                                    Nama Produk / Makanan <span style="color: #dc2626;">*</span>
                                </label>
                                <input type="text" name="name" id="name" required 
                                       value="{{ old('name', $product->name) }}"
                                       placeholder="Contoh: Cookies Random Flavor"
                                       style="width: 100%; font-size: 0.85rem; padding: 0.625rem 0.875rem; border-radius: 0.625rem; border: 1px solid #cbd5e1; outline: none; color: #0f172a; box-sizing: border-box;">
                            </div>

                            <!-- Baris 2 Kolom untuk Harga -->
                            <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                                <div style="flex: 1; min-width: 180px;">
                                    <label for="normal_price" style="display: block; font-size: 0.8rem; font-weight: 800; color: #334155; margin-bottom: 0.375rem;">
                                        Harga Normal (Rp) <span style="color: #dc2626;">*</span>
                                    </label>
                                    <input type="number" name="normal_price" id="normal_price" required min="0" step="100"
                                           value="{{ old('normal_price', $product->normal_price) }}"
                                           placeholder="12000"
                                           style="width: 100%; font-size: 0.85rem; padding: 0.625rem 0.875rem; border-radius: 0.625rem; border: 1px solid #cbd5e1; outline: none; color: #0f172a; box-sizing: border-box;">
                                </div>

                                <div style="flex: 1; min-width: 180px;">
                                    <label for="discount_price" style="display: block; font-size: 0.8rem; font-weight: 800; color: #ea580c; margin-bottom: 0.375rem;">
                                        Harga Diskon LastCall (Rp) <span style="color: #dc2626;">*</span>
                                    </label>
                                    <input type="number" name="discount_price" id="discount_price" required min="0" step="100"
                                           value="{{ old('discount_price', $product->discount_price) }}"
                                           placeholder="9000"
                                           style="width: 100%; font-size: 0.85rem; padding: 0.625rem 0.875rem; border-radius: 0.625rem; border: 1px solid #cbd5e1; outline: none; color: #0f172a; background-color: #fff7ed; box-sizing: border-box;">
                                </div>
                            </div>

                            <!-- Input Stok Tersedia -->
                            <div>
                                <label for="stock" style="display: block; font-size: 0.8rem; font-weight: 800; color: #334155; margin-bottom: 0.375rem;">
                                    Sisa Stok Tersedia (Porsi) <span style="color: #dc2626;">*</span>
                                </label>
                                <input type="number" name="stock" id="stock" required min="0"
                                       value="{{ old('stock', $product->stock) }}"
                                       placeholder="10"
                                       style="width: 100%; font-size: 0.85rem; padding: 0.625rem 0.875rem; border-radius: 0.625rem; border: 1px solid #cbd5e1; outline: none; color: #0f172a; box-sizing: border-box;">
                            </div>

                            <!-- Input Deskripsi -->
                            <div>
                                <label for="description" style="display: block; font-size: 0.8rem; font-weight: 800; color: #334155; margin-bottom: 0.375rem;">
                                    Deskripsi Makanan
                                </label>
                                <textarea name="description" id="description" rows="3"
                                          placeholder="Jelaskan kondisi atau varian rasa produk surplus ini..."
                                          style="width: 100%; font-size: 0.85rem; padding: 0.625rem 0.875rem; border-radius: 0.625rem; border: 1px solid #cbd5e1; outline: none; color: #0f172a; box-sizing: border-box;">{{ old('description', $product->description) }}</textarea>
                            </div>

                            <!-- Tombol Simpan -->
                            <div style="padding-top: 0.5rem; display: flex; align-items: center; gap: 0.75rem;">
                                <button type="submit" 
                                        style="background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%); color: #ffffff; font-weight: 800; font-size: 0.85rem; padding: 0.625rem 1.75rem; border-radius: 0.625rem; border: none; cursor: pointer; box-shadow: 0 4px 12px rgba(234,88,12,0.25);">
                                    💾 Simpan Perubahan Produk
                                </button>
                                <a href="{{ url('/merchant/products') }}" 
                                   style="background-color: #f1f5f9; color: #475569; font-weight: 700; font-size: 0.85rem; padding: 0.625rem 1.25rem; border-radius: 0.625rem; text-decoration: none; border: 1px solid #e2e8f0;">
                                    Batal
                                </a>
                            </div>

                        </div>

                    </div>
                </form>

            </div>

        </div>
    </div>
</x-app-layout>