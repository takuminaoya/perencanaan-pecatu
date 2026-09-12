<?php

namespace App\Filament\Resources\APBDS\Pages;

use App\Filament\Resources\APBDS\APBDResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAPBDS extends ListRecords
{
    protected static string $resource = APBDResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
