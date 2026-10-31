<x-app-layout>
    <x-slot name="header">
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h2 style="font-size: 1.25rem; font-weight: 800; color: #0f172a; margin-top: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                    <span>➕ Tambah Produk Surplus</span>
                </h2>
                <p style="font-size: 0.8rem; color: #64748b; margin-top: 0.25rem; margin-bottom: 1rem;">
                    Daftarkan makanan surplus toko Anda agar tidak terbuang dan bisa dibeli pelanggan LastCall.
                </p>
            </div>
            <a href="{{ url('/merchant/products') }}" style="background-color: #f1f5f9; color: #475569; font-size: 0.85rem; font-weight: 700; padding: 0.5rem 1rem; border-radius: 0.75rem; text-decoration: none; display: flex; align-items: center; gap: 0.4rem;">
                &larr; Kembali ke Kelola Produk
            </a>
        </div>
    </x-slot>

    <div style="padding: 2rem 0; background-color: #f8fafc; min-height: 85vh;">
        <div style="max-width: 1250px; margin: 0 auto; padding: 0 1rem;">

            <div style="background-color: #ffffff; border-radius: 1.25rem; border: 1px solid #e2e8f0; box-shadow: 0 4px 12px rgba(0,0,0,0.03); overflow: hidden;">
                
                <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid #f1f5f9; background-color: #ffffff;">
                    <h3 style="font-size: 1rem; font-weight: 800; color: #0f172a; margin: 0;">Formulir Makanan Surplus Baru</h3>
                </div>

                <form action="{{ url('/merchant/products') }}" method="POST" enctype="multipart/form-data" style="padding: 1.5rem; display: flex; flex-direction: column; gap: 1.25rem;">
                    @csrf

                    <!-- Notifikasi Error Validasi -->
                    @if ($errors->any())
                        <div style="background-color: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 1rem; border-radius: 0.75rem; font-size: 0.85rem; font-weight: 700;">
                            <p style="margin: 0 0 0.5rem 0;">⚠️ Gagal menyimpan produk. Periksa kembali form berikut:</p>
                            <ul style="margin: 0; padding-left: 1.25rem;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Nama Makanan -->
                    <div>
                        <label style="display: block; font-size: 0.85rem; font-weight: 800; color: #334155; margin-bottom: 0.5rem;">
                            🍲 Nama Produk / Makanan <span style="color: #ef4444;">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: Roti Croissant Cokelat (Pack of 3)" 
                               style="width: 100%; padding: 0.75rem 1rem; border-radius: 0.75rem; border: 1px solid #cbd5e1; font-size: 0.9rem; font-weight: 600; color: #0f172a; outline: none; box-sizing: border-box;">
                    </div>

                    <!-- Grid Harga Asli, Harga Diskon, & Stok -->
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(210px, 1fr)); gap: 1rem;">
                        <!-- Harga Asli -->
                       <div>
                            <label style="display: block; font-size: 0.85rem; font-weight: 800; color: #334155; margin-bottom: 0.5rem;">
                                🏷️ Harga Asli (Rp) <span style="color: #ef4444;">*</span>
                            </label>
                            <input type="number" name="normal_price" value="{{ old('normal_price') }}" required placeholder="35000" 
                                style="width: 100%; padding: 0.75rem 1rem; border-radius: 0.75rem; border: 1px solid #cbd5e1; font-size: 0.9rem; font-weight: 600; color: #0f172a; outline: none; box-sizing: border-box;">
                        </div>

                        <!-- Harga Diskon -->
                        <div>
                            <label style="display: block; font-size: 0.85rem; font-weight: 800; color: #ea580c; margin-bottom: 0.5rem;">
                                🔥 Harga LastCall / Diskon (Rp) <span style="color: #ef4444;">*</span>
                            </label>
                            <input type="number" name="discount_price" value="{{ old('discount_price') }}" required placeholder="15000" 
                                   style="width: 100%; padding: 0.75rem 1rem; border-radius: 0.75rem; border: 2px solid #ffedd5; background-color: #fff7ed; font-size: 0.9rem; font-weight: 800; color: #ea580c; outline: none; box-sizing: border-box;">
                        </div>

                        <!-- Stok -->
                        <div>
                            <label style="display: block; font-size: 0.85rem; font-weight: 800; color: #334155; margin-bottom: 0.5rem;">
                                📦 Stok Surplus Hari Ini <span style="color: #ef4444;">*</span>
                            </label>
                            <input type="number" name="stock" value="{{ old('stock', 1) }}" required min="1" 
                                   style="width: 100%; padding: 0.75rem 1rem; border-radius: 0.75rem; border: 1px solid #cbd5e1; font-size: 0.9rem; font-weight: 600; color: #0f172a; outline: none; box-sizing: border-box;">
                        </div>
                    </div>

                    <!-- Upload Foto Makanan Custom -->
                    <div>
                        <label style="display: block; font-size: 0.85rem; font-weight: 800; color: #334155; margin-bottom: 0.5rem;">
                            📸 Foto Makanan
                        </label>
                        <div style="border: 2px dashed #cbd5e1; border-radius: 0.875rem; padding: 1.25rem; text-align: center; background-color: #f8fafc; cursor: pointer; position: relative;">
                            <input type="file" name="image" accept="image/*" id="imageInput" onchange="previewFileName(this)"
                                   style="position: absolute; width: 100%; height: 100%; top: 0; left: 0; opacity: 0; cursor: pointer;">
                            <div id="uploadContent">
                                <span style="font-size: 1.75rem; display: block; margin-bottom: 0.25rem;">📷</span>
                                <span style="font-size: 0.85rem; font-weight: 700; color: #ea580c;">Klik untuk upload foto makanan</span>
                                <p style="font-size: 0.75rem; color: #94a3b8; margin: 0.25rem 0 0 0;">Format JPG, PNG, atau WEBP (Maksimal 2MB)</p>
                            </div>
                            <span id="fileNameDisplay" style="display: none; font-size: 0.85rem; font-weight: 800; color: #166534; background-color: #f0fdf4; padding: 0.5rem 1rem; border-radius: 0.5rem; border: 1px solid #bbf7d0;"></span>
                        </div>
                    </div>

                    <!-- Deskripsi Makanan -->
                    <div>
                        <label style="display: block; font-size: 0.85rem; font-weight: 800; color: #334155; margin-bottom: 0.5rem;">
                            📝 Deskripsi Ringkas
                        </label>
                        <textarea name="description" rows="3" placeholder="Kondisi makanan masih sangat baik, dibuat pagi hari ini..." 
                                  style="width: 100%; padding: 0.75rem 1rem; border-radius: 0.75rem; border: 1px solid #cbd5e1; font-size: 0.875rem; font-weight: 500; color: #0f172a; outline: none; box-sizing: border-box; font-family: inherit; resize: vertical;">{{ old('description') }}</textarea>
                    </div>

                    <!-- Footer Action Buttons -->
                    <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #f1f5f9; padding-top: 1rem; margin-top: 0.5rem;">
                        <a href="{{ url('/merchant/products') }}" style="color: #64748b; font-size: 0.875rem; font-weight: 700; text-decoration: none; padding: 0.75rem 1.25rem; border-radius: 0.75rem; background-color: #f1f5f9;">
                            Batal
                        </a>
                        <button type="submit" style="background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%); color: white; font-weight: 800; font-size: 0.9rem; padding: 0.75rem 1.75rem; border-radius: 0.75rem; border: none; cursor: pointer; box-shadow: 0 4px 12px rgba(234, 88, 12, 0.25);">
                            ✨ Simpan Produk Surplus
                        </button>
                    </div>

                </form>

            </div>

        </div>
    </div>

    <script>
        function previewFileName(input) {
            const uploadContent = document.getElementById('uploadContent');
            const fileNameDisplay = document.getElementById('fileNameDisplay');
            if (input.files && input.files[0]) {
                uploadContent.style.display = 'none';
                fileNameDisplay.style.display = 'inline-block';
                fileNameDisplay.innerText = '📄 Foto terpilih: ' + input.files[0].name;
            }
        }
    </script>
</x-app-layout>