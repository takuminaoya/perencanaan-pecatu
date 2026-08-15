<?php

namespace App\Filament\Resources\RencanaKerjaKegiatans\Pages;

use App\Filament\Resources\RencanaKerjaKegiatans\RencanaKerjaKegiatanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRencanaKerjaKegiatans extends ListRecords
{
    protected static string $resource = RencanaKerjaKegiatanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
