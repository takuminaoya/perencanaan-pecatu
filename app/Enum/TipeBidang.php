<?php

namespace App\Enum;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum TipeBidang : string implements HasLabel
{
    case main = 'main';
    case sub = 'sub';
    case child = 'child';

    
    public function getLabel(): string|Htmlable|null
    {
        return match ($this) {
            self::main => 'Bidang Utama',
            self::sub => 'Sub Bidang Dari Bidang Utama',
            self::child => 'Kegiatan dari Sub Bidang',
        };
    }
}
