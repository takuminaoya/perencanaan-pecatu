<?php

namespace App\Filament\Resources\RencanaKerjaKegiatans\Schemas;

use App\Models\RencanaKerjaKegiatan;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class RencanaKerjaKegiatanInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('uuid')
                    ->label('UUID'),
                TextEntry::make('judul'),
                TextEntry::make('tahun')
                    ->numeric(),
                TextEntry::make('desa'),
                TextEntry::make('kecamatan'),
                TextEntry::make('kabupaten'),
                TextEntry::make('provinsi'),
                TextEntry::make('status'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (RencanaKerjaKegiatan $record): bool => $record->trashed()),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
