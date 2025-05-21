<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SaleResource\Pages;
use App\Filament\Resources\SaleResource\RelationManagers;
use App\Filament\Resources\SaleResource\Widgets\SalesStats;
use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SaleResource extends Resource
{
    protected static ?string $model = Sale::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // public static function getWidgets(): array
    // {
    //     return [
    //         SalesStats::class
    //     ];
    // }

    public static function form(Form $form): Form
    {

        return $form
            ->schema([
                Forms\Components\Section::make()->schema([

                    Forms\Components\Select::make('product_id')
                        ->label('Cluster')
                        ->searchable()
                        ->options(Product::all()->pluck('cluster', 'id'))
                        ->required(),
                    Forms\Components\TextInput::make('payment_type')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('agent_coordinator')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('customer')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Select::make('user_id')
                        ->label('Sales')
                        ->options(User::all()->pluck('name', 'id'))
                        ->searchable()
                        ->required(),

                    Forms\Components\TextInput::make('promo')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Select::make('status')
                        ->options([
                            'booking' => 'Booking',
                            'akad' => 'Akad',
                            'invoice' => 'Invoice',
                            'payment' => 'Pembayaran',
                            'resubmitted' => 'Ajukan Kembali',
                            'rejected' => 'Ditolak',
                        ])
                        ->native(false)
                        ->required(),
                    Forms\Components\TextInput::make('commission')
                        ->label('Komisi dalam %')
                        ->placeholder('contoh : 3')
                        ->suffix('%')
                        ->required()
                        ->numeric(),
                    Forms\Components\DatePicker::make('booking_at')
                        ->label('Tanggal Booking')
                        ->native(false)
                        ->placeholder('masukan Tanggal')
                        ->displayFormat('D, d F Y')
                        ->locale('id')
                        ->closeOnDateSelection()
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
                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product')
                    ->formatStateUsing(fn($state) => is_array($state) ? $state['cluster'] ?? '-' : ($state->cluster ?? '-'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Sales')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_type')
                    ->label('Type Pemabayaran')
                    ->searchable(),
                Tables\Columns\TextColumn::make('agent_coordinator')
                    ->label('Agen Koordinator')
                    ->searchable(),
                Tables\Columns\TextColumn::make('customer')
                    ->label('Nama Pemebeli')
                    ->searchable(),
                Tables\Columns\TextColumn::make('promo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR', locale: 'id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('commission')
                    ->label('Komisi dalam %')
                    ->numeric()
                    ->sortable(),
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
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
        ];
    }
}
