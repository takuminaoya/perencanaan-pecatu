<?php

namespace App\Filament\Imports;

use App\Models\ParameterKegiatan;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Number;

class ParameterKegiatanImporter extends Importer
{
    protected static ?string $model = ParameterKegiatan::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('kode')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('uraian')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('kode_singkat')
                ->rules(['max:255']),
            ImportColumn::make('uraian_output')
                ->rules(['max:255']),
            ImportColumn::make('satuan_output')
                ->rules(['max:255']),
        ];
    }

    public function resolveRecord(): ParameterKegiatan
    {
        return new ParameterKegiatan();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your parameter kegiatan import has completed and ' . Number::format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
