<?php

namespace App\Filament\Resources\ParameterBidangs\Pages;

use App\Filament\Imports\ParameterBidangImporter;
use App\Filament\Resources\ParameterBidangs\ParameterBidangResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ManageRecords;
use Filament\Support\Icons\Heroicon;

class ManageParameterBidangs extends ManageRecords
{
    protected static string $resource = ParameterBidangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Buat Bidang')
                ->icon(Heroicon::Plus),
            ImportAction::make()
                ->label('Impor Bidang Dari File')
                ->importer(ParameterBidangImporter::class)
                ->icon(Heroicon::ArrowDownOnSquare)
        ];
    }
}
