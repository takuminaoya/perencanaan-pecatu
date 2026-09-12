<?php

namespace App\Enum;

use BackedEnum;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;
use Override;

enum TipeKasFlow : string implements HasLabel, HasColor, HasIcon
{
    case masuk = 'masuk';
    case keluar = 'keluar';

    public function getLabel(): string|Htmlable|null
    {
        return match($this) {
            self::masuk => 'Pemasukan/Pendapatan',
            self::keluar => 'Belanja/Pengeluaran',
        };
    }


    public function getColor(): string|array|null
    {
        return match($this) {
            self::masuk => 'success',
            self::keluar => 'danger',
        };
    }


    public function getIcon(): string|BackedEnum|Htmlable|null
    {
        return match($this) {
            self::masuk => Heroicon::ArrowTrendingUp,
            self::keluar => Heroicon::ArrowTrendingDown,
        };
    }
}
