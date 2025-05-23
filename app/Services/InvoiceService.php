<?php

namespace App\Services;

use App\Models\Developer;

class InvoiceService
{
    static function generateInvoice($records) {
        $app = getApp();

        $data = [];

        foreach ($records->groupBy('developer_id') as $item) {
            $developer = null;
            if(!$item->first()->developer_id){
                $developer = Developer::updateOrCreate([
                    "company_name" => $app->company_name,
                    "phone" => $app->phone,
                    "email" => $app->email,
                    "address" => $app->address,
                    "logo" => $app->logo,
                    "company" => $app->brand,
                ]);
            }else{
                $developer = Developer::find($item->first()->developer_id);
            }
            $invoice = getNextInvoiceNumber($developer->id);

            $commissionFee = 0;
            $commissionBrand = 0;

            foreach ($item as $record) {
                $commissionFee += $record->commission_subtotal;
                $commissionBrand += $record->commission_brand;
                $record->update([
                    'invoice_id' => $invoice->id,
                    'developer_id' => $developer->id
                ]);
            }



            $invoice->update([
                "commission_fee" =>  $commissionFee,
                "commission_company" => $commissionBrand
            ]);

            $data[] = [
                "developer" => $developer,
                "invoice" => $invoice,
                "item" => $item
            ];

        }

        return $data;

    }
}
