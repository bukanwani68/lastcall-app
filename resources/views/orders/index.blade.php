<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size: 1.25rem; font-weight: 800; margin-top: 1.5rem; margin-bottom: 0.5rem; color: #0f172a;">Pesanan Saya 🛍️</h2>
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
                    $store = $firstItem->product->store ?? null;
                    $totalStruk = $items->sum('total_price');
                @endphp

                <!-- KARTU STRUK PESANAN -->
                <div style="background-color: #ffffff; border-radius: 1.25rem; border: 1px solid #e2e8f0; padding: 1.25rem; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
                    
                    <!-- Header Struk -->
                    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px dashed #e2e8f0; padding-bottom: 0.75rem; margin-bottom: 1rem; flex-wrap: wrap; gap: 0.5rem;">
                        <div>
                            <span style="font-size: 0.75rem; font-weight: 800; color: #94a3b8;">
                                KODE PICKUP: <strong style="color: #ea580c; font-size: 0.85rem;">{{ $pickupCode }}</strong>
                            </span>
                            <h4 style="font-size: 1rem; font-weight: 800; color: #0f172a; margin: 2px 0 0 0;">
                                🏪 {{ $store->name ?? 'Toko Merchant' }}
                            </h4>
                        </div>

                        <div>
                            @if($firstItem->status == 'pending')
                                <span style="background-color: #fff7ed; color: #ea580c; border: 1px solid #ffedd5; font-size: 0.75rem; font-weight: 800; padding: 4px 12px; border-radius: 9999px;">
                                    ⏳ Perlu Dipickup
                                </span>
                            @else
                                <span style="background-color: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; font-size: 0.75rem; font-weight: 800; padding: 4px 12px; border-radius: 9999px;">
                                    ✅ Selesai
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Item Makanan di Dalam Struk -->
                    <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                        @foreach($items as $item)
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div style="display: flex; gap: 0.75rem; align-items: center;">
                                    <div style="width: 45px; height: 45px; background-color: #f1f5f9; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; overflow: hidden; flex-shrink: 0;">
                                        @if($item->product && $item->product->image)
                                            <img src="{{ \Illuminate\Support\Str::startsWith($item->product->image, ['http://', 'https://']) ? $item->product->image : asset('storage/' . $item->product->image) }}" 
                                                 alt="{{ $item->product->name }}"
                                                 style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            🍲
                                        @endif
                                    </div>
                                    <div>
                                        <h5 style="font-size: 0.9rem; font-weight: 800; color: #0f172a; margin: 0;">{{ $item->product->name ?? 'Produk Makanan' }}</h5>
                                        <span style="font-size: 0.75rem; color: #64748b;">{{ $item->quantity }} Porsi × Rp {{ number_format($item->product->discount_price ?? 0, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                <span style="font-weight: 800; font-size: 0.85rem; color: #0f172a;">Rp {{ number_format($item->total_price, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>

                    <!-- Footer Total Struk -->
                    <div style="border-top: 1px solid #f1f5f9; margin-top: 1rem; padding-top: 0.75rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem;">
                        <span style="font-size: 0.75rem; color: #64748b;">📍 {{ $store->address ?? 'Alamat Outlet' }}</span>
                        <div style="text-align: right;">
                            <span style="font-size: 0.7rem; color: #64748b; display: block;">Total Tagihan Kasir:</span>
                            <span style="font-size: 1.15rem; font-weight: 900; color: #ea580c;">Rp {{ number_format($totalStruk, 0, ',', '.') }}</span>
                        </div>
                    </div>

                </div>
            @empty
                <div style="text-align: center; padding: 4rem 1rem; background-color: #ffffff; border-radius: 1.25rem; border: 1px solid #e2e8f0;">
                    <h4 style="font-weight: 800; color: #0f172a; margin: 0;">Belum ada pesanan aktif</h4>
                </div>
            @endforelse

        </div>
    </div>
</x-app-layout>