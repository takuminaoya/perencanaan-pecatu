<?php

namespace App\Filament\Imports;

use App\Models\ParameterStandarSatuanHarga;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Number;

class ParameterStandarSatuanHargaImporter extends Importer
{
    protected static ?string $model = ParameterStandarSatuanHarga::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('uraian_barang'),
            ImportColumn::make('spesifikasi'),
            ImportColumn::make('satuan'),
            ImportColumn::make('harga_satuan')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
        ];
    }

    public function resolveRecord(): ParameterStandarSatuanHarga
    {
        return new ParameterStandarSatuanHarga();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your parameter standar satuan harga import has completed and ' . Number::format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
