<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;

class TataCaraPenggunaan extends Page
{
    protected string $view = 'filament.pages.tata-cara-penggunaan';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::BookOpen;
    protected ?string $heading = '';
}
