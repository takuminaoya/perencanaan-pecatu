<?php

namespace App\Filament\Resources\AnggaranPendapatanBelanjaDesas\Pages;

use App\Filament\Resources\AnggaranPendapatanBelanjaDesas\AnggaranPendapatanBelanjaDesaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAnggaranPendapatanBelanjaDesas extends ListRecords
{
    protected static string $resource = AnggaranPendapatanBelanjaDesaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
