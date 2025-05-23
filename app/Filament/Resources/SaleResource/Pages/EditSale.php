<?php

namespace App\Filament\Resources\SaleResource\Pages;

use App\Filament\Resources\SaleResource;
use App\Models\Sale;
use App\Services\SalesService;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSale extends EditRecord
{
    protected static string $resource = SaleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->before(function (Sale $record) {
                    $record->deleteAttachment();
                }),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $result = SalesService::calculateData($data);

        //    dd($result);
        return $result;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterSave(): void
    {
        SalesService::commissionPrincipal($this->record);
    }

}
