<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LastCall - Makanan Surplus Hemat & Lezat</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-stone-50 text-stone-800 antialiased">

    <!-- Header / Navbar -->
    <header class="bg-white border-b border-stone-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="text-2xl font-extrabold text-orange-600">LastCall 🥐</span>
            </div>
            
            <div>
                @if (Route::has('login'))
                    <div class="flex items-center gap-3">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-stone-700 hover:text-orange-600">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-semibold text-stone-700 hover:text-orange-600">Masuk</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="text-sm font-semibold bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 transition">Daftar</a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </header>

    <!-- Banner Hero -->
    <section class="bg-orange-600 text-white py-12 px-4 text-center">
        <h1 class="font-sans text-3xl sm:text-4xl font-black mb-2">Safe The Food, Catch The Lastcall!</h1>
        <p class="text-orange-100 max-w-xl mx-auto text-sm sm:text-base">Dapatkan makanan surplus berkualitas dari toko favoritmu dengan harga diskon khusus sebelum toko tutup.</p>
    </section>

    <!-- Katalog Produk Surplus -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h2 class="text-xl font-bold text-stone-900 mb-6">Pilihan Makanan Surplus Hari Ini</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($products as $product)
                <div class="bg-white rounded-xl shadow-sm border border-stone-200 overflow-hidden flex flex-col justify-between hover:shadow-md transition">
                    <div>
                        <!-- Gambar Produk -->
                        <div class="relative h-48 bg-stone-100">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-stone-400 text-xs">Tanpa Gambar</div>
                            @endif
                            
                            <span class="absolute top-2 right-2 bg-orange-600 text-white text-xs font-bold px-2 py-1 rounded-md">
                                Diskon {{ round((($product->normal_price - $product->discount_price) / $product->normal_price) * 100) }}%
                            </span>
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
    </main>

</body>
</html>