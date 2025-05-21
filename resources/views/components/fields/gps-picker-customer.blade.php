<div x-data="basketMap" x-init="initializeBasketMap()" class="space-y-2">
    <div class="flex justify-end">
        <button @click="refreshLocation" type="button" class="px-3 py-1 bg-blue-600 text-white rounded text-sm">
            📍 Refresh Lokasi GPS
        </button>
    </div>

    <div id="map-basket" class="w-full" style="height: 300px;" wire:ignore></div>

    <div class="grid grid-cols-2 gap-4 mt-4">
        <!-- Input Latitude -->
        <input type="hidden" id="latitude" x-model="latitude">

        <!-- Input Longitude -->
        <input type="hidden" id="longitude" x-model="longitude">
    </div>
</div>