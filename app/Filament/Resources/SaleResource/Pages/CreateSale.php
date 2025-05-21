<?php

namespace App\Filament\Resources\SaleResource\Pages;

use App\Filament\Resources\SaleResource;
use App\Models\Product;
use App\Models\ProductVariant;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSale extends CreateRecord
{
    protected static string $resource = SaleResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $product = Product::find($data['product_id']);
        $data['product'] = $product ? json_encode($product->toArray()) : null;

        $data['price'] = $product->price;
        $data['commission'] = $product->commission_fee;

        if($data['product_variant_id']){
            $variant = ProductVariant::find($data['product_variant_id']);
            if($variant->price > 0){
                $data['price'] = $variant->price;
            }
            if($variant->commission_fee > 0){
                $data['commission'] = $variant->commission_fee;
            }
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
