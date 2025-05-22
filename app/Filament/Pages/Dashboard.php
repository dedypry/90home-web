<?php

namespace App\Filament\Pages;

use App\Filament\Resources\SaleResource\Widgets\SalesStats;
use App\Filament\Widgets\SalesWidget;
use App\Filament\Widgets\StatsOverview;
use Filament\Pages\Page;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $view = 'filament.pages.dashboard';

    protected function getHeaderWidgets(): array
    {
        return [
            StatsOverview::class,
            SalesWidget::class,
        ];
    }
}
