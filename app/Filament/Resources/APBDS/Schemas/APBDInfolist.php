<?php

namespace App\Filament\Resources\APBDS\Schemas;

use App\Enums\Status;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class APBDInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detail Anggaran Pedapatan dan Belanja Desa (APBDes)')
                    ->columnSpanFull()
                    ->columns(2)
                    ->description('Rencana keuangan tahunan Pemerintah Desa yang berisi perkiraan pendapatan yang diterima desa dan belanja yang akan dikeluarkan desa selama satu tahun anggaran.')
                    ->collapsible()
                    ->schema([
                        TextEntry::make('uuid')
                            ->label('UUID'),
                        TextEntry::make('judul'),
                        TextEntry::make('tahun'),
                        TextEntry::make('status')
                            ->badge(Status::class),
                        TextEntry::make('created_at')
                            ->label('Dibuat Pada')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('updated_at')
                            ->label('Terkahir Diupdate Pada')
                            ->dateTime()
                            ->placeholder('-'),
                    ])
            ]);
    }
}
