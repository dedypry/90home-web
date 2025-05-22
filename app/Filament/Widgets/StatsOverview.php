<?php

namespace App\Filament\Widgets;

use App\Models\Sale;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalAgents = User::role('agent')->count();
        $totalSales = Sale::whereNot('status', 'rejected')->sum('price');
        $totalCommission = Sale::whereNot('status', 'rejected')->sum(DB::raw('price * commission / 100'));
        $totalCommissionPaid = Sale::whereNot('status', 'rejected')->whereNotNull('payment_at')->sum(DB::raw('price * commission / 100'));

        return [
            Stat::make('Total Agent', $totalAgents)
                ->description('Jumlah user dengan role agent')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Stat::make('Total Penjualan', 'Rp ' . number_format($totalSales, 0, ',', '.'))
                ->description('Total nilai penjualan')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('danger')
                ->descriptionIcon('heroicon-m-currency-dollar'),

            Stat::make('Total Komisi', 'Rp ' . number_format($totalCommission, 0, ',', '.'))
                ->description('Total komisi dari semua penjualan')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('info')
                ->descriptionIcon('heroicon-m-banknotes'),

            Stat::make('Total Komisi Sudah Dibayar', 'Rp ' . number_format($totalCommissionPaid, 0, ',', '.'))
                ->description('Total komisi dari penjualan yang telah dibayar')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('primary')
                ->descriptionIcon('heroicon-m-banknotes')
        ];
    }
}
