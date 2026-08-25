<?php

namespace App\Filament\Resources\AnggaranPendapatanBelanjaDesas\Pages;

use App\Filament\Resources\AnggaranPendapatanBelanjaDesas\AnggaranPendapatanBelanjaDesaResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAnggaranPendapatanBelanjaDesa extends ViewRecord
{
    protected static string $resource = AnggaranPendapatanBelanjaDesaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
