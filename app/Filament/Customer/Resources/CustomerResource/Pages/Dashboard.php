<?php

namespace App\Filament\Customer\Resources\CustomerResource\Pages;

use App\Filament\Customer\Widgets\OrderSummaryWidget;
use App\Filament\Customer\Resources\CustomerResource\Widgets\MonthlySpendChart;
use App\Filament\Customer\Resources\CustomerResource\Widgets\LastOrderStatus;

class Dashboard extends \Filament\Pages\Dashboard
{
    protected static array $widgets = [
        OrderSummaryWidget::class, // Widget yang Anda buat sebelumnya
        MonthlySpendChart::class, // Widget tambahan
        LastOrderStatus::class,   // Widget tambahan
    ];

    public function getColumns(): int
    {
        return 2; // Atur jumlah kolom untuk tata letak widget
    }
}