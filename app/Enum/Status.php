<?php

namespace App\Enums;

use BackedEnum;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;
use Override;

enum Status : string implements HasLabel, HasColor, HasIcon
{
    case draft = 'draft';
    case verifikasi = 'verifikasi';
    case perbaikan = 'perbaikan';
    case terverifikasi = 'terverifikasi';
    case penilaian = 'penilaian';
    case selesai = 'selesai';

    public function getLabel(): string|Htmlable|null
    {
        return match($this) {
            self::draft => 'Draft',
            self::verifikasi => 'Dalam Proses Verifikasi',
            self::perbaikan => 'Terdapat Kesalahan Yang Harus Diperbaiki',
            self::terverifikasi => 'Telah Diverifikasi',
            self::penilaian => 'Sedang Dinilai',
            self::selesai => 'Telah Dinilai Dan Ditutup',
        };
    }

    public function getColor(): string|array|null
    {
        return match($this) {
            self::draft => 'info',
            self::verifikasi => 'dark',
            self::perbaikan => 'warning',
            self::terverifikasi => 'info',
            self::penilaian => 'warning',
            self::selesai => 'success',
        };
    }

    public function getIcon(): string|BackedEnum|Htmlable|null
    {
         return match($this) {
            self::draft => 'heroicon-o-document',
            self::verifikasi => 'heroicon-o-document-check',
            self::perbaikan => 'heroicon-o-pencil-square',
            self::terverifikasi => 'heroicon-o-check-badge',
            self::penilaian => 'heroicon-o-pencil',
            self::selesai => 'heroicon-o-clipboard-document-check',
        };
    }
}
