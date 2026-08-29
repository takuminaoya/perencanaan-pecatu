<?php

namespace App\Filament\Resources\ParameterSumberDanas\Pages;

use App\Filament\Resources\ParameterSumberDanas\ParameterSumberDanaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageParameterSumberDanas extends ManageRecords
{
    protected static string $resource = ParameterSumberDanaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
