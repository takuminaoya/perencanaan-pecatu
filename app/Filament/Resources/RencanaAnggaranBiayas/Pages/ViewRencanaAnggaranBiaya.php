<?php

namespace App\Filament\Resources\RencanaAnggaranBiayas\Pages;

use App\Filament\Resources\RencanaAnggaranBiayas\RencanaAnggaranBiayaResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewRencanaAnggaranBiaya extends ViewRecord
{
    protected static string $resource = RencanaAnggaranBiayaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
