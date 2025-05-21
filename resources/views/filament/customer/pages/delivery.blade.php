<div>
    <!-- Modal -->
    <div x-data="{ open: false }" x-show="open" @open-map-modal.window="open = true" @close-map-modal.window="open = false" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg w-3/4 h-3/4">
            <div class="flex justify-between items-center p-4 border-b">
                <h2 class="text-lg font-bold">Delivery Location</h2>
                <button @click="open = false" class="text-gray-500 hover:text-gray-700">&times;</button>
            </div>
            <div id="map" class="w-full h-full"></div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let map, marker;

            window.addEventListener('open-map-modal', function () {
                const latitude = @json($mapLatitude ?? -6.200000); // Default latitude
                const longitude = @json($mapLongitude ?? 106.816666); // Default longitude

                if (!map) {
                    map = L.map('map').setView([latitude, longitude], 13);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; OpenStreetMap contributors'
                    }).addTo(map);

                    marker = L.marker([latitude, longitude]).addTo(map);
                } else {
                    map.setView([latitude, longitude], 13);
                    marker.setLatLng([latitude, longitude]);
                }
            });
        });
    </script>
@endpush