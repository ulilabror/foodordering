<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\Action::make('refreshTotal')
                ->label('Refresh')
                ->action(fn() => $this->refreshTotal())

        ];
    }

    protected function refreshTotal(): void
    {
        $this->record->total_price = $this->record->orderItems->sum(fn($item) => $item->price * $item->quantity);
        $this->record->save();
    }
}
