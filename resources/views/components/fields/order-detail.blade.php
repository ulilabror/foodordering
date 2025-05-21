<div>
    <h2 class="text-lg font-bold mb-4 dark:text-gray-200">Detail Pesanan</h2>

    {{-- Informasi Pesanan --}}
    <div class="grid grid-cols-2 gap-4 mb-6">
        <div>
            <p class="dark:text-gray-300"><strong>Status:</strong> {{ $order->status }}</p>
            <p class="dark:text-gray-300"><strong>Metode Pembayaran:</strong> {{ $order->payment_method }}</p>
        </div>
        <div>
            <p class="dark:text-gray-300"><strong>Tanggal Pesanan:</strong> {{ $order->created_at->format('d M Y, H:i') }}</p>
        </div>
    </div>

    {{-- Item Pesanan --}}
    <h3 class="text-md font-bold mb-2 dark:text-gray-200">Item Pesanan</h3>
    <table class="table-auto w-full border-collapse border border-gray-300 dark:border-gray-600">
        <thead>
            <tr class="bg-gray-100 dark:bg-gray-700">
                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left dark:text-gray-300">Nama Menu</th>
                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left dark:text-gray-300">Jumlah</th>
                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left dark:text-gray-300">Harga</th>
                <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left dark:text-gray-300">Total</th>
            </tr>
        </thead>
        <tbody>
            @php
                $subtotal = 0;
            @endphp
            @foreach ($order->orderItems as $item)
                @php
                    $itemTotal = $item->quantity * $item->price;
                    $subtotal += $itemTotal;
                @endphp
                <tr class="dark:bg-gray-800">
                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2 dark:text-gray-300">{{ $item->menu->name }}</td>
                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2 dark:text-gray-300">{{ $item->quantity }}</td>
                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2 dark:text-gray-300">Rp{{ number_format($item->price, 2) }}</td>
                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2 dark:text-gray-300">Rp{{ number_format($itemTotal, 2) }}</td>
                </tr>
            @endforeach

            {{-- Baris Biaya Pengiriman --}}
            @if ($order->delivery && $order->delivery->delivery_fee)
                <tr class="bg-gray-100 dark:bg-gray-700">
                    <td colspan="3" class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-right dark:text-gray-300 font-bold">Biaya Pengiriman</td>
                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-2 dark:text-gray-300">Rp{{ number_format($order->delivery->delivery_fee, 2) }}</td>
                </tr>
            @endif

            {{-- Baris Total Keseluruhan --}}
            <tr class="bg-gray-200 dark:bg-gray-800">
                <td colspan="3" class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-right dark:text-gray-300 font-bold">Total Keseluruhan</td>
                <td class="border border-gray-300 dark:border-gray-600 px-4 py-2 dark:text-gray-300">
                    Rp{{ number_format($subtotal + ($order->delivery->delivery_fee ?? 0), 2) }}
                </td>
            </tr>
        </tbody>
    </table>

    {{-- Informasi Pengiriman --}}
    @if ($order->delivery)
        <h3 class="text-md font-bold mt-6 mb-2 dark:text-gray-200">Informasi Pengiriman</h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="dark:text-gray-300"><strong>Alamat:</strong> {{ $order->delivery->address }}</p>
                <p class="dark:text-gray-300"><strong>Kurir:</strong> {{ $order->delivery->courier->user->name ?? 'Belum Ditugaskan' }}</p>
            </div>
            <div>
                <p class="dark:text-gray-300"><strong>Biaya Pengiriman:</strong> Rp{{ number_format($order->delivery->delivery_fee, 2) }}</p>
                <p class="dark:text-gray-300"><strong>Status Pengiriman:</strong> {{ $order->delivery->delivery_status ?? 'Belum Ditentukan' }}</p>
            </div>
        </div>
    @endif
</div>