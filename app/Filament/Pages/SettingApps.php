<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class SettingApps extends Page implements HasForms
{
    use InteractsWithForms;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.setting-apps';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $navigationLabel = 'Apps';

    public ?array $data = [];

    public function mount()
    {
        $settings = Setting::pluck('value', 'key')->toArray() ?? [];
        foreach ($settings as $key => $value) {
            $decoded = json_decode($value, true);
            $this->data[$key] = json_last_error() === JSON_ERROR_NONE ? $decoded : $value;
        }

        $this->form->fill($this->data);
    }

    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('admin');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->hasRole('admin');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('simpan')
                ->action(function () {
                    $formData = (array)$this->form->getState();

                    foreach ($formData as $key => $value) {
                        Setting::updateOrCreate(["key" => $key], ["value" => is_array($value) ? json_encode($value) : $value]);
                    }

                    Notification::make()
                        ->title('Saved successfully')
                        ->success()
                        ->send();
                })
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Split::make([
                    Section::make([
                        FileUpload::make('logo')
                            ->label('')
                            ->disk('public')
                            ->avatar()
                            ->directory('logo'),
                    ])
                        ->grow(false)
                        ->extraAttributes([
                            "class" => "flex justify-center px-10 w-[400px]"
                        ]),
                    Tabs::make('Tabs')
                        ->tabs([
                            Tab::make('Profile')
                                ->icon('heroicon-o-building-storefront')
                                ->schema([
                                    TextInput::make('brand'),
                                    TextInput::make('company_name'),
                                    TextInput::make('email')
                                        ->email(),
                                    TextInput::make('phone')
                                        ->tel(),
                                    TextInput::make('address')
                                        ->columnSpanFull(),
                                    MarkdownEditor::make('visi')
                                        ->columnSpanFull(),
                                    MarkdownEditor::make('misi')
                                        ->columnSpanFull(),
                                ])
                                ->columns(2),
                            Tab::make('Bank')
                                ->icon('heroicon-o-banknotes')
                                ->schema([
                                    TextInput::make('bank_name')
                                        ->label('Bank'),
                                    TextInput::make('bank_branch')
                                        ->label('Cabang'),
                                    TextInput::make('account_number')
                                        ->label('No. Rekenning'),
                                    TextInput::make('npwp')
                                        ->label('NPWP'),
                                ])
                                ->columns(2),
                            Tab::make('Sosial Media')
                                ->icon('heroicon-o-user-group')
                                ->schema([
                                    Repeater::make('sosmed')
                                        ->schema([
                                            TextInput::make('title'),
                                            TextInput::make('icon'),
                                            TextInput::make('value'),
                                        ])
                                        ->columns(3)
                                ])
                        ])
                ])->from('md'),


                // ...
            ])
            ->statePath('data');
    }
}
