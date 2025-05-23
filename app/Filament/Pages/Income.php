<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\IncomeOverview;
use Filament\Pages\Page;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class Income extends Page implements HasTable
{

    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.income';
    protected static bool $shouldRegisterNavigation = false;

    protected function getHeaderWidgets(): array
    {
        return [
            IncomeOverview::class
        ];
    }

    public function table(Table $table): Table
    {
        
        return $table
            ->query(auth()->user()->commission()->getQuery())
            ->columns([
                ViewColumn::make('product')
                    ->label('Produk')
                    ->view('components.tables.product'),
                TextColumn::make('invoice.inv_number')
                    ->label('No. Invoice')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('agent')
                    ->label('Nama Sales')
                    ->numeric()
                    ->searchable()
                    ->formatStateUsing(function($state){
                        $user = json_decode($state);
                        return $user->name;
                    })
                    ->sortable(),
                TextColumn::make('customer')
                    ->searchable()
                    ->label('Pembeli'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn($state) => config('status.status_colors')[$state] ?? config('status.status_colors.default'))
                    ->formatStateUsing(fn($state) => config('status.status_labels')[$state] ?? ucfirst($state))
                    ->searchable(),
                TextColumn::make('commission_fee')
                    ->label('Komisi')
                    ->money('IDR', locale: 'id'),
                IconColumn::make('is_payment')
                    ->label('Pembayaran')
                    ->boolean()
            ])
            ->filters([
                // ...
            ])
            ->actions([
                // ...
            ])
            ->bulkActions([
                // ...
            ]);
    }
}
