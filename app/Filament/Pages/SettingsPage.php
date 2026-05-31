<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class SettingsPage extends Page implements \Filament\Forms\Contracts\HasForms
{
    use \Filament\Forms\Concerns\InteractsWithForms;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected string $view = 'filament.pages.settings-page';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'announcement_datetime' => \App\Models\Setting::where('key', 'announcement_datetime')->value('value'),
            'principal_message' => \App\Models\Setting::where('key', 'principal_message')->value('value'),
            'principal_message_delayed' => \App\Models\Setting::where('key', 'principal_message_delayed')->value('value'),
            'school_logo' => \App\Models\Setting::where('key', 'school_logo')->value('value'),
            'academic_year' => \App\Models\Setting::where('key', 'academic_year')->value('value'),
            'frontend_theme' => \App\Models\Setting::where('key', 'frontend_theme')->value('value') ?? 'dark',
        ]);
    }

    public function form(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\FileUpload::make('school_logo')
                    ->label('Logo Sekolah')
                    ->image()
                    ->directory('logos')
                    ->disk('public'),
                \Filament\Forms\Components\Select::make('frontend_theme')
                    ->label('Tema Bawaan Halaman Siswa')
                    ->options([
                        'dark' => 'Gelap (Dark Mode)',
                        'light' => 'Terang (Light Mode)',
                    ])
                    ->default('dark')
                    ->required(),
                \Filament\Forms\Components\TextInput::make('academic_year')
                    ->label('Tahun Ajaran')
                    ->placeholder('Contoh: 2023/2024')
                    ->required(),
                \Filament\Forms\Components\DateTimePicker::make('announcement_datetime')
                    ->label('Tanggal & Waktu Pengumuman')
                    ->required(),
                \Filament\Forms\Components\Textarea::make('principal_message')
                    ->label('Pesan Kepala Sekolah (LULUS)')
                    ->rows(4)
                    ->required(),
                \Filament\Forms\Components\Textarea::make('principal_message_delayed')
                    ->label('Pesan Kepala Sekolah (DITANGGUHKAN)')
                    ->rows(4)
                    ->required(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();
        \App\Models\Setting::updateOrCreate(['key' => 'announcement_datetime'], ['value' => $data['announcement_datetime']]);
        \App\Models\Setting::updateOrCreate(['key' => 'principal_message'], ['value' => $data['principal_message']]);
        \App\Models\Setting::updateOrCreate(['key' => 'principal_message_delayed'], ['value' => $data['principal_message_delayed']]);
        \App\Models\Setting::updateOrCreate(['key' => 'academic_year'], ['value' => $data['academic_year']]);
        \App\Models\Setting::updateOrCreate(['key' => 'frontend_theme'], ['value' => $data['frontend_theme']]);
        if (isset($data['school_logo'])) {
            \App\Models\Setting::updateOrCreate(['key' => 'school_logo'], ['value' => $data['school_logo']]);
        }
        
        \Filament\Notifications\Notification::make()
            ->title('Pengaturan berhasil disimpan')
            ->success()
            ->send();
    }
}
