<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeveloperResource\Pages;
use App\Filament\Resources\DeveloperResource\RelationManagers;
use App\Models\Developer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;

class DeveloperResource extends Resource
{
    protected static ?string $model = Developer::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Management Product';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Vendor')->schema([
                    Forms\Components\FileUpload::make('logo')
                        ->label('Logo Developer')
                        ->helperText('Logo wajib dengan extensi jpg, jpeg, png')
                        ->disk('public')
                        ->directory('vendor_logo')
                        ->image()
                        ->imageEditor()
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg'])
                        ->deleteUploadedFileUsing(function (string $file): void {
                            if (Storage::disk('public')->exists($file)) {
                                Storage::disk('public')->delete($file);
                            }
                        })
                        ->required()
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('company_name')
                        ->label('Nama Developer')
                        ->placeholder('Masukan nama developer')
                        ->maxLength(255)
                        ->required(),
                    Forms\Components\TextInput::make('phone')
                        ->label('No. Telp')
                        ->placeholder('Masukan No. Telp 0822...')
                        ->tel()
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('email')
                        ->placeholder('Masukan Email')
                        ->email()
                        ->required()
                        ->maxLength(255),
                    Forms\Components\RichEditor::make('address')
                        ->label('Alamat Vendor')
                        ->disableToolbarButtons([
                            'attachFiles',
                        ])
                        ->placeholder('Masukan Alamat')
                        ->helperText('Alamat ini di gunakan untuk invoice')
                        ->columnSpanFull(),
                ])->columns(2),

                Forms\Components\Repeater::make('coordinators')
                    ->label('Sales Koordinator')
                    ->relationship()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama')
                            ->placeholder('Masukan Nama')
                            ->required(),
                        Forms\Components\TextInput::make('email')
                            ->placeholder('Masukan Email')
                            ->email(),
                        Forms\Components\TextInput::make('phone')
                            ->label('No. Telp')
                            ->placeholder('Masukan No. Telp 0822...')
                            ->tel()
                            ->required(),
                    ])
                    ->columns(3)
                    ->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('logo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('company_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
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
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListDevelopers::route('/'),
            'create' => Pages\CreateDeveloper::route('/create'),
            'edit' => Pages\EditDeveloper::route('/{record}/edit'),
        ];
    }
}
