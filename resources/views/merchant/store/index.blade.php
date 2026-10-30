<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-stone-800 leading-tight">
            {{ __('Pengaturan Toko - LastCall') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg text-sm font-medium">
                        {{ session('success') }}
                    </div>
                @endif

                <h3 class="text-lg font-bold text-stone-900 mb-4">Profil Toko / Restoran</h3>

                <!-- Pastikan menggunakan enctype="multipart/form-data" -->
                <form action="{{ route('merchant.store.save') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    
                    <!-- Foto Toko -->
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1">Foto Toko / Banner</label>
                        @if(!empty($store->image))
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $store->image) }}" alt="Foto Toko" class="w-40 h-40 object-cover rounded-lg border border-stone-200 shadow-sm">
                            </div>
                        @endif
                        <input type="file" name="image" accept="image/*" class="w-full text-sm text-stone-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 border border-stone-300 rounded-md">
                        <p class="text-xs text-stone-500 mt-1">Format: JPG, PNG, WEBP (Maksimal 2MB)</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1">Nama Toko / Restoran</label>
                        <input type="text" name="name" value="{{ old('name', $store->name ?? '') }}" class="w-full border-stone-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500" placeholder="Contoh: Bakery Berkah Senja" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1">Alamat Lengkap Toko</label>
                        <textarea name="address" rows="3" class="w-full border-stone-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500" placeholder="Jl. Sudirman No. 10..." required>{{ old('address', $store->address ?? '') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1">Jam Tutup Operasional (Jam LastCall)</label>
                        <input type="time" name="closing_time" value="{{ old('closing_time', $store->closing_time ?? '21:00') }}" class="w-full border-stone-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500" required>
                        <p class="text-xs text-stone-500 mt-1">Pelanggan akan mengambil pesanan *self-pickup* mendekati jam tutup ini.</p>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="bg-orange-600 text-white font-semibold px-5 py-2.5 rounded-lg hover:bg-orange-700 transition-colors shadow-sm">
                            Simpan Profil Toko
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>