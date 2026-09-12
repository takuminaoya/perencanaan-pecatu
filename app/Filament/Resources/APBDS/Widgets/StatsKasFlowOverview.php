<?php

namespace App\Filament\Resources\APBDS\Widgets;

use App\Models\APBD;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsKasFlowOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Pendapatan/Pemasukan', 
                function ($livewire) {
                    $record_id = $livewire->htmlAttributes['record']['id'];
                    $record = APBD::find($record_id);
                    $res = 0;

                    if($record)
                        $res = $record->kasFlows()->where('tipe', 'masuk')->sum('jumlah');

                    return 'Rp ' . number_format($res);
                }
            ),
            Stat::make('Total Pengeluaran/Belanja', 
                function ($livewire) {
                    $record_id = $livewire->htmlAttributes['record']['id'];
                    $record = APBD::find($record_id);
                    $res = 0;

                    if($record)
                        $res = $record->kasFlows()->where('tipe', 'keluar')->sum('jumlah');

                    return 'Rp ' . number_format($res);
                }
            ),
            Stat::make('Sisa Untuk Periode Ini', 
                function ($livewire) {
                    $record_id = $livewire->htmlAttributes['record']['id'];
                    $record = APBD::find($record_id);
                    $res = 0;

                    if($record)
                        $masuk = $record->kasFlows()->where('tipe', 'masuk')->sum('jumlah');
                        $keluar = $record->kasFlows()->where('tipe', 'keluar')->sum('jumlah');
                        $res = $masuk - $keluar;

                    return 'Rp ' . number_format($res);
                }
            ),
        ];
    }
}
