<?php

namespace App\Filament\Resources\RencanaKerjaKegiatans\Schemas;

use App\Models\RencanaAnggaranBiaya;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class RencanaKerjaKegiatanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('uuid')
                    ->default(fn () : string => Str::uuid()),
                Select::make('rab_id')
                    ->required()
                    ->allowHtml()
                    ->searchable()
                    ->options(
                        function () : array {
                            $res = [];

                            $rabs = RencanaAnggaranBiaya::all();

                            foreach ($rabs as $rab) {
                                $res[$rab->id] = '<span class="font-bold capitalize">'. $rab->judul . ' Tahun ' . $rab->tahun .'</span><div class="text-sm">'. $rab->jenis .'</div>'; 
                            }

                            return $res;
                        }
                    ),
                TextInput::make('judul')
                    ->required()
                    ->default('rencana kerja kegiatan desa'),
                TextInput::make('tahun')
                    ->required()
                    ->numeric()
                    ->default(2026),
                TextInput::make('desa')
                    ->required()
                    ->default('pemerintah desa pecatu'),
                TextInput::make('kecamatan')
                    ->required()
                    ->default('kuta selatan'),
                TextInput::make('kabupaten')
                    ->required()
                    ->default('badung'),
                TextInput::make('provinsi')
                    ->required()
                    ->default('bali'),
            ]);
    }
}
