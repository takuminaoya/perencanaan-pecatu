<?php

namespace App\Filament\Resources\APBDS\Pages;

use App\Filament\Resources\APBDS\APBDResource;
use App\Filament\Resources\APBDS\Widgets\StatsKasFlowOverview;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;

class ViewAPBD extends ViewRecord
{
    protected static string $resource = APBDResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->label('Perbarui APBD')
                ->icon(Heroicon::PencilSquare),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            StatsKasFlowOverview::class
        ];
    }
}
