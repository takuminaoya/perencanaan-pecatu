<?php

namespace App\Filament\Resources\APBDS\Pages;

use App\Enum\TipeKasFlow;
use App\Filament\Resources\APBDS\APBDResource;
use App\Filament\Resources\APBDS\Widgets\StatsKasFlowOverview;
use App\Models\ParameterKas;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
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
            Action::make('massal_pendapatan')
                ->label('Buat Pendapatan Massal')
                ->icon(Heroicon::PlusCircle)
                ->color(Color::Green)
                ->url(fn ($record) => APBDResource::getUrl('create_pmassal', ['record' => $record->id])),
            Action::make('massal_pengeluaran')
                ->label('Buat Pendapatan Massal')
                ->icon(Heroicon::MinusCircle)
                ->color(Color::Red)
                ->url(fn ($record) => APBDResource::getUrl('create_bmassal', ['record' => $record->id])),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            StatsKasFlowOverview::class
        ];
    }
}
