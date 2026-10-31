<x-app-layout>
    <x-slot name="header">
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h2 style="font-size: 1.25rem; font-weight: 800; color: #0f172a; margin-top: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                    <span>📦 Pesanan Masuk Outlet</span>
                    <span style="background-color: #fff7ed; color: #ea580c; border: 1px solid #ffedd5; font-size: 0.8rem; padding: 2px 10px; border-radius: 9999px;">
                        {{ $store->name ?? 'Toko' }}
                    </span>
                </h2>
                <p style="font-size: 0.8rem; color: #64748b; margin-top: 0.25rem; margin-bottom: 1rem;">
                    Cek Kode Pickup pelanggan dan selesaikan transaksi saat pesanan diambil.
                </p>
            </div>
        </div>
    </x-slot>

    <div style="padding: 2rem 0; background-color: #f8fafc; min-height: 85vh;">
        <div style="max-width: 1250px; margin: 0 auto; padding: 0 1rem;" class="space-y-6">

            @if(session('success'))
                <div style="background-color: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 1rem; border-radius: 1rem; font-weight: 800;">
                    🎉 {{ session('success') }}
                </div>
            @endif

            @forelse($orders as $pickupCode => $items)
                @php 
                    $firstItem = $items->first();
                    $customer = $firstItem->user ?? null;
                    $totalHargaStruk = $items->sum('total_price');
                    $isCompleted = $items->every(fn($i) => $i->status == 'completed' || $i->status == 'Selesai');
                @endphp

                <!-- KARTU STRUK MERCHANT -->
                <div style="background-color: #ffffff; border-radius: 1.25rem; border: 1px solid #e2e8f0; padding: 1.25rem; box-shadow: 0 4px 12px rgba(0,0,0,0.02);">
                    
                    <!-- Header Struk Merchant -->
                    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px dashed #e2e8f0; padding-bottom: 0.75rem; margin-bottom: 1rem; flex-wrap: wrap; gap: 0.5rem;">
                        <div>
                            <span style="font-size: 0.75rem; font-weight: 800; color: #64748b; display: block; margin-bottom: 2px;">
                                KODE PICKUP: <strong style="color: #ea580c; font-size: 0.9rem;">{{ $pickupCode }}</strong>
                            </span>
                            <h4 style="font-size: 0.95rem; font-weight: 800; color: #0f172a; margin: 0;">
                                👤 Pelanggan: <span style="color: #ea580c;">{{ $customer->name ?? 'Pembeli' }}</span>
                            </h4>
                        </div>

                        <div>
                            @if($isCompleted)
                                <span style="background-color: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; font-size: 0.75rem; font-weight: 800; padding: 4px 12px; border-radius: 9999px;">
                                    ✅ Selesai
                                </span>
                            @else
                                <span style="background-color: #fff7ed; color: #ea580c; border: 1px solid #ffedd5; font-size: 0.75rem; font-weight: 800; padding: 4px 12px; border-radius: 9999px;">
                                    ⏳ Menunggu Pickup
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Daftar Makanan dalam 1 Struk -->
                    <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                        @foreach($items as $item)
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div style="display: flex; gap: 0.75rem; align-items: center;">
                                    <div style="width: 45px; height: 45px; background-color: #f1f5f9; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; overflow: hidden; flex-shrink: 0;">
                                        @if($item->product && $item->product->image)
                                            <img src="{{ \Illuminate\Support\Str::startsWith($item->product->image, ['http://', 'https://']) ? $item->product->image : asset('storage/' . $item->product->image) }}" 
                                                 alt="{{ $item->product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            🍲
                                        @endif
                                    </div>
                                    <div>
                                        <h5 style="font-size: 0.9rem; font-weight: 800; color: #0f172a; margin: 0;">{{ $item->product->name ?? 'Produk Makanan' }}</h5>
                                        <span style="font-size: 0.75rem; color: #64748b;">Jumlah: {{ $item->quantity }} Porsi</span>
                                    </div>
                                </div>
                                <span style="font-weight: 800; font-size: 0.85rem; color: #0f172a;">Rp {{ number_format($item->total_price, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>

                    <!-- Footer Total & Action Button -->
                    <div style="border-top: 1px solid #f1f5f9; margin-top: 1rem; padding-top: 0.75rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem;">
                        <div>
                            <span style="font-size: 0.7rem; color: #64748b; display: block;">Total Terima Kasir:</span>
                            <span style="font-size: 1.15rem; font-weight: 900; color: #ea580c;">Rp {{ number_format($totalHargaStruk, 0, ',', '.') }}</span>
                        </div>

                        @if(!$isCompleted)
                            <form action="{{ url('/merchant/orders/' . $pickupCode . '/complete') }}" method="POST">
                                @csrf
                                <button type="submit" style="background-color: #16a34a; color: white; font-weight: 800; font-size: 0.85rem; padding: 0.6rem 1.25rem; border-radius: 0.75rem; border: none; cursor: pointer; display: flex; align-items: center; gap: 0.4rem; box-shadow: 0 2px 6px rgba(22, 163, 74, 0.2);">
                                    ✅ Serahkan Semua Makanan
                                </button>
                            </form>
                        @endif
                    </div>

                </div>
            @empty
                <div style="text-align: center; padding: 4rem 1rem; background-color: #ffffff; border-radius: 1.25rem; border: 1px solid #e2e8f0;">
                    <h4 style="font-weight: 800; color: #0f172a; margin: 0;">Belum ada pesanan masuk</h4>
                </div>
            @endforelse

        </div>
    </div>
</x-app-layout>