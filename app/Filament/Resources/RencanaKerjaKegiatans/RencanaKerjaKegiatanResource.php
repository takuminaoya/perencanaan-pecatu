<?php

namespace App\Filament\Resources\RencanaKerjaKegiatans;

use App\Filament\Resources\RencanaKerjaKegiatans\Pages\CreateRencanaKerjaKegiatan;
use App\Filament\Resources\RencanaKerjaKegiatans\Pages\EditRencanaKerjaKegiatan;
use App\Filament\Resources\RencanaKerjaKegiatans\Pages\LihatRKP;
use App\Filament\Resources\RencanaKerjaKegiatans\Pages\ListRencanaKerjaKegiatans;
use App\Filament\Resources\RencanaKerjaKegiatans\Pages\ViewRencanaKerjaKegiatan;
use App\Filament\Resources\RencanaKerjaKegiatans\Schemas\RencanaKerjaKegiatanForm;
use App\Filament\Resources\RencanaKerjaKegiatans\Schemas\RencanaKerjaKegiatanInfolist;
use App\Filament\Resources\RencanaKerjaKegiatans\Tables\RencanaKerjaKegiatansTable;
use App\Models\RencanaKerjaKegiatan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class RencanaKerjaKegiatanResource extends Resource
{
    protected static ?string $model = RencanaKerjaKegiatan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'judul';

    protected static string|UnitEnum|null $navigationGroup = 'Manajemen RKP & RAB';

    protected static ?int $navigationSort = 0;

    public static function form(Schema $schema): Schema
    {
        return RencanaKerjaKegiatanForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return RencanaKerjaKegiatanInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RencanaKerjaKegiatansTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRencanaKerjaKegiatans::route('/'),
            'create' => CreateRencanaKerjaKegiatan::route('/create'),
            'view' => LihatRKP::route('/{record}'),
            'edit' => EditRencanaKerjaKegiatan::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
