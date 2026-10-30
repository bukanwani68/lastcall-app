<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-stone-800 leading-tight">
                {{ __('Kelola Produk Surplus - LastCall') }}
            </h2>
            <a href="{{ route('merchant.products.create') }}" class="bg-orange-600 text-white font-semibold px-4 py-2 rounded-lg text-sm hover:bg-orange-700 transition-colors">
                + Tambah Produk
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            
            @if(session('success'))
                <div class="p-4 bg-green-100 text-green-700 rounded-lg text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif

            @if(!$store)
                <div class="p-4 bg-amber-100 text-amber-800 rounded-lg text-sm">
                    Anda belum mengisi profil toko. <a href="{{ route('merchant.store.index') }}" class="underline font-bold">Atur Profil Toko di sini</a> sebelum menambah produk.
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-stone-200 text-stone-500 text-xs font-semibold uppercase">
                            <th class="py-3 px-4">Foto</th>
                            <th class="py-3 px-4">Nama Produk</th>
                            <th class="py-3 px-4">Harga Asli</th>
                            <th class="py-3 px-4">Harga LastCall</th>
                            <th class="py-3 px-4">Stok</th>
                            <th class="py-3 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100 text-sm text-stone-700">
                        @forelse($products as $product)
                            <tr>
                                <td class="py-3 px-4">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" class="w-12 h-12 object-cover rounded-md border border-stone-200">
                                    @else
                                        <div class="w-12 h-12 bg-stone-100 rounded-md flex items-center justify-center text-stone-400 text-xs">No Img</div>
                                    @endif
                                </td>
                                <td class="py-3 px-4 font-semibold text-stone-900">{{ $product->name }}</td>
                                <td class="py-3 px-4 text-stone-400 line-through">Rp {{ number_format($product->normal_price, 0, ',', '.') }}</td>
                                <td class="py-3 px-4 text-orange-600 font-bold">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</td>
                                <td class="py-3 px-4">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $product->stock > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $product->stock }} porsi
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-right space-x-2">
                                    <a href="{{ route('merchant.products.edit', $product->id) }}" class="text-stone-600 hover:text-stone-900 font-medium">Edit</a>
                                    <form action="{{ route('merchant.products.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-8 text-stone-400">Belum ada produk surplus yang ditambahkan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>