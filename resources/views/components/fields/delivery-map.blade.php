<div id="map-delivery"
     style="width: 100%; height: 400px;"
     data-latitude="{{ $latitude }}"
     data-longitude="{{ $longitude }}"
     wire:ignore
     x-data="{ 
         latitude: {{ $latitude }}, 
         longitude: {{ $longitude }} 
     }"
     x-init="waitForMapView(latitude, longitude, 'map-delivery')"
>
</div>
