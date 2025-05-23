<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Colors\Color;
use Illuminate\Support\Facades\Auth;
use Spatie\Browsershot\Browsershot;

class ViewProduct extends ViewRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('Cetak Baner')
                ->icon('heroicon-o-printer')
                ->color(Color::Cyan)
                ->action(function (Product $record) {
                    $user = Auth::user();

                    if (!$user->profile && !$user->profile->avatar) {
                        Notification::make()
                            ->title("Isi Profile Terlebih Dahulu")
                            ->danger()
                            ->send();
                    }

                    $html = view('pdf.banner')->render();
                    Browsershot::html($html)
                        ->windowSize(3258, 1810)
                        ->setOption('args', ['--no-sandbox']) // penting di VPS/shared hosting
                        ->save(storage_path('app/banner.png'));

                    return response()->download(storage_path('app/banner.png'));
                }),
            Actions\DeleteAction::make()
                ->label('Hapus Product')
                ->icon('heroicon-o-trash')
                ->before(function (Product $record) {
                    $record->deleteImages();
                }),
            Actions\EditAction::make()
                ->icon('heroicon-o-pencil-square')
                ->label('Edit Product'),
        ];
    }
}
