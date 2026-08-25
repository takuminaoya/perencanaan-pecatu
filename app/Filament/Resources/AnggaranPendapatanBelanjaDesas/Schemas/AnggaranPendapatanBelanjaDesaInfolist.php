<?php

namespace App\Filament\Resources\AnggaranPendapatanBelanjaDesas\Schemas;

use App\Models\AnggaranPendapatanBelanjaDesa;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AnggaranPendapatanBelanjaDesaInfolist
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
                TextEntry::make('jenis'),
                TextEntry::make('status'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (AnggaranPendapatanBelanjaDesa $record): bool => $record->trashed()),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
