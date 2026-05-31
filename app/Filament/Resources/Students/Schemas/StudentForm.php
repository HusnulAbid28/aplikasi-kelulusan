<?php

namespace App\Filament\Resources\Students\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class StudentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nisn')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('password')
                    ->password()
                    ->required(),
                \Filament\Forms\Components\Select::make('status')
                    ->options([
                        'LULUS' => 'LULUS',
                        'DITANGGUHKAN' => 'DITANGGUHKAN',
                    ])
                    ->required()
                    ->default('DITANGGUHKAN'),
            ]);
    }
}
