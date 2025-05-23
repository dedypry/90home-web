<?php

namespace App\Filament\Pages;

use App\Models\Bank;
use App\Models\Profile as ModelsProfile;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class Profile extends Page implements HasForms
{
    use InteractsWithForms;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.profile';
    protected static bool $shouldRegisterNavigation = false;

    public $user;
    public ?array $data = [];

    public function mount()
    {
        $this->user = Auth::user();

        $profile = ModelsProfile::where('user_id', $this->user->id)->first();
        $bank= Bank::where('user_id', $this->user->id)->first();
        $this->user['profile'] = $profile;
        $this->user['bank'] = $bank;

        $this->form->fill($this->user->toArray());
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Update')
                ->color('success')
                ->icon('heroicon-o-inbox-stack')
                ->action(function () {
                    $formData = $this->form->getState();
                    $updateData = [
                        'name' => $formData['name'],
                        'email' => $formData['email'],
                    ];

                    if (!empty($formData['password'])) {
                        $updateData['password'] = Hash::make($formData['password']);
                    }

                    $this->user->update($updateData);


                    ModelsProfile::updateOrCreate(['user_id' => $this->user->id], $formData['profile']);
                    Bank::updateOrCreate(['user_id' => $this->user->id], $formData['bank']);


                    Notification::make()
                        ->title('data Berhasil di ubah')
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
                    Section::make()
                        ->schema([
                            FileUpload::make('profile.avatar')
                                ->label('')
                                ->avatar()
                                ->helperText('upload photo terbaikmu!!')
                                ->disk('public')
                                ->directory('profile')
                                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg'])
                                ->deleteUploadedFileUsing(function (string $file): void {
                                    if (Storage::disk('public')->exists($file)) {
                                        Storage::disk('public')->delete($file);
                                    }
                                })
                                ->image()
                                ->imageEditor()

                        ])
                        ->extraAttributes([
                            "class" => 'flex justify-center item-center text-center'
                        ])
                        ->grow(false),

                    Tabs::make('tab')
                        ->schema([
                            Tab::make('Profile Saya')
                                ->schema([
                                    TextInput::make('name')
                                        ->required(),
                                    TextInput::make('email')
                                        ->email()
                                        ->required(),
                                    TextInput::make('profile.phone')
                                        ->tel()
                                        ->required(),
                                    Textarea::make('profile.address')
                                        ->columnSpanFull()
                                ])
                                ->icon('heroicon-o-user-circle')
                                ->columns(2),
                            Tab::make('Keamanan')
                                ->schema([
                                    TextInput::make('password')
                                        ->password()
                                        ->revealable()
                                        ->confirmed()
                                        ->prefixIcon('heroicon-o-lock-closed'),

                                    TextInput::make('password_confirmation')
                                        ->password()
                                        ->prefixIcon('heroicon-o-lock-closed')
                                ])
                                ->icon('heroicon-o-shield-check')
                                ->columns(2),
                            Tab::make('Pembayaran')
                                ->schema([
                                    TextInput::make('bank.account_name')
                                        ->label("Nama Pemilik"),
                                    TextInput::make('bank.name')
                                        ->label("Nama Bank"),
                                    TextInput::make('bank.account_number')
                                        ->label("No. Rekening"),
                                ])
                                ->icon('heroicon-o-currency-dollar')
                                ->columns(2),
                        ])
                ])
                    ->from('md'),

            ])
            ->statePath('data');
    }
}
