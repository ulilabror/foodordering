<?php

namespace App\Filament\Courier\Resources\CourierResource\Widgets;

use App\Models\Delivery;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TotalEarning extends BaseWidget
{

    protected int | string | array $columnSpan = 1;

    
    public function getColumns(): int
    {
        return 1;
    }

    protected function getStats(): array
    {
        $user = auth()->user();

        // Hitung total pendapatan dari delivery_fee dalam 7 hari terakhir
        $totalEarnings = Delivery::where('courier_id', $user->courier->id)
            ->where('delivery_status', 'delivered') // Hanya pengiriman yang selesai
            ->whereBetween('updated_at', [now()->subDays(7), now()]) // Rentang waktu 7 hari terakhir
            ->sum('delivery_fee');

        return [
            Stat::make('Total Pendapatan', 'Rp' . number_format($totalEarnings, 2))
                ->description('Dalam 7 Hari Terakhir')
                ->color('success'),
        ];
    }
}
