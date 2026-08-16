<?php

namespace App\Filament\Resources\RencanaAnggaranBiayas;

use App\Filament\Resources\RencanaAnggaranBiayas\Pages\CreateRencanaAnggaranBiaya;
use App\Filament\Resources\RencanaAnggaranBiayas\Pages\EditRencanaAnggaranBiaya;
use App\Filament\Resources\RencanaAnggaranBiayas\Pages\LihatRAB;
use App\Filament\Resources\RencanaAnggaranBiayas\Pages\ListRencanaAnggaranBiayas;
use App\Filament\Resources\RencanaAnggaranBiayas\Pages\ViewRencanaAnggaranBiaya;
use App\Filament\Resources\RencanaAnggaranBiayas\Schemas\RencanaAnggaranBiayaForm;
use App\Filament\Resources\RencanaAnggaranBiayas\Schemas\RencanaAnggaranBiayaInfolist;
use App\Filament\Resources\RencanaAnggaranBiayas\Tables\RencanaAnggaranBiayasTable;
use App\Models\RencanaAnggaranBiaya;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class RencanaAnggaranBiayaResource extends Resource
{
    protected static ?string $model = RencanaAnggaranBiaya::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'judul';

    protected static string|UnitEnum|null $navigationGroup = 'Manajemen RKP & RAB';

    public static function form(Schema $schema): Schema
    {
        return RencanaAnggaranBiayaForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return RencanaAnggaranBiayaInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RencanaAnggaranBiayasTable::configure($table);
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
            'index' => ListRencanaAnggaranBiayas::route('/'),
            'create' => CreateRencanaAnggaranBiaya::route('/create'),
            'view' => LihatRAB::route('/{record}'),
            'edit' => EditRencanaAnggaranBiaya::route('/{record}/edit'),
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
