<?php

namespace App\Filament\Resources\SaleResource\Widgets;

use App\Models\Sale;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class SalesStats extends BaseWidget
{
    protected function getStats(): array
    {
        $totalSales = Sale::sum('price');
        $totalCommission = Sale::sum(DB::raw('price * commission / 100'));
        $totalCommissionPaid = Sale::whereNotNull('payment_at')->sum(DB::raw('price * commission / 100'));
        return [
            Stat::make('Total Penjualan', 'Rp ' . number_format($totalSales, 0, ',', '.'))
                ->description('Total nilai penjualan')
                ->descriptionIcon('heroicon-m-currency-dollar'),

            Stat::make('Total Komisi', 'Rp ' . number_format($totalCommission, 0, ',', '.'))
                ->description('Total komisi dari semua penjualan')
                ->descriptionIcon('heroicon-m-banknotes'),

            Stat::make('Total Komisi Sudah Dibayar', 'Rp ' . number_format($totalCommissionPaid, 0, ',', '.'))
                ->description('Total komisi dari penjualan yang telah dibayar')
                ->descriptionIcon('heroicon-m-banknotes')
        ];
    }
}
