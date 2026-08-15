<?php

namespace App\Filament\Resources\RencanaKerjaKegiatans\Pages;

use App\Filament\Resources\RencanaKerjaKegiatans\RencanaKerjaKegiatanResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewRencanaKerjaKegiatan extends ViewRecord
{
    protected static string $resource = RencanaKerjaKegiatanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
