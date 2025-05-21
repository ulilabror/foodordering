<?php

namespace App\Filament\Customer\Resources\CustomerResource\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class LastOrderStatus extends BaseWidget
{
    // Atur lebar kolom widget
    protected int | string | array $columnSpan = 1;

    public function getColumns(): int
    {
        return 1;
    }

    protected function getStats(): array
    {
        $user = auth()->user();

        // Ambil pesanan terakhir pengguna
        $lastOrder = Order::where('user_id', $user->id)
            ->latest('created_at')
            ->first();

        $status = $lastOrder?->status ?? 'Belum Ada Pesanan';
        $date = $lastOrder?->created_at?->format('d M Y, H:i') ?? 'Belum Ada Pesanan';
        $totalPrice = $lastOrder ? 'Rp' . number_format($lastOrder->total_price, 2) : 'Belum Ada Pesanan';

        return [
            Stat::make('Pesanan Terakhir', 'status: '.$status)
                ->description("Tanggal: $date | Total: $totalPrice")
                ->color($this->getStatusColor($lastOrder?->status)),
        ];
    }

    private function getStatusColor(?string $status): string
    {
        return match ($status) {
            'pending' => 'warning',
            'delivered' => 'success',
            'cancelled' => 'danger',
            default => 'info',
        };
    }
}
