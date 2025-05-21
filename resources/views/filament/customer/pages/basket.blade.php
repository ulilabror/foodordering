<x-filament::page>
    <div class="space-y-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Daftar Pesanan</h1>


        @php
            $basket = session()->get('basket', []);
            $grandTotal = collect($basket)->sum(fn($item) => $item['price'] * $item['quantity']);
        @endphp

        @if (count($basket) > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Image</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantity</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                        @foreach ($basket as $menuId => $item)
                            <tr>
                                <td class="px-6 py-4">
                                    <img src="{{ Storage::url($item['image_path']) }}" alt="{{ $item['name'] }}"
                                        class="w-16 h-16 object-cover rounded-lg shadow" />
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $item['name'] }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                    {{ $item['quantity'] }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                    Rp{{ number_format($item['price'], 2) }}
                                </td>
                                <td class="px-6 py-4 text-sm font-bold text-gray-900 dark:text-gray-100">
                                    Rp{{ number_format($item['price'] * $item['quantity'], 2) }}
                                </td>
                                <td class="px-6 py-4">
                                    <x-filament::button wire:click="reduceFromBasket({{ $menuId }})" color="danger" size="sm">
                                        Kurangi
                                    </x-filament::button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6 text-end space-y-2 dark:text-gray-100">
                <p class="text-lg font-bold">Grand Total: Rp{{ number_format($grandTotal, 2) }}</p>
            </div>
        @else
            <div class="bg-yellow-100 border border-yellow-300 text-yellow-800 p-4 rounded">
                Your basket is empty.
            </div>
        @endif
    </div>
    @push('scripts')
<script>
    window.updateLatLngInputs = function (lat, lng) {
                const latInput = document.getElementById('mountedActionsData.0.latitude');
                const lngInput = document.getElementById('mountedActionsData.0.longitude');
   if (latInput) {
        latInput.value = lat;
        latInput.dispatchEvent(new Event('input', { bubbles: true }));
    }

    if (lngInput) {
        lngInput.value = lng;
        lngInput.dispatchEvent(new Event('input', { bubbles: true }));
    }
            }
    window.initializeBasketMap = function (latitude, longitude, elementId = 'map-basket') {
        console.log(`[initializeBasketMap] Attempting to init map at #${elementId} with lat=${latitude}, lng=${longitude}`);
        const mapElement = document.getElementById(elementId);
        if (!mapElement) {
            console.warn(`[initializeBasketMap] Element #${elementId} not found`);
            return;
        }

        // Hapus peta lama jika ada
        if (window.mapBasketInstance) {
            console.log('[initializeBasketMap] Removing previous map instance');
            window.mapBasketInstance.remove();
        }

        updateLatLngInputs(latitude, longitude);

        // Buat peta baru
        window.mapBasketInstance = L.map(elementId).setView([latitude, longitude], 13);
        console.log('[initializeBasketMap] New map instance created');

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(window.mapBasketInstance);

        // Tambahkan marker yang dapat di-drag
        const marker = L.marker([latitude, longitude], { draggable: true }).addTo(window.mapBasketInstance);
        marker.on('dragend', function () {
            const { lat, lng } = marker.getLatLng();
            console.log(`[initializeBasketMap] Marker dragged to lat=${lat}, lng=${lng}`);

            // Perbarui input latitude dan longitude menggunakan fungsi
            updateLatLngInputs(lat, lng);

            // Fungsi untuk memperbarui input latitude dan longitude
          

            // Pusatkan peta pada marker
            window.mapBasketInstance.setView([lat, lng], window.mapBasketInstance.getZoom());
        });

        console.log('[initializeBasketMap] Tile layer and marker added');
    };

    document.addEventListener('alpine:init', () => {
        Alpine.data('basketMap', () => ({
            latitude: @entangle('latitude'),
            longitude: @entangle('longitude'),

            initializeBasketMap() { // Nama fungsi diubah dari init() ke initializeBasketMap
                console.log('[basketMap] Initializing map...');
                this.refreshLocation();
            },

            refreshLocation() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            const lat = position.coords.latitude;
                            const lng = position.coords.longitude;

                            console.log(`[basketMap] User location lat=${lat}, lng=${lng}`);
                            this.latitude = lat;
                            this.longitude = lng;

                            // Inisialisasi peta dengan lokasi pengguna
                            window.initializeBasketMap(lat, lng);

                            
                        },
                        (error) => {
                            console.warn(`[basketMap] Geolocation error: ${error.message}`);
                        }
                    );
                } else {
                    console.warn('[basketMap] Geolocation not supported');
                }
            }
        }));
    });
</script>
@endpush

</x-filament::page>