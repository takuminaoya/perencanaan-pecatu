<?php

namespace App\Filament\Resources\RencanaAnggaranBiayas\Schemas;

use App\Models\RencanaAnggaranBiaya;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class RencanaAnggaranBiayaInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('uuid')
                    ->label('UUID'),
                TextEntry::make('rkk_id')
                    ->numeric(),
                TextEntry::make('judul'),
                TextEntry::make('tahun')
                    ->numeric(),
                TextEntry::make('status'),
                TextEntry::make('jenis')
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (RencanaAnggaranBiaya $record): bool => $record->trashed()),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
