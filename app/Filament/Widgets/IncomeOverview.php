<?php

namespace App\Filament\Widgets;

use App\Models\Sale;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class IncomeOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $app = getApp();
        $user = Auth::user();

        if(auth()->user()?->hasRole('admin')){
            $totalTransferNotPayment = Sale::whereNot('status', 'rejected')->sum('commission_brand') * (100-$app->commission_principal)/100;
            $totalTransfer = Sale::where('status', 'payment')->sum('commission_brand') * (100-$app->commission_principal)/100;
        }else if(auth()->user()?->hasRole('principal')){
            $totalTransfer = $user->commission()->where('principal_sale.is_payment', true)->sum('principal_sale.commission_fee');
            $totalTransferNotPayment = $user->commission()->where('principal_sale.is_payment', false)->sum('principal_sale.commission_fee');
        }else{
            $totalTransferNotPayment = $user->sales()->whereNot('status','rejected')->sum('commission_sales');
            $totalTransfer = $user->sales()->where('status','payment')->sum('commission_sales');
        }
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
