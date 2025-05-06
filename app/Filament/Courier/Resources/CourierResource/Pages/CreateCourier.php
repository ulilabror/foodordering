<?php

namespace App\Filament\Courier\Resources\CourierResource\Pages;

use App\Filament\Courier\Resources\CourierResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCourier extends CreateRecord
{
    protected static string $resource = CourierResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Assign the logged-in user as the courier's user_id
        $data['user_id'] = auth()->id();

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        // Redirect to the DeliveryResource index page after creating a courier
        return \App\Filament\Courier\Resources\DeliveryResource::getUrl('index');
    }

    
}
