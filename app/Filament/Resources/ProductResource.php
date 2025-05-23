<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Developer;
use App\Models\Product;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Split;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-plus';
    protected static ?string $navigationGroup = 'Management Product';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Split::make([
                    Forms\Components\Section::make([
                        Forms\Components\Radio::make('listing_type')
                            ->inline()
                            ->inlineLabel(false)
                            ->options([
                                'jual' => 'DI JUAL',
                                'sewa' => 'DI SEWAKAN',
                            ]),
                        Forms\Components\Radio::make('type_ads')
                            ->inline()
                            ->inlineLabel(false)
                            ->options([
                                'baru' => 'Rumah Baru',
                                'secon' => 'Rumah Secon',
                            ]),

                        Forms\Components\Radio::make('furniture')
                            ->options([
                                'furnished' => 'Furnished',
                                'non_furnished' => 'Non Furnished',
                                'semi_furnished' => 'Semi Furnished',
                            ])
                            ->inline()
                            ->inlineLabel(false)
                            ->columnSpanFull(),
                        Forms\Components\Radio::make('certificate')
                            ->label('Sertifikat')
                            ->options([
                                'shm' => 'SHM',
                                'ajb' => 'AJB',
                                'strata' => 'Strata',
                                'girik' => 'Girik',
                                'lainnya' => 'Lainnya',
                            ])
                            ->inline()
                            ->inlineLabel(false)
                            ->columnSpanFull(),
                        Grid::make()->schema([
                            Forms\Components\TextInput::make('bedroom')
                                ->numeric()
                                ->label('Kamar Tidur'),
                            Forms\Components\TextInput::make('bathroom')
                                ->numeric()
                                ->label('Kamar Mandi'),
                            Forms\Components\TextInput::make('number_of_floors')
                                ->numeric()
                                ->label('Jumlah Lantai'),

                        ])
                            ->columns(3)
                            ->columnSpanFull(),
                    ])
                        ->columns(2),
                    Forms\Components\Section::make([
                        Forms\Components\Radio::make('type_property')
                            ->options([
                                "house" => "Rumah",
                                "apartement" => "Apartemen",
                                "ruko" => "Ruko",
                                "land_commercial" => "Tanah Komersial",
                                "land_residential" => "Tanah Residensial",
                                "warehouse" => "Gudang",
                                "business_place" => "Tempat Usaha",
                                "office" => "Kantor",
                                "factory" => "Pabrik",
                                "kost" => "Kost",
                            ])
                            ->inline()
                            ->inlineLabel(false)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('surface_area')
                            ->label('Luas Tanah')
                            ->numeric()
                            ->suffix('m2'),
                        Forms\Components\TextInput::make('building_area')
                            ->label('Luas Bangunan')
                            ->numeric()
                            ->suffix('m2'),
                        Forms\Components\TagsInput::make('public_facilities')
                            ->label('Fasilitas Umum')
                            ->placeholder('fasilitas umum, seperti mushola, dll')
                            ->columnSpanFull()
                    ])
                        ->columns(2),
                ])->columnSpanFull(),
                Forms\Components\Section::make('Product')->schema([
                    Forms\Components\FileUpload::make('images')
                        ->disk('public')
                        ->directory('product')
                        ->multiple()
                        ->image()
                        ->imageEditor()
                        ->panelLayout('grid')
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg'])
                        ->deleteUploadedFileUsing(function (string $file): void {
                            if (Storage::disk('public')->exists($file)) {
                                Storage::disk('public')->delete($file);
                            }
                        })
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('listing_title')
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull(),
                    Forms\Components\Select::make('pic_id')
                        ->label('Sales PIC')
                        ->searchable()
                        ->options(User::all()->pluck('name', 'id'))
                        ->native(false)
                        ->required(),

                    Forms\Components\TextInput::make('cluster')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('type')
                        ->maxLength(255),
                    Forms\Components\Select::make('developer_id')
                        ->searchable()
                        ->options(Developer::all()->pluck('company_name', 'id')),
                    Forms\Components\TextInput::make('price')
                        ->required()
                        ->numeric()
                        ->default(0)
                        ->prefix('Rp'),
                    Forms\Components\TextInput::make('commission_fee')
                        ->required()
                        ->numeric()
                        ->default(0)
                        ->suffix('%'),
                    Forms\Components\RichEditor::make('description')
                        ->maxLength(255)
                        ->disableToolbarButtons([
                            'attachFiles',
                        ])
                        ->columnSpanFull(),
                ])->columns(3),

                Forms\Components\Repeater::make('product_variant')
                    ->label('Variant Produk')
                    ->relationship()
                    ->schema([
                        Forms\Components\FileUpload::make('images')
                            ->disk('public')
                            ->directory('product')
                            ->multiple()
                            ->image()
                            ->imageEditor()
                            ->panelLayout('grid')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg'])
                            ->deleteUploadedFileUsing(function (string $file): void {
                                if (Storage::disk('public')->exists($file)) {
                                    Storage::disk('public')->delete($file);
                                }
                            })
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('type')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('blok')
                            ->maxLength(255),
                        Grid::make()
                            ->schema([
                                Forms\Components\TextInput::make('price')
                                    ->required()
                                    ->numeric()
                                    ->default(0)
                                    ->prefix('Rp'),
                                Forms\Components\TextInput::make('commission_fee')
                                    ->required()
                                    ->numeric()
                                    ->default(0)
                                    ->suffix('%'),
                                Forms\Components\TextInput::make('ppn')
                                    ->numeric()
                                    ->default(0)
                                    ->suffix('%'),
                            ])
                            ->columns(3)
                            ->columnSpanFull(),
                        Forms\Components\RichEditor::make('description')
                            ->maxLength(255)
                            ->disableToolbarButtons([
                                'attachFiles',
                            ])
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull()

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('images')
                    ->limit(1)
                    ->square(),
                Tables\Columns\TextColumn::make('cluster')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('commission_fee')
                    ->formatStateUsing(fn($state) => intval($state) . " %")
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
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->before(function (Product $record) {
                        $record->deleteImages();
                    }),
                Tables\Actions\ViewAction::make()

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->before(function (Collection $records) {
                            foreach ($records as $record) {
                                $record->deleteImages();
                            }
                        }),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
