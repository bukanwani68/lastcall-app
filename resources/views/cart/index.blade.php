<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size: 1.25rem; font-weight: 800; color: #0f172a;">🛒 Keranjang Belanja Saya</h2>
    </x-slot>

    <div style="padding: 2rem 0; background-color: #f8fafc; min-height: 85vh;">
        <div style="max-width: 900px; margin: 0 auto; padding: 0 1rem;" class="space-y-6">

            @if(session('success'))
                <div style="background-color: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 1rem; border-radius: 1rem; font-weight: 800;">
                    🎉 {{ session('success') }}
                </div>
            @endif

            @forelse($groupedCart as $storeId => $items)
                @php $store = $items->first()->product->store; @endphp
                
                <!-- Kartu Kelompok Toko -->
                <div style="background-color: #ffffff; border-radius: 1.25rem; border: 1px solid #e2e8f0; padding: 1.25rem; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
                    <div style="border-bottom: 1px solid #f1f5f9; padding-bottom: 0.75rem; margin-bottom: 1rem; display: flex; justify-content: space-between; align-items: center;">
                        <h4 style="font-weight: 800; color: #0f172a; margin: 0; font-size: 1rem;">
                            🏪 Toko: <span style="color: #ea580c;">{{ $store->name ?? 'Toko' }}</span>
                        </h4>
                        <span style="font-size: 0.75rem; background-color: #ffedd5; color: #c2410c; padding: 4px 10px; border-radius: 9999px; font-weight: 700;">
                            1 Struk Kode Pickup
                        </span>
                    </div>

                    <!-- Daftar Produk di Toko Ini -->
                    @php $subtotalStore = 0; @endphp
                    @foreach($items as $item)
                        @php 
                            $itemTotal = $item->product->discount_price * $item->quantity; 
                            $subtotalStore += $itemTotal;
                        @endphp
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                            <div style="display: flex; gap: 1rem; align-items: center;">
                                <div style="width: 50px; height: 50px; background-color: #f1f5f9; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; font-size: 1.25rem;">🍲</div>
                                <div>
                                    <h5 style="font-weight: 800; color: #0f172a; margin: 0; font-size: 0.9rem;">{{ $item->product->name }}</h5>
                                    <p style="font-size: 0.75rem; color: #64748b; margin: 0;">{{ $item->quantity }} Porsi x Rp {{ number_format($item->product->discount_price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <span style="font-weight: 800; color: #0f172a; font-size: 0.9rem;">Rp {{ number_format($itemTotal, 0, ',', '.') }}</span>
                                <form action="{{ url('/cart/' . $item->id) }}" method="POST" style="margin:0;">
                                    @csrf
                                    @method('DELETE')
                                    <button style="color: #ef4444; border: none; background: none; cursor: pointer; font-weight: 800; font-size: 0.8rem;">🗑️ Hapus</button>
                                </form>
                            </div>
                        </div>
                    @endforeach

                    <div style="border-top: 1px dashed #e2e8f0; pt-2; margin-top: 0.5rem; text-align: right; font-size: 0.85rem; color: #475569;">
                        Subtotal {{ $store->name ?? 'Toko' }}: <strong style="color: #ea580c; font-size: 1rem;">Rp {{ number_format($subtotalStore, 0, ',', '.') }}</strong>
                    </div>
                </div>
            @empty
                <div style="text-align: center; padding: 4rem 1rem; background-color: #ffffff; border-radius: 1.25rem; border: 1px solid #e2e8f0;">
                    <div style="font-size: 3rem; margin-bottom: 0.5rem;">🛒</div>
                    <h4 style="font-weight: 800; color: #0f172a; margin: 0;">Keranjang Belanja Masih Kosong</h4>
                    <a href="{{ url('/dashboard') }}" style="display: inline-block; margin-top: 1rem; background-color: #ea580c; color: white; padding: 0.5rem 1.5rem; border-radius: 0.75rem; text-decoration: none; font-weight: 800; font-size: 0.85rem;">Cari Makanan Makanan Surplus</a>
                </div>
            @endforelse

            @if($groupedCart->isNotEmpty())
                <form action="{{ url('/cart/checkout') }}" method="POST" style="text-align: right;">
                    @csrf
                    <button type="submit" style="background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%); color: white; font-weight: 900; padding: 0.85rem 2rem; border-radius: 0.85rem; border: none; cursor: pointer; font-size: 1rem; box-shadow: 0 4px 14px rgba(234,88,12,0.3);">
                        🚀 Checkout Sekarang (Pisah Struk Otomatis)
                    </button>
                </form>
            @endif

        </div>
    </div>
</x-app-layout>