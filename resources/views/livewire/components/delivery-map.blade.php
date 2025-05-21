<div id="map" 
     style="width: 100%; height: 400px;"
     data-latitude="{{ $latitude }}"
     data-longitude="{{ $longitude }}"
     wire:ignore></div>

@push('scripts')
<script>
    // Inisialisasi peta setelah modal dibuka
    setTimeout(() => {
        if (typeof window.initializeMap === 'function') {
            window.initializeMap({{ $latitude }}, {{ $longitude }});
        } else {
            console.error('Map initialization function not found');
        }
    }, 300);
</script>
@endpush
