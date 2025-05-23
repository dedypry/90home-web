<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;

class SalesService
{
    static function calculateData($data)
    {
        $product = Product::find($data['product_id']);
        $data['agent'] = User::find($data['user_id']);

        $data['product'] = $product ? json_encode($product->toArray()) : null;
        $data['price'] = $product->price;
        $data['commission'] = $product->commission_fee;
        $app = getApp();
        $data['ppn'] = $app->ppn;

        if ($data['product_variant_id']) {
            $variant = ProductVariant::find($data['product_variant_id']);
            $data['price'] = $variant->price;
            $data['commission'] = $variant->commission_fee;
        }

        $data['commission_subtotal'] = round(($data['price'] * $data['qty']) * ($data['commission'] / 100), 2);
        $data['ppn_total'] = round($data['commission_subtotal'] * (($app->ppn ?? 11) / 100), 2);
        $data['commission_total'] = round($data['commission_subtotal'] - $data['ppn_total'], 2);

        $commissionSales = $app->commission_sales ?? 80;
        $data['commission_sales'] = round($data['commission_total'] * ($commissionSales / 100), 2);
        $data['commission_brand'] = round($data['commission_total'] * (100 - $commissionSales) / 100, 2);


        // $data['commission_sales'] = round($data['commission_sales'],2);
        // $data['commission_brand'] = round($data['commission_brand'],2);
        // $data['commission_total'] = round($data['commission_total'],2);
        // $data['commission_subtotal'] = round($data['commission_subtotal'],2);
        // $data['ppn_total'] = round($data['ppn_total'],2);

        return $data;
    }

    static function commissionPrincipal($record): void
    {
        $commissionBrand = $record->commission_brand;
        $saleId = $record->id;



        $principals = User::whereHas('roles', function ($query) {
            $query->where('name', 'principal');
        })->get();
        $app = getApp();

        $commission = $commissionBrand * ($app->commission_principal / 100);

        $totalCommission = $commission / $principals->count();

        foreach ($principals as $principal) {
            $principal->commission()->sync([
                $saleId => [
                    'commission_fee' => $totalCommission,
                    'is_payment' => false,
                    'ppn' => $app->ppn
                ]
            ], false);
        }
    }
}
