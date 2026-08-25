<?php

namespace App\Filament\Resources\ParameterKegiatans\Pages;

use App\Filament\Imports\ParameterKegiatanImporter;
use App\Filament\Resources\ParameterKegiatans\ParameterKegiatanResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ManageRecords;
use Filament\Support\Icons\Heroicon;

class ManageParameterKegiatans extends ManageRecords
{
    protected static string $resource = ParameterKegiatanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            ImportAction::make()
                ->label('Impor Kegiatan Dari File')
                ->importer(ParameterKegiatanImporter::class)
                ->icon(Heroicon::ArrowDownOnSquare)
        ];
    }
}
