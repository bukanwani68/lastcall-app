<x-app-layout>
    <x-slot name="header">
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 0.5rem;">
            <div>
                <h2 style="font-size: 1.25rem; font-weight: 800; color: #1c1917; margin-top: 1rem; margin-bottom: 0.25rem; display: flex; align-items: center; gap: 0.5rem;">
                    <span>Pengaturan Profil Toko</span>
                    <span style="background-color: #ffedd5; color: #ea580c; font-size: 0.75rem; font-weight: 800; padding: 2px 8px; border-radius: 9999px; border: 1px solid #fed7aa;">
                        Merchant Store 🏪
                    </span>
                </h2>
                <p style="font-size: 0.75rem; color: #78716c; margin-top: 0.25rem; margin-bottom: 1rem;">Kelola informasi profil toko yang tampil di katalog LastCall.</p>
            </div>
        </div>
    </x-slot>

    <div style="padding: 2rem 0; background-color: #f8fafc; min-height: 85vh;">
        <div style="max-width: 1250px; margin: 0 auto; padding: 0 1rem;">

            <!-- Alert Flash Success & Error -->
            @if(session('success'))
                <div style="background-color: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 0.875rem 1.25rem; border-radius: 1rem; font-size: 0.825rem; font-weight: 700; margin-bottom: 1.5rem;">
                    🎉 {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div style="background-color: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 0.875rem 1.25rem; border-radius: 1rem; font-size: 0.825rem; font-weight: 700; margin-bottom: 1.5rem;">
                    <ul style="margin: 0; padding-left: 1rem;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Card Utama Form Profil Toko -->
            <div style="background-color: #ffffff; border-radius: 1.25rem; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
                
                <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid #f1f5f9; background-color: #ffffff;">
                    <h3 style="font-size: 1rem; font-weight: 800; color: #0f172a; margin: 0;">Detail Informasi Toko</h3>
                    <p style="font-size: 0.75rem; color: #64748b; margin-top: 0.25rem;">Perbarui foto, nama, alamat, dan batas jam pickup toko Anda.</p>
                </div>

                <form action="{{ url('/merchant/store') }}" method="POST" enctype="multipart/form-data" style="padding: 1.75rem;">
                    @csrf

                    <!-- Layout Berdampingan (Foto di Kiri, Input di Kanan) -->
                    <div style="display: flex; flex-direction: row; gap: 2rem; align-items: flex-start; flex-wrap: wrap;">
                        
                        <!-- SISI KIRI: Frame Foto Toko Terkunci (120x120 px) -->
                        <div style="width: 180px; flex-shrink: 0; background-color: #f8fafc; padding: 1.25rem; border-radius: 1rem; border: 1px solid #e2e8f0; text-align: center;">
                            <label style="display: block; font-size: 0.75rem; font-weight: 800; color: #475569; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.75rem;">
                                Foto Toko
                            </label>

                            <!-- Kotak Gambar Dikunci Mutlak -->
                            <div style="width: 120px !important; height: 120px !important; max-width: 120px !important; max-height: 120px !important; border-radius: 1rem; overflow: hidden; background-color: #e2e8f0; border: 2px solid #ea580c; margin: 0 auto 1rem auto; box-shadow: 0 2px 8px rgba(234,88,12,0.15); position: relative;">
                                @if(isset($store) && $store->image)
                                    <img src="{{ \Illuminate\Support\Str::startsWith($store->image, ['http://', 'https://']) ? $store->image : asset('storage/' . $store->image) }}" 
                                         alt="{{ $store->name }}"
                                         style="width: 120px !important; height: 120px !important; max-width: 120px !important; max-height: 120px !important; object-fit: cover !important; display: block;">
                                @else
                                    <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 2rem; background-color: #ffedd5; color: #ea580c; font-weight: 900;">
                                        {{ isset($store) && $store->name ? substr($store->name, 0, 1) : '🏪' }}
                                    </div>
                                @endif
                            </div>

                            <!-- Input Upload -->
                            <div style="text-align: left;">
                                <label for="image" style="display: block; font-size: 0.725rem; font-weight: 700; color: #334155; margin-bottom: 0.375rem;">
                                    Ganti Foto:
                                </label>
                                <input type="file" name="image" id="image" accept="image/*"
                                       style="width: 100%; font-size: 0.7rem; color: #475569; background-color: #ffffff; border: 1px solid #cbd5e1; border-radius: 0.5rem; padding: 0.375rem; cursor: pointer;">
                                <p style="font-size: 0.65rem; color: #94a3b8; margin-top: 0.375rem; line-height: 1.2;">
                                    Format: JPG, PNG, WEBP (Maks. 2MB)
                                </p>
                            </div>
                        </div>

                        <!-- SISI KANAN: Form Kolom Input Teks -->
                        <div style="flex: 1; min-width: 280px; display: flex; flex-direction: column; gap: 1.25rem;">
                            
                            <!-- Input Nama Toko -->
                            <div>
                                <label for="name" style="display: block; font-size: 0.8rem; font-weight: 800; color: #334155; margin-bottom: 0.375rem;">
                                    Nama Toko / Restoran <span style="color: #dc2626;">*</span>
                                </label>
                                <input type="text" name="name" id="name" required 
                                       value="{{ old('name', $store->name ?? '') }}"
                                       placeholder="Contoh: Toko Berkah Jaya"
                                       style="width: 100%; font-size: 0.85rem; padding: 0.625rem 0.875rem; border-radius: 0.625rem; border: 1px solid #cbd5e1; outline: none; color: #0f172a; box-sizing: border-box;">
                            </div>

                            <!-- Input Alamat Lengkap -->
                            <div>
                                <label for="address" style="display: block; font-size: 0.8rem; font-weight: 800; color: #334155; margin-bottom: 0.375rem;">
                                    Alamat Lengkap Toko <span style="color: #dc2626;">*</span>
                                </label>
                                <textarea name="address" id="address" rows="3" required
                                          placeholder="Masukkan alamat lengkap lokasi pengambilan makanan surplus..."
                                          style="width: 100%; font-size: 0.85rem; padding: 0.625rem 0.875rem; border-radius: 0.625rem; border: 1px solid #cbd5e1; outline: none; color: #0f172a; box-sizing: border-box;">{{ old('address', $store->address ?? '') }}</textarea>
                            </div>

                            <!-- Input Jam Tutup Pickup -->
                            <div>
                                <label for="closing_time" style="display: block; font-size: 0.8rem; font-weight: 800; color: #334155; margin-bottom: 0.375rem;">
                                    Jam Tutup Operasional (Jam LastCall) <span style="color: #dc2626;">*</span>
                                </label>
                                <input type="text" name="closing_time" id="closing_time" required
                                       value="{{ old('closing_time', $store->closing_time ?? '') }}"
                                       placeholder="Contoh: 18:00 WIB"
                                       style="width: 100%; font-size: 0.85rem; padding: 0.625rem 0.875rem; border-radius: 0.625rem; border: 1px solid #cbd5e1; outline: none; color: #0f172a; box-sizing: border-box;">
                                <p style="font-size: 0.7rem; color: #64748b; margin-top: 0.25rem;">
                                    Pelanggan akan mengambil pesanan *self-pickup* mendekati jam tutup ini.
                                </p>
                            </div>

                            <!-- Tombol Simpan -->
                            <div style="padding-top: 0.5rem; display: flex; justify-content: flex-start;">
                                <button type="submit" 
                                        style="background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%); color: #ffffff; font-weight: 800; font-size: 0.85rem; padding: 0.625rem 1.75rem; border-radius: 0.625rem; border: none; cursor: pointer; box-shadow: 0 4px 12px rgba(234,88,12,0.25);">
                                    💾 Simpan Profil Toko
                                </button>
                            </div>

                        </div>

                    </div>
                </form>

            </div>

        </div>
    </div>
</x-app-layout>