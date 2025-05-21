<?php

namespace App\Filament\Resources\ProductResource\Widgets;

use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProductOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalProduct = Product::count();
        return [
            Stat::make('Total Pproduct', number_format($totalProduct, 0, ',', '.'))
            ->description('Total Product')
        ];
    }
}
