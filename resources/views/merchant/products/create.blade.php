<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-stone-800 leading-tight">
            {{ __('Tambah Produk Surplus Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('merchant.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1">Nama Produk / Makanan</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="w-full border-stone-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500" placeholder="Contoh: Roti Croissant Cokelat (Pack of 3)" required>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-stone-700 mb-1">Harga Asli (Rp)</label>
                            <input type="number" name="normal_price" value="{{ old('normal_price') }}" class="w-full border-stone-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500" placeholder="35000" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-stone-700 mb-1">Harga LastCall / Diskon (Rp)</label>
                            <input type="number" name="discount_price" value="{{ old('discount_price') }}" class="w-full border-stone-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500" placeholder="15000" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1">Jumlah Stok Surplus Hari Ini</label>
                        <input type="number" name="stock" value="{{ old('stock', 1) }}" min="1" class="w-full border-stone-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1">Foto Makanan</label>
                        <input type="file" name="image" accept="image/*" class="w-full text-sm text-stone-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 border border-stone-300 rounded-md">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1">Deskripsi Ringkas</label>
                        <textarea name="description" rows="3" class="w-full border-stone-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500" placeholder="Kondisi makanan masih sangat baik, dibuat pagi hari ini...">{{ old('description') }}</textarea>
                    </div>

                    <div class="flex justify-between items-center pt-3">
                        <a href="{{ route('merchant.products.index') }}" class="text-sm text-stone-600 hover:underline">Batal</a>
                        <button type="submit" class="bg-orange-600 text-white font-semibold px-5 py-2.5 rounded-lg hover:bg-orange-700 transition-colors shadow-sm">
                            Simpan Produk Surplus
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>