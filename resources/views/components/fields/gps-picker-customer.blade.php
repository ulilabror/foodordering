<div>
    <div class="flex justify-end mb-2">
        <button type="button" id="refresh-location" class="px-3 py-1 bg-blue-600 text-white rounded text-sm">
            📍 Refresh Lokasi GPS
        </button>
    </div>
    <div id="map" style="height: 300px;" wire:ignore></div> 
    <!-- Prevent Livewire from managing the map DOM -->
     <script>
        window.addEventListener('Livewire:Load',function(){
            alert('Livewire Loaded');
        })
     </script>
</div>
