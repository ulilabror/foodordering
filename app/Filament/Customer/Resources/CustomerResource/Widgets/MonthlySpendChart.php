<?php

namespace App\Filament\Customer\Resources\CustomerResource\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Carbon;

class MonthlySpendChart extends ChartWidget
{
    protected static ?string $heading = 'Pengeluaran Harian';

    protected int | string | array $columnSpan = 'full';


    protected function getData(): array
    {
        $user = auth()->user();

        // Ambil data pengeluaran bulanan berdasarkan kolom updated_at
        $data = Trend::query(
            Order::query()
                ->where('user_id', $user->id) // Filter berdasarkan pengguna
        )
        ->between(
            start: now()->startOfMonth(),
            end: now()->endOfMonth(),
        )
        ->perDay() // Gunakan kolom updated_at untuk pengelompokan harian
        ->sum('total_price');

        return [
            'datasets' => [
                [
                    'label' => 'Pengeluaran Harian',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => Carbon::parse($value->date)->format('d')), // Format hanya tanggal
        ];
    }

    protected function getType(): string
    {
        return 'line'; // Tipe chart: Line chart
    }
}
