<?php

namespace App\Filament\Resources\AnggaranPendapatanBelanjaDesas\Schemas;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class AnggaranPendapatanBelanjaDesaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('uuid')
                    ->label('UUID')
                    ->default(fn () : string => Str::uuid()),
                TextInput::make('judul')
                    ->required()
                    ->default('anggaran pendapatan dan belanja desa'),
                TextInput::make('tahun')
                    ->required()
                    ->numeric()
                    ->default(2026),
                TextInput::make('jenis')
                    ->required()
                    ->default('APBDes'),
            ]);
    }
}
