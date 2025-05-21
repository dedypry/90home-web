<?php

namespace App\Filament\Widgets;

use App\Models\Sale;
use Filament\Widgets\ChartWidget;

class SalesWidget extends ChartWidget
{
    protected static ?string $heading = 'Penjualan Perbulan';


    protected function getData(): array
    {
        $rawSales = Sale::selectRaw('EXTRACT(MONTH FROM booking_at) AS month, SUM(price) AS total')
            ->whereYear('booking_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();
            // ->pluck('total', 'month');

            // dd($sales);


        // Siapkan array bulan 1–12 dengan default 0
        $monthlySales = collect(range(1, 12))->mapWithKeys(fn($month) => [$month => 0]);

        // Masukkan hasil query ke array tersebut
        foreach ($rawSales as $row) {
            $monthlySales[$row->month] = (float) $row->total;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Penjualan',
                    'data' => $monthlySales->values(),
                    'backgroundColor' => '#4f46e5',
                ],
            ],
            'labels' => [
                'Jan',
                'Feb',
                'Mar',
                'Apr',
                'Mei',
                'Jun',
                'Jul',
                'Agu',
                'Sep',
                'Okt',
                'Nov',
                'Des',
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
