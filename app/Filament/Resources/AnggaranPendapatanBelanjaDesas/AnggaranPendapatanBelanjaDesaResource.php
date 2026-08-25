<?php

namespace App\Filament\Resources\AnggaranPendapatanBelanjaDesas;

use App\Filament\Resources\AnggaranPendapatanBelanjaDesas\Pages\CreateAnggaranPendapatanBelanjaDesa;
use App\Filament\Resources\AnggaranPendapatanBelanjaDesas\Pages\EditAnggaranPendapatanBelanjaDesa;
use App\Filament\Resources\AnggaranPendapatanBelanjaDesas\Pages\LihatAPBD;
use App\Filament\Resources\AnggaranPendapatanBelanjaDesas\Pages\ListAnggaranPendapatanBelanjaDesas;
use App\Filament\Resources\AnggaranPendapatanBelanjaDesas\Pages\ViewAnggaranPendapatanBelanjaDesa;
use App\Filament\Resources\AnggaranPendapatanBelanjaDesas\Schemas\AnggaranPendapatanBelanjaDesaForm;
use App\Filament\Resources\AnggaranPendapatanBelanjaDesas\Schemas\AnggaranPendapatanBelanjaDesaInfolist;
use App\Filament\Resources\AnggaranPendapatanBelanjaDesas\Tables\AnggaranPendapatanBelanjaDesasTable;
use App\Models\AnggaranPendapatanBelanjaDesa;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class AnggaranPendapatanBelanjaDesaResource extends Resource
{
    protected static ?string $model = AnggaranPendapatanBelanjaDesa::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::DocumentChartBar;

    protected static ?string $recordTitleAttribute = 'judul';

    protected static ?string $navigationLabel = 'APBDesa';

    protected static string|UnitEnum|null $navigationGroup = 'Manajemen RKP & RAB';

    public static function form(Schema $schema): Schema
    {
        return AnggaranPendapatanBelanjaDesaForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AnggaranPendapatanBelanjaDesaInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AnggaranPendapatanBelanjaDesasTable::configure($table);
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
            'index' => ListAnggaranPendapatanBelanjaDesas::route('/'),
            'create' => CreateAnggaranPendapatanBelanjaDesa::route('/create'),
            'view' => LihatAPBD::route('/{record}'),
            'edit' => EditAnggaranPendapatanBelanjaDesa::route('/{record}/edit'),
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
