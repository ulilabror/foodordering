<?php
namespace App\Livewire\Components;

use Livewire\Component;

class DeliveryMap extends Component
{
    public $latitude;
    public $longitude;

    public function mount($latitude, $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function render()
    {
        return view('livewire.components.delivery-map');
    }
}
