<?php

namespace App\Filament\Resources\ParameterKas\Pages;

use App\Filament\Imports\ParameterKasImporter;
use App\Filament\Resources\ParameterKas\ParameterKasResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ManageRecords;
use Filament\Support\Icons\Heroicon;

class ManageParameterKas extends ManageRecords
{
    protected static string $resource = ParameterKasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->icon(Heroicon::Plus),
            ImportAction::make()
                ->label('Impor Kas Dari File')
                ->importer(ParameterKasImporter::class)
                ->icon(Heroicon::ArrowDownOnSquare)
        ];
    }
}
