<?php

namespace App\Filament\Courier\Resources\CourierResource\Widgets;

use App\Models\Delivery;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class LastDeliveryStatus extends BaseWidget
{

     protected int | string | array $columnSpan = 1;

    
    public function getColumns(): int
    {
        return 1;
    }
    protected function getStats(): array
    {
        $user = auth()->user();

        // Ambil pengiriman terakhir yang ditugaskan ke kurir yang sedang login
        $lastDelivery = Delivery::where('courier_id', $user->courier->id)
            ->latest('updated_at')
            ->first();

            $status = $lastDelivery?->delivery_status ?? 'Belum Ada Pengiriman';
            $date = $lastDelivery?->updated_at?->format('d M Y, H:i') ?? 'N/A';
            $destination = $lastDelivery?->address ?? 'Tidak Ada Tujuan';
            // dd($user->courier->id);

        return [
            Stat::make('Status Pengiriman Terakhir', 'status: '.$status)
                ->description("Tanggal: $date | Tujuan: $destination")
                ->color($this->getStatusColor($status)),
        ];
    }

    private function getStatusColor(?string $status): string
    {
        return match ($status) {
            'pending' => 'warning',
            'on_delivery' => 'primary',
            'completed' => 'success',
            'cancelled' => 'danger',
            default => 'secondary',
        };
    }
}
