<?php

namespace App\Filament\Resources\RencanaAnggaranBiayas\Pages;

use App\Filament\Resources\RencanaAnggaranBiayas\RencanaAnggaranBiayaResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditRencanaAnggaranBiaya extends EditRecord
{
    protected static string $resource = RencanaAnggaranBiayaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
