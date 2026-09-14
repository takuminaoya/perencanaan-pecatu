<?php

namespace App\Filament\Resources\APBDS\Pages;

use App\Filament\Resources\APBDS\APBDResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditAPBD extends EditRecord
{
    protected static string $resource = APBDResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    public function hasCombinedRelationManagerTabsWithContent(): bool
    {
        return true;
    }
}
