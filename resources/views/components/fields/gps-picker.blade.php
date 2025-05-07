<div>
    <div class="flex justify-end mb-2">
        <button type="button" id="refresh-location" class="px-3 py-1 bg-blue-600 text-white rounded text-sm">
            📍 Refresh Lokasi GPS
        </button>
    </div>
    <div id="map" style="height: 300px;" wire:ignore></div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let map, marker;

            function initializeMap() {
                const defaultLat = -6.200000; // Default latitude (Jakarta)
                const defaultLng = 106.816666; // Default longitude (Jakarta)

                // Initialize map if not already initialized
                if (!map) {
                    map = L.map('map').setView([defaultLat, defaultLng], 13);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; OpenStreetMap contributors'
                    }).addTo(map);

                    marker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(map);

                    // Handle marker drag event
                    marker.on('dragend', function (e) {
                        const position = marker.getLatLng();
                        updatePosition(position.lat, position.lng);
                    });

                    // Handle map click event
                    map.on('click', function (e) {
                        const lat = e.latlng.lat;
                        const lng = e.latlng.lng;
                        marker.setLatLng([lat, lng]);
                        updatePosition(lat, lng);
                    });
                }

                // Use Geolocation API to set initial position
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function (position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        map.setView([lat, lng], 15);
                        marker.setLatLng([lat, lng]);
                        updatePosition(lat, lng);
                    });
                }
            }

            function updatePosition(lat, lng) {
                @this.set('data.gps_latitude', lat);
                @this.set('data.gps_longitude', lng);
            }

            // Add event listener to refresh location button
            document.getElementById('refresh-location').addEventListener('click', function () {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function (position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        map.setView([lat, lng], 15);
                        marker.setLatLng([lat, lng]);
                        updatePosition(lat, lng);
                    }, function () {
                        alert('Unable to retrieve your location. Please allow location access.');
                    });
                } else {
                    alert('Geolocation is not supported by this browser.');
                }
            });

            // Wait for Livewire to be ready before initializing the map
            Livewire.hook('message.processed', () => {
                initializeMap();
            });

            // Initialize the map on page load
            initializeMap();
        });
    </script>
</div>
