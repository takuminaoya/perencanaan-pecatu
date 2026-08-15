<?php

namespace App\Filament\Imports;

use App\Models\ParameterBidang;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Number;

class ParameterBidangImporter extends Importer
{
    protected static ?string $model = ParameterBidang::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('kode')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('parent_kode')
                ->rules(['max:255']),
            ImportColumn::make('nama')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('uraian')
                ->rules(['max:255']),
            ImportColumn::make('satuan')
                ->rules(['max:255']),
            ImportColumn::make('tipe')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
        ];
    }

    public function resolveRecord(): ParameterBidang
    {
        return new ParameterBidang();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your parameter bidang import has completed and ' . Number::format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
