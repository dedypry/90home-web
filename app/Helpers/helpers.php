<?php

use App\Models\Invoice;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

function dateFormat($date=null, $format = 'd M Y', $locale = 'id')
{
    if (!$date) return Carbon::now()->locale($locale)->translatedFormat($format);

    return Carbon::parse($date)->locale($locale)->translatedFormat($format);
}

function numFormat($data)
{
    return number_format($data, 0, ',', '.');
}


function penyebut($nilai)
{
    $nilai = abs($nilai);
    $huruf = [
        "",
        "satu",
        "dua",
        "tiga",
        "empat",
        "lima",
        "enam",
        "tujuh",
        "delapan",
        "sembilan",
        "sepuluh",
        "sebelas"
    ];
    $temp = "";
    if ($nilai < 12) {
        $temp = " " . $huruf[$nilai];
    } else if ($nilai < 20) {
        $temp = penyebut($nilai - 10) . " belas";
    } else if ($nilai < 100) {
        $temp = penyebut($nilai / 10) . " puluh" . penyebut($nilai % 10);
    } else if ($nilai < 200) {
        $temp = " seratus" . penyebut($nilai - 100);
    } else if ($nilai < 1000) {
        $temp = penyebut($nilai / 100) . " ratus" . penyebut($nilai % 100);
    } else if ($nilai < 2000) {
        $temp = " seribu" . penyebut($nilai - 1000);
    } else if ($nilai < 1000000) {
        $temp = penyebut($nilai / 1000) . " ribu" . penyebut($nilai % 1000);
    } else if ($nilai < 1000000000) {
        $temp = penyebut($nilai / 1000000) . " juta" . penyebut($nilai % 1000000);
    } else if ($nilai < 1000000000000) {
        $temp = penyebut($nilai / 1000000000) . " milyar" . penyebut($nilai % 1000000000);
    } else if ($nilai < 1000000000000000) {
        $temp = penyebut($nilai / 1000000000000) . " triliun" . penyebut($nilai % 1000000000000);
    }
    return $temp;
}

function terbilang($nilai)
{
    if ($nilai < 0) {
        return ucwords("minus" . trim(penyebut($nilai)) . " Rupiah");
    } else {
        return ucwords(trim(penyebut($nilai)) . " Rupiah");
    }
}

function getNextInvoiceNumber()
{
    return DB::transaction(function () {
        $invNo = generateInvNo();
        return Invoice::create(["inv_number" => $invNo]);
    });
}

function generateInvNo(){
    $inv = Invoice::max('id') ?? 0;
    $number = str_pad($inv + 1, 4, '0', STR_PAD_LEFT);
    $invNo = 'INV/' . now()->format('y') . "/" . $number;

    return $invNo;
}


function getApp(){
    return (object)Setting::pluck('value', 'key')->toArray();
}
