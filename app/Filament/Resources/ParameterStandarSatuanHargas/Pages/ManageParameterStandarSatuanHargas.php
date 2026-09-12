<?php

namespace App\Filament\Resources\ParameterStandarSatuanHargas\Pages;

use App\Filament\Imports\ParameterStandarSatuanHargaImporter;
use App\Filament\Resources\ParameterStandarSatuanHargas\ParameterStandarSatuanHargaResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ManageRecords;

class ManageParameterStandarSatuanHargas extends ManageRecords
{
    protected static string $resource = ParameterStandarSatuanHargaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            ImportAction::make('import_ssh')
                ->label('Import SSH')
                ->importer(ParameterStandarSatuanHargaImporter::class)
        ];
    }
}
