<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $invoiceNumber ?? '0001' }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }

        .invoice-box {
            width: auto;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #eee;
        }

        .header {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            width: 120px;
        }

        .company-info {
            text-align: right;
        }

        .invoice-details table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .invoice-details th,
        .invoice-details td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .invoice-details th {
            background-color: #f5f5f5;
        }

        .totals {
            margin-top: 10px;
            width: 100%;
            background-color: #f5f5f5;
        }

        .totals td {
            padding: 5px 8px;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-style: italic;
        }

        .terbilang {
            margin-top: 5px;
            background-color: #f5f5f5;
            font-size: 20px;
            font-style: italic;
            font-weight: bold;
            text-align: center;
            border-radius: 5px;
            padding: 10px;
        }

        .address p {
            padding: 0px;
            margin: 0px;
            font-size: 10px;
        }

        .pembayaran {
            width: '100%'
        }
    </style>
</head>

<body>
    @foreach ($data as $items)
    @php
    $developer = $items['developer'];
    $invoice = $items['invoice'];
    @endphp
    <div class="invoice-box">
        <div class="header">
            <table style="width: 100%">
                <tr>
                    <td>
                        <div class="logo">
                            <img src="{{ public_path('logo.PNG') }}" alt="Company Logo" style="width: 100%;">
                        </div>
                    </td>
                    <td style="width: auto"></td>
                    <td>
                        <div class="company-info">
                            <strong>PT BRAZAM GLOBAL JAYA</strong><br>
                            Jl. Taman Adiyasa Blok J15 No. 2<br>
                            Tangerang, Indonesia<br>
                            Email: agent@90home.id
                        </div>
                    </td>
                </tr>
            </table>


        </div>

        <hr style="margin: 20px 0;">

        <table style="width: 100%; margin-bottom: 10px;">
            <tr>
                <td>
                    <strong>Kepada Yth</strong><br>
                    <strong style="font-size: 20px">{{ $developer->company }}</strong><br>
                    <span class="address">{!!$developer->address!!} <p>@if ($developer->email) {{ $developer->email }}
                            @endif @if ($developer->phone)- {{$developer->phone}} @endif</p> </span><br>


                </td>
                <td style="text-align: right;">
                    <span style="font-size: 16px; font-weight: bold">Invoice #: {{ $invoice->inv_number }}</span> <br>
                    <strong>Tanggal: {{ now()->format('d-m-Y') }}</strong><br>
                    {{-- <strong>Status:</strong> {{ ucfirst($status ?? 'dibayar') }} --}}
                </td>
            </tr>
        </table>
        @php
        $totalCommission = 0;
        $totalSales = 0
        @endphp

        <div class="invoice-details">
            <table>
                <thead>
                    <tr>
                        <th rowspan="2">Jumlah</th>
                        <th rowspan="2">Deskripsi</th>
                        <th rowspan="2">Harga</th>
                        <th colspan="2">Komisi</th>
                    </tr>
                    <tr>
                        <th>%</th>
                        <th>Fee</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items['item'] as $index => $item)
                    @php
                    $product = json_decode($item->product);
                    $price = $item->price * $item->qty;
                    $totalCommission += $price * $item->commission/100;
                    $totalSales += $price;

                    @endphp
                    <tr>
                        <td>{{$item->qty}} Kav</td>
                        <td>
                            <p style="padding: 0px;margin:0px">Pembayaran Fee {{$item->qty}} kav, Cluster {{
                                $product->cluster }}</p>
                            <p style="padding: 0px;margin:0px">type :
                                @if ($item->product_variant)
                                {{$item->product_variant->type}}
                                @else
                                {{$product->type}}
                                @endif
                            </p>
                            <p style="padding: 0px;margin:0px">{{$item->blok}}</p>
                            <div>
                                <p style="padding: 0px; margin:0px">Tanggal Booking : {{dateFormat($item->booking_at)}}
                                </p>
                                <p style="padding: 0px; margin:0px">Tanggal Akad : {{dateFormat($item->akad_at)}}</p>
                            </div>
                        </td>
                        <td style="text-align: end">Rp {{ numFormat($price) }}</td>
                        <td> {{ intval($item->commission) }} %</td>
                        <td style="text-align: end">Rp {{ numFormat($price * $item->commission/100) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <table class="totals">
            {{-- <tr>
                <td style="text-align: right;"><strong>Total Penjualan :</strong></td>
                <td style="width: 150px;">Rp {{numFormat($totalSales)}}</td>
            </tr> --}}
            <tr style="font-size: 15px">
                <td style="text-align: right;"><strong>Total Komisi:</strong></td>
                <td><strong>Rp {{numFormat($totalCommission)}}</strong></td>
            </tr>
        </table>

        <p style="font-weight: bold; text-align: start">Terbilang :</p>
        <div class="terbilang">
            {{terbilang($totalCommission)}}
        </div>
        <table class="pembayaran">
            <tr>
                <td colspan="3" style="font-weight: bold; font-style: italic">Pembayaran mohon di transfer ke rekening
                    tersebut : </td>
                <td style="width: 200px"></td>
                <td></td>
            </tr>
            <tr>
                <td>Bank </td>
                <td style="width: 5px">:</td>
                <td colspan="2">MANDIRI</td>
                <td style="text-align: center; width: 200px">Maja, {{dateFormat()}}</td>
            </tr>
            <tr>
                <td>Cabang </td>
                <td>:</td>
                <td colspan="2">Cabang</td>
            </tr>
            <tr>
                <td>No. A/ C </td>
                <td>:</td>
                <td colspan="2">176-00-0528371-6</td>
            </tr>
            <tr>
                <td>Atas Nama </td>
                <td>:</td>
                <td colspan="2">PT. BRAZAM GLOBAL </td>
            </tr>
            <tr>
                <td>NPWP </td>
                <td>:</td>
                <td>40.855.903.7-451.000</td>
                <td style="width: auto"></td>
                <td style="text-align: center">( {{auth()->user()->name}} )</td>
            </tr>

        </table>
    </div>



    <div style="page-break-after: always;"></div>
    @endforeach

</body>

</html>
