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
            window.addEventListener('load', () => {
                console.log('[INIT] Window load triggered');
                waitForRefreshButton();
                waitForLivewireComponent();
            });

            document.addEventListener('livewire:load', () => {
                console.log('[LIVEWIRE] Livewire loaded');
                waitForRefreshButton();
                waitForLivewireComponent();
                console.log('[LIVEWIRE] Refresh button listener added');
            });

            function waitForLivewireComponent() {
                console.log('[DEBUG] Checking for Livewire component...');
                const wireIdElement = document.querySelector('[wire\\:id]');
                if (!wireIdElement) {
                    console.warn('[DEBUG] No Livewire component found. Retrying...');
                    return setTimeout(waitForLivewireComponent, 300);
                }

                if (!window.Livewire) {
                    console.warn('[DEBUG] Livewire is not loaded. Retrying...');
                    return setTimeout(waitForLivewireComponent, 300);
                }

                const livewireComponent = Livewire.find(wireIdElement.getAttribute('wire:id'));
                if (!livewireComponent) {
                    console.warn('[DEBUG] Livewire component not found. Retrying...');
                    return setTimeout(waitForLivewireComponent, 300);
                }

                console.log('[DEBUG] Livewire component found:', livewireComponent);

                // Tunggu hingga elemen #map tersedia
                const mapContainer = document.getElementById('map');
                if (!mapContainer) {
                    console.warn('[DEBUG] #map container not found. Retrying...');
                    return setTimeout(waitForLivewireComponent, 300);
                }

                let lat = -6.2; // Default latitude
                let lng = 106.816; // Default longitude

                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            lat = position.coords.latitude;
                            lng = position.coords.longitude;
                            console.log('[DEBUG] GPS location obtained:', { lat, lng });
                            initLeafletMap(lat, lng, livewireComponent);

                        },
                        (error) => {
                            console.error('[DEBUG] Error getting GPS location:', error);
                            console.warn('[DEBUG] Using default coordinates:', { lat, lng });
                            initLeafletMap(lat, lng, livewireComponent);
                        }
                    );
                } else {
                    console.warn('[DEBUG] Geolocation not supported. Using default coordinates:', { lat, lng });
                    initLeafletMap(lat, lng, livewireComponent);
                }

                console.log('[DEBUG] Livewire component and #map container ready');
                initLeafletMap(lat, lng, livewireComponent);
            }

            function initLeafletMap(lat, lng, livewireComponent) {
                console.log('[DEBUG] Initializing map with coordinates:', { lat, lng });

                livewireComponent.set('latitude', lat);
                livewireComponent.set('longitude', lng);
                console.log('[DEBUG] Livewire coordinates set:', { lat, lng });



                setTimeout(() => {
                    const latitudeInput = document.getElementById('mountedActionsData.0.latitude');
                    const longitudeInput = document.getElementById('mountedActionsData.0.longitude');

                    if (latitudeInput && longitudeInput) {
                        latitudeInput.value = lat;
                        longitudeInput.value = lng;

                        // Trigger event agar Livewire aware
                        latitudeInput.dispatchEvent(new Event('input', { bubbles: true }));
                        longitudeInput.dispatchEvent(new Event('input', { bubbles: true }));

                        console.log('[DEBUG] Latitude and Longitude inputs updated and events dispatched:', {
                            latitude: lat,
                            longitude: lng
                        });
                    } else {
                        console.warn('[DEBUG] Latitude or Longitude input not found in the DOM.');
                    }
                }, 1000);



                const mapContainer = document.getElementById('map');
                if (!mapContainer) {
                    console.error('[DEBUG] #map container not found!');
                    return;
                }



                // Periksa apakah peta sudah diinisialisasi
                if (window.leafletMap) {
                    console.warn('[DEBUG] Map is already initialized. Destroying the existing map...');
                    window.leafletMap.remove(); // Hancurkan peta yang sudah ada
                    window.leafletMap = null; // Set ulang variabel peta
                }

                // Inisialisasi peta baru
                const map = L.map(mapContainer).setView([lat, lng], 13);
                window.leafletMap = map;

                console.log('[DEBUG] Map initialized at:', { lat, lng });

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(map);

                const marker = L.marker([lat, lng], { draggable: true }).addTo(map);
                console.log('[DEBUG] Marker added at:', { lat, lng });

                marker.on('dragend', (e) => {
                    const pos = marker.getLatLng();
                    console.log('[DEBUG] Marker dragged to:', pos);
                    livewireComponent.set('latitude', pos.lat);
                    livewireComponent.set('longitude', pos.lng);
                });

                map.on('click', (e) => {
                    console.log('[DEBUG] Map clicked at:', e.latlng);
                    marker.setLatLng(e.latlng);
                    livewireComponent.set('latitude', e.latlng.lat);
                    livewireComponent.set('longitude', e.latlng.lng);
                });

                console.log('[DEBUG] Map setup complete.');
            }

            function waitForRefreshButton() {
                console.log('[DEBUG] Checking for Refresh Location button...');
                const refreshButton = document.getElementById('refresh-location');
                if (!refreshButton) {
                    console.warn('[DEBUG] Refresh Location button not found. Retrying...');
                    return setTimeout(waitForRefreshButton, 300); // Retry after 300ms
                }

                console.log('[DEBUG] Refresh Location button found. Adding event listener...');
                refreshButton.addEventListener('click', handleRefreshLocation);
            }

            function handleRefreshLocation() {
                console.log('[DEBUG] Refresh location button clicked.');

                if (navigator.geolocation) {
                    console.log('[DEBUG] Geolocation supported. Requesting current position...');
                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            const lat = position.coords.latitude;
                            const lng = position.coords.longitude;



                            console.log('[DEBUG] GPS location refreshed:', { lat, lng });

                            // Perbarui peta dan marker
                            if (window.leafletMap) {
                                const map = window.leafletMap;
                                const marker = map._layers[Object.keys(map._layers).find(key => map._layers[key] instanceof L.Marker)];

                                map.setView([lat, lng], 15);
                                marker.setLatLng([lat, lng]);

                                // Perbarui nilai di Livewire
                                const livewireComponent = Livewire.find(document.querySelector('[wire\\:id]').getAttribute('wire:id'));
                                livewireComponent.set('latitude', lat);
                                livewireComponent.set('longitude', lng);

                                console.log('[DEBUG] Livewire updated with new coordinates:', { lat, lng });

                                // Panggil metode Livewire
                                livewireComponent.call('updateLatLng', lat, lng);
                                livewireComponent.call('setCoordinates', lat, lng);


                                console.log('[DEBUG] Livewire methods updateLatLng and setCoordinates called.');
                            } else {
                                console.error('[DEBUG] Leaflet map is not initialized.');
                            }
                        },
                        (error) => {
                            console.error('[DEBUG] Error refreshing GPS location:', error);
                            alert('Unable to retrieve your location. Please check your GPS settings.');
                        }
                    );
                } else {
                    console.warn('[DEBUG] Geolocation is not supported by this browser.');
                    alert('Geolocation is not supported by your browser.');
                }



            }



        </script>
    @endpush

</x-filament::page>