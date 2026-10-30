<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-stone-800 leading-tight">
            {{ __('Katalog Makanan Surplus Hari Ini') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Grid Katalog Produk Surplus -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($products as $product)
                    <div class="bg-white rounded-xl shadow-sm border border-stone-200 overflow-hidden flex flex-col justify-between hover:shadow-md transition">
                        <div>
                            <!-- Gambar Produk -->
                            <div class="relative h-48 bg-stone-100">
                                @if($product->image)
                                    <img src="{{ \Illuminate\Support\Str::startsWith($product->image, ['http://', 'https://']) ? $product->image : asset('storage/' . $product->image) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-stone-400 text-xs">Tanpa Gambar</div>
                                @endif
                                
                                @if($product->normal_price > 0)
                                    <span class="absolute top-2 right-2 bg-orange-600 text-white text-xs font-bold px-2 py-1 rounded-md">
                                        Diskon {{ round((($product->normal_price - $product->discount_price) / $product->normal_price) * 100) }}%
                                    </span>
                                @endif
                            </div>

                            <!-- Detail Produk -->
                            <div class="p-4">
                                <p class="text-xs font-semibold text-orange-600 mb-1">🏪 {{ $product->store->name ?? 'Toko' }}</p>
                                <h3 class="font-bold text-stone-900 text-base mb-1">{{ $product->name }}</h3>
                                <p class="text-xs text-stone-500 line-clamp-2 mb-3">{{ $product->description ?? 'Makanan siap di-pickup sebelum toko tutup.' }}</p>
                                
                                <div class="flex items-baseline gap-2">
                                    <span class="text-lg font-black text-orange-600">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                                    <span class="text-xs text-stone-400 line-through">Rp {{ number_format($product->normal_price, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Info Self-Pickup & Stok -->
                        <div class="px-4 py-3 bg-stone-50 border-t border-stone-100 text-xs flex items-center justify-between">
                            <span class="text-stone-500">Stok: <strong class="text-stone-700">{{ $product->stock }}</strong></span>
                            <span class="text-amber-700 bg-amber-50 px-2 py-0.5 rounded font-medium">Pickup {{ $product->store->closing_time ?? 'Tutup' }}</span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 text-stone-400">
                        <p class="text-base font-semibold">Belum ada makanan surplus yang tersedia saat ini.</p>
                        <p class="text-xs mt-1">Cek kembali nanti mendekati jam tutup toko!</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>