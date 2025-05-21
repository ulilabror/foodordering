document.addEventListener('DOMContentLoaded', () => {
    console.log('[map-init] DOM loaded');

    // Fungsi inisialisasi peta
    window.initializeMap = function (latitude, longitude, elementId = 'map-delivery') {
        console.log(`[initializeMap] Attempting to init map at #${elementId} with lat=${latitude}, lng=${longitude}`);
        const mapElement = document.getElementById(elementId);
        if (!mapElement) {
            console.warn(`[initializeMap] Element #${elementId} not found`);
            return;
        }

        // Hapus peta lama jika ada
        if (window.mapInstance) {
            console.log('[initializeMap] Removing previous map instance');
            window.mapInstance.remove();
        }

        // Buat peta baru
        window.mapInstance = L.map(elementId).setView([latitude, longitude], 13);
        console.log('[initializeMap] New map instance created');

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(window.mapInstance);

        L.marker([latitude, longitude]).addTo(window.mapInstance);
        console.log('[initializeMap] Tile layer and marker added');
    };

    // Fungsi untuk menunggu sampai map muncul di DOM
    window.waitForMapView = function (latitude, longitude, elementId = 'map-delivery') {
        console.log(`[waitForMapView] Waiting for #${elementId} to appear in DOM`);

        const interval = setInterval(() => {
            const mapElement = document.getElementById(elementId);
            if (mapElement) {
                console.log(`[waitForMapView] Element #${elementId} found, initializing map`);
                clearInterval(interval);
                initializeMap(latitude, longitude, elementId);
            } else {
                console.log(`[waitForMapView] #${elementId} not in DOM yet, retrying...`);
            }
        }, 200);
    };
});
