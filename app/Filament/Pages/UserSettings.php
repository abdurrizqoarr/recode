<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static string $view = 'filament.pages.user-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $user = Auth::user();

        $this->form->fill([
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            \Filament\Forms\Components\Section::make('User Setting')
                ->schema([
                    TextInput::make('name')
                        ->label('Nama')
                        ->minLength(2)
                        ->maxLength(240)
                        ->unique(ignoreRecord: true)
                        ->required(),

                    TextInput::make('email')
                        ->label('email')
                        ->email()
                        ->required()
                        ->unique(ignoreRecord: true),

                    TextInput::make('password')
                        ->label('Password (Kosongkan jika tidak ingin mengubah)')
                        ->password()
                        ->minLength(6)
                        ->maxLength(240)
                        ->nullable(),
                ])
        ])->statePath('data');
    }

    public function submit(): void
    {
        try {
            $formData = $this->form->getState();

            $user = Auth::user();
            $user->name = $formData['name'];
            $user->email = $formData['email'];

            if (!empty($formData['password'])) {
                $user->password = Hash::make($formData['password']);
            }

            $user->save();

            // Clear the form
            $this->form->fill([
                'name' => $user->name,
                'email' => $user->email,
                'password' => ''
            ]);

            Notification::make()
                ->title('Ganti Akun Berhasil')
                ->duration(3000)
                ->success()
                ->send();
        } catch (\Exception $e) {
            Log::error('ResetAkun submit error: ' . $e->getMessage(), [
                'exception' => $e,
            ]);

            Notification::make()
                ->title('Terjadi kesalahan saat mengganti akun')
                ->duration(3000)
                ->danger()
                ->body('Silakan coba lagi atau hubungi admin.')
                ->send();
        }
    }
}
