<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Models\Product;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewProduct extends ViewRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->before(function (Product $record) {
                    $record->deleteImages();
                })
                ->visible(auth()->user()->hasRole('admin')),
            Actions\EditAction::make()
                ->visible(auth()->user()->hasRole('admin')),
        ];
    }
}
