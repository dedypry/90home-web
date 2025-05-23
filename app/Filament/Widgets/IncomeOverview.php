<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class IncomeOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $user = Auth::user();
        $totalTransfer = $user->commission()->where('principal_sale.is_payment', true)->sum('principal_sale.commission_fee');
        $totalTransferNotPayment = $user->commission()->where('principal_sale.is_payment', false)->sum('principal_sale.commission_fee');
        return [
            Stat::make('Total Transfer', numFormat($totalTransfer))
                ->description('Total Pendapatan yang sudah di transfer')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Stat::make('Estimasi Penghasilan', 'Rp ' . numFormat($totalTransferNotPayment))
                ->description('Total Pendapatan yang belum di transfer')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('danger')
                ->descriptionIcon('heroicon-m-currency-dollar'),
        ];
    }
}
