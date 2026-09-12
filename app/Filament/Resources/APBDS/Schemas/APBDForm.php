<?php

namespace App\Filament\Resources\APBDS\Schemas;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class APBDForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('uuid')
                    ->label('UUID')
                    ->default(fn() : string => Str::uuid()),
                TextInput::make('judul')
                    ->required()
                    ->default('Anggaran Pendapatan Dan Belanja Desa Pecatu'),
                TextInput::make('tahun')
                    ->required()
                    ->numeric()
                    ->default(2026),
                TextInput::make('status')
                    ->required()
                    ->default('draft'),
            ]);
    }
}
