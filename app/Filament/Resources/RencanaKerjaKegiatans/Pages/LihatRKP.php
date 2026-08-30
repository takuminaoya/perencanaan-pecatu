<?php

namespace App\Filament\Resources\RencanaKerjaKegiatans\Pages;

use App\Filament\Resources\RencanaKerjaKegiatans\RencanaKerjaKegiatanResource;
use App\Models\ParameterBidang;
use App\Models\RencanaKerjaKegiatanBidang;
use App\Models\RencanaKerjaKegiatanBidangDetail;
use Carbon\Carbon;
use Exception;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Support\RawJs;
use Override;

class LihatRKP extends Page
{
    use InteractsWithRecord;

    protected static string $resource = RencanaKerjaKegiatanResource::class;

    protected ?string $heading = "";

    protected string $view = 'filament.resources.rencana-kerja-kegiatans.pages.lihat-r-k-p';

    public $total_anggaran = 0;
    public $total_sasaran = 0;

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }
}
