<?php

namespace App\Filament\Courier\Resources\CourierResource\Pages;

use App\Filament\Courier\Resources\CourierResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCourier extends EditRecord
{
    protected static string $resource = CourierResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
