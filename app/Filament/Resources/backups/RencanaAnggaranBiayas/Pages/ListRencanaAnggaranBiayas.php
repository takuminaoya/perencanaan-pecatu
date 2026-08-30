<?php

namespace App\Filament\Resources\RencanaAnggaranBiayas\Pages;

use App\Filament\Resources\RencanaAnggaranBiayas\RencanaAnggaranBiayaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRencanaAnggaranBiayas extends ListRecords
{
    protected static string $resource = RencanaAnggaranBiayaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
