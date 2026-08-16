<?php

namespace App\Filament\Resources\RencanaAnggaranBiayas\Schemas;

use App\Models\RencanaKerjaKegiatan;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class RencanaAnggaranBiayaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('uuid')
                    ->label('UUID')
                    ->default(fn () : string => Str::uuid()),
                Select::make('rkk_id')
                    ->label('Rencana Kerja Kegiatan')
                    ->required()
                    ->options(
                        RencanaKerjaKegiatan::query()->pluck('judul', 'id')
                    ),
                TextInput::make('judul')
                    ->required()
                    ->default('rencana anggaran biaya'),
                TextInput::make('tahun')
                    ->required()
                    ->numeric()
                    ->default(2026),
                TextInput::make('jenis'),
            ]);
    }
}
