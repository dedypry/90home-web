<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SaleResource\Pages;
use App\Models\Coordinator;
use App\Models\Developer;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Sale;
use App\Models\User;
use App\Services\InvoiceService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Model;

class SaleResource extends Resource
{
    protected static ?string $model = Sale::class;

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-bar';
    protected static ?string $label = 'Order';
    protected static ?string $navigationGroup = 'Management Product';


    public static function form(Form $form): Form
    {

        return $form
            ->schema([
                Forms\Components\Section::make()->schema([

                    Forms\Components\Select::make('developer_id')
                        ->label('Developer')
                        ->searchable()
                        ->options(Developer::all()->pluck('company_name', 'id'))
                        ->afterStateUpdated(function (callable $set) {
                            $set('product_id', null);
                            $set('product_variant_id', null);
                        })
                        ->reactive(),
                    Forms\Components\Select::make('product_id')
                        ->label('Cluster')
                        ->searchable()
                        ->options(function (callable $get) {
                            $developerId = $get('developer_id');
                            return Product::where('developer_id', $developerId)->pluck('cluster', 'id');
                        })
                        ->afterStateUpdated(fn(callable $set) => $set('product_variant_id', null))
                        ->reactive()
                        ->required(),
                    Forms\Components\Select::make('product_variant_id')
                        ->label('Variant')
                        ->searchable()
                        ->options(function (callable $get) {
                            $productId = $get('product_id');

                            if (!$productId) {
                                return [];
                            }

                            return ProductVariant::where('product_id', $productId)
                                ->get()
                                ->mapWithKeys(function ($variant) {
                                    return [
                                        $variant->id => $variant->type . ($variant->blok ? ' - ' . $variant->blok : ''),
                                    ];
                                });
                        }),
                    Forms\Components\TextInput::make('blok')
                        ->required()
                        ->placeholder('Masukan blok rumah, misal D2/10')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('payment_type')
                        ->required()
                        ->placeholder('Masukan Payment Type, misal KPR BTN FLPP')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('qty')
                        ->label('Quantity')
                        ->default(1)
                        ->required()
                        ->placeholder('Masukan Quantity'),
                    Forms\Components\Select::make('agent_coordinator')
                        ->searchable()
                        ->options(function (callable $get) {
                            $productId = $get('product_id');

                            if (!$productId) {
                                return [];
                            }
                            $product = Product::find($productId);

                            return Coordinator::where('developer_id', $product->developer_id)
                                ->get()
                                ->mapWithKeys(function ($coor) {
                                    return [
                                        $coor->id => $coor->name . ' ' . $coor->phone
                                    ];
                                });
                        }),
                    Forms\Components\TextInput::make('customer')
                        ->label('Nama Pembeli')
                        ->placeholder('Masukan nama pembeli Rumah')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Select::make('user_id')
                        ->label('Sales')
                        ->options(User::all()->pluck('name', 'id'))
                        ->searchable()
                        ->required(),

                    Forms\Components\TextInput::make('promo')
                        ->placeholder('Jika ada Promo, Bisa dimasukan disini')
                        ->maxLength(255),
                    Forms\Components\Select::make('status')
                        ->options(config('status.status_labels'))
                        ->native(false)
                        ->required(),
                    Forms\Components\DatePicker::make('booking_at')
                        ->label('Tanggal Booking')
                        ->native(false)
                        ->placeholder('masukan Tanggal')
                        ->displayFormat('D, d F Y')
                        ->locale('id')
                        ->closeOnDateSelection()
                        ->default(now())
                        ->required(),
                    Forms\Components\DatePicker::make('payment_at')
                        ->label('Tanggal Pembayaran Invoice')
                        ->helperText('Jika invoice sudah di terbitkan dan sudah di bayar oleh devloper')
                        ->native(false)
                        ->placeholder('masukan Tanggal')
                        ->displayFormat('D, d F Y')
                        ->locale('id')
                        ->closeOnDateSelection()
                        ->visible(fn(string $context) => $context === 'edit'),

                    Forms\Components\TextInput::make('booking_fee')
                        ->prefix('Rp')
                        ->numeric(),
                    Forms\Components\FileUpload::make('attachment')
                        ->disk('public')
                        ->directory('attachment')
                        ->multiple()
                        ->panelLayout('grid')
                        ->deleteUploadedFileUsing(function (string $file): void {
                            if (Storage::disk('public')->exists($file)) {
                                Storage::disk('public')->delete($file);
                            }
                        })
                        ->columnSpanFull(),
                ])->columns(2)
            ]);
    }



    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product')
                    ->html()
                    ->formatStateUsing(function ($state, $record) {
                        $product = json_decode($state);
                        $variant = $record->product_variant;
                        $variantType = $variant ? $variant->type . " -" : '';
                        return $product ? "<a href='/admin/products/$product->id'>$product->cluster - $variantType $record->blok</a>" : '-';
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('invoice.inv_number')
                    ->label('Invoice Number')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Sales')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_type')
                    ->label('Type Pemabayaran')
                    ->searchable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('coordinator')
                    ->label('Agen Koordinator')
                    ->html()
                    ->formatStateUsing(function ($state) {
                        return "<div>
                        <div class='font-semibold text-sm'>{$state->name}</div>
                        <div class='text-gray-500 text-xs'>{$state->phone}</div>
                    </div>";
                    })
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('customer')
                    ->label('Nama Pemebeli')
                    ->searchable(),

                Tables\Columns\SelectColumn::make('status')
                    ->options(config('status.status_labels'))
                    // ->color(fn($state) => config('status.status_colors')[$state] ?? config('status.status_colors.default'))
                    // ->formatStateUsing(fn($state) => config('status.status_labels')[$state] ?? ucfirst($state))
                    ->searchable(),
                Tables\Columns\TextColumn::make('booking_at')
                    ->since()
                    ->label('Tanggal Booking')
                    ->dateTooltip(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR', locale: 'id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('commission')
                    ->label('Komisi dalam %')
                    ->formatStateUsing(fn($state) => intval($state) . ' %')
                    ->sortable(),

                Tables\Columns\TextColumn::make('promo')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->before(function (Sale $record) {
                        $record->deleteAttachment();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->before(function (Collection $records) {
                            foreach ($records as $record) {
                                $record->deleteAttachment();
                            }
                        }),
                    Tables\Actions\BulkAction::make('invoice')
                        ->visible(fn() => request()->query('activeTab') != 'invoice')
                        ->label('Buat Invoice')
                        ->color('success')
                        ->icon('heroicon-o-document')
                        ->action(function (Collection $records) {

                            $pdf = Pdf::loadView('pdf.invoice', [
                                'data' => InvoiceService::generateInvoice($records)
                            ]);

                            return response()->streamDownload(function () use ($pdf) {
                                echo $pdf->stream();
                            }, 'invoice-.pdf');
                        })
                ]),
            ])
            ->checkIfRecordIsSelectableUsing(
                fn(Model $records): bool => $records->invoice_id === null
            );
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSales::route('/'),
            'create' => Pages\CreateSale::route('/create'),
            'edit' => Pages\EditSale::route('/{record}/edit'),
            'view' => Pages\ViewSales::route('/{record}'),
        ];
    }
}
