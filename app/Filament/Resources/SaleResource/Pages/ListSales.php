<?php

namespace App\Filament\Resources\SaleResource\Pages;

use App\Filament\Resources\SaleResource;
use App\Filament\Resources\SaleResource\Widgets\SalesStats;
use App\Models\Sale;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Pages\ListRecords;

class ListSales extends ListRecords
{
    protected static string $resource = SaleResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            SalesStats::class
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {

        return [
            'non_invoice' => Tab::make('Belum Dilakukan Invoicing')
                ->icon('heroicon-m-receipt-refund')
                ->badge(Sale::query()->whereNull('invoice_id')->count())
                ->badgeColor('danger')
                ->modifyQueryUsing(fn(Builder $query) => $query->whereNull('invoice_id')),
            'invoice' => Tab::make('Sudah di lakukan Invoice')
                ->icon('heroicon-m-receipt-percent')
                ->badge(Sale::query()->whereNotNull('invoice_id')->count())
                ->badgeColor('success')
                ->modifyQueryUsing(fn(Builder $query) => $query->whereNotNull('invoice_id')),
        ];
    }



    public function getDefaultActiveTab(): string | int | null
    {
        return 'non_invoice';
    }
}
