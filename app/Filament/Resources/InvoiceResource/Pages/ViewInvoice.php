<?php

namespace App\Filament\Resources\InvoiceResource\Pages;

use App\Filament\Resources\InvoiceResource;
use App\Models\Sale;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\Summarizers\Summarizer;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\Database\Query\Builder;

class ViewInvoice extends ViewRecord implements HasTable
{
    use InteractsWithTable;

    protected static string $resource = InvoiceResource::class;
    protected static string $view = 'filament.pages.invoice';

    protected function getHeaderActions(): array
    {
        return [
            Action::make('download_invoice')
                ->icon('heroicon-m-arrow-down-on-square-stack')
                ->color('success')
                ->action(function ($record) {
                    $data = [];
                    $data[] = [
                        "developer" => $record->developer,
                        "invoice" => $record,
                        "item" => $record->sales
                    ];

                    $pdf = Pdf::loadView('pdf.invoice', [
                        'data' => $data
                    ]);

                    return response()->streamDownload(function () use ($pdf) {
                        echo $pdf->output();
                    }, 'invoice.pdf', [
                        'Content-Type' => 'application/pdf',
                    ]);
                })
        ];
    }

    public function table(Table $table): Table
    {

        return $table
            ->query(Sale::query()->where('invoice_id', $this->record->id))
            ->columns([
                TextColumn::make('jumlah')
                    ->state(function (Sale $record) {
                        return $record->qty . ' Kav';
                    }),
                TextColumn::make('product')
                    ->label('Deskripsi')
                    ->html()
                    ->formatStateUsing(function ($state, $record) {
                        $product = json_decode($state);
                        $variant = $record->product_variant;
                        $variantType = $variant ? $variant->type : $product->type;
                        $bookingAt = dateFormat($record->booking_at);
                        $akadAt = dateFormat($record->akad_at);
                        return "
                         <p style='padding: 0px;margin:0px'>Pembayaran Fee $record->qty kav, Cluster $product->cluster </p>
                            <p style='padding: 0px;margin:0px'>type :$variantType</p>
                            <p style='padding: 0px;margin:0px'>$record->blok</p>
                            <div>
                                <p style='padding: 0px; margin:0px'>Tanggal Booking : $bookingAt
                                </p>
                                <p style='padding: 0px; margin:0px'>Tanggal Akad : $akadAt</p>
                            </div>";
                    }),
                TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR'),
                TextColumn::make('commission')
                    ->formatStateUsing(fn($state) => intval($state) . ' %'),
                TextColumn::make('total_komisi')
                    ->state(function (Sale $record) {
                        return 'IDR ' . numFormat(($record->price * $record->qty) * $record->commission / 100);
                    })
                    ->alignEnd()
                    ->summarize(
                        Summarizer::make()
                            ->label('Total')
                            ->using(function (Builder $query) {
                                return $query->get()->sum(function ($record) {
                                    return ($record->price * $record->qty) * $record->commission / 100;
                                });
                            })
                            ->formatStateUsing(fn($state) => 'IDR ' . numFormat($state))
                    )
                // ->formatStateUsing(fn($state,$record)=> 'IDR '.numFormat(($record->price * $record->qty) * $record->commission/100))
            ])
            ->actions([
                DeleteAction::make()
            ])
            ->paginated(false);
    }
}
