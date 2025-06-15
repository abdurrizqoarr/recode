<?php

namespace App\Filament\Pegawai\Pages;

use App\Models\PegawaiAum;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class UserSetting extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static string $view = 'filament.pegawai.pages.user-setting';

    public ?array $data = [];

    public ?PegawaiAum $record = null;

    public function mount(): void
    {
        // Get the authenticated user model and assign it to the record property.
        $this->record = Auth::guard('pegawais')->user();

        // Fill the form with the user's data.
        $this->form->fill($this->record->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('User Setting')
                    ->description('Kelola informasi akun dan kata sandi Anda.')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama')
                            ->minLength(2)
                            ->maxLength(240)
                            ->required(),

                        TextInput::make('username')
                            ->label('Username')
                            ->minLength(2)
                            ->maxLength(240)
                            ->required()
                            // Because the form is model-bound, this rule correctly ignores
                            // the current user's username during validation.
                            ->unique(ignoreRecord: true),

                        TextInput::make('status')
                            ->label('Status')
                            ->disabled(),

                        TextInput::make('password')
                            ->label('Password Baru')
                            ->password()
                            ->minLength(6)
                            ->autocomplete('new-password')
                            ->helperText('Kosongkan jika tidak ingin mengubah password.')
                            // Only include the password in the state if it's filled.
                            ->dehydrated(fn($state) => filled($state))
                            // Hash the password before it's saved to the database.
                            ->dehydrateStateUsing(fn($state) => Hash::make($state)),
                    ]),
            ])
            ->statePath('data')
            // KEY CHANGE: Bind the form to the authenticated user model instance.
            // This is crucial for 'unique' validation and easy updates.
            ->model($this->record);
    }

    public function submit(): void
    {
        $formData = $this->form->getState();
        try {
            $this->record->update($formData);

            $this->form->fill([
                'name' => $this->record->name,
                'username' => $this->record->username,
                'status' => $this->record->status,
                'password' => '',
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
