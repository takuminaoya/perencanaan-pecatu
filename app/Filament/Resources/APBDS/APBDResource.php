<?php

namespace App\Filament\Resources\APBDS;

use App\Filament\Resources\APBDS\Pages\CreateAPBD;
use App\Filament\Resources\APBDS\Pages\CreateAPBDPendapatanMassal;
use App\Filament\Resources\APBDS\Pages\CreateAPBDPengeluaranMassal;
use App\Filament\Resources\APBDS\Pages\EditAPBD;
use App\Filament\Resources\APBDS\Pages\ListAPBDS;
use App\Filament\Resources\APBDS\Pages\ViewAPBD;
use App\Filament\Resources\APBDS\RelationManagers\KasFlowsRelationManager;
use App\Filament\Resources\APBDS\RelationManagers\PerubahansRelationManager;
use App\Filament\Resources\APBDS\Schemas\APBDForm;
use App\Filament\Resources\APBDS\Schemas\APBDInfolist;
use App\Filament\Resources\APBDS\Tables\APBDSTable;
use App\Models\APBD;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class APBDResource extends Resource
{
    protected static ?string $model = APBD::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::DocumentChartBar;

    protected static string|UnitEnum|null $navigationGroup = 'Manajemen APBDes';

    protected static ?string $navigationLabel = 'APBDes';

    protected static ?string $recordTitleAttribute = 'judul';

    protected static ?int $navigationSort = -1;

    public static function form(Schema $schema): Schema
    {
        return APBDForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return APBDInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return APBDSTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            KasFlowsRelationManager::class,
            PerubahansRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAPBDS::route('/'),
            'create' => CreateAPBD::route('/create'),
            'create_pmassal' => CreateAPBDPendapatanMassal::route('/create/pendapatan/massal/{record}'),
            'create_bmassal' => CreateAPBDPengeluaranMassal::route('/create/belanja/massal/{record}'),
            'view' => ViewAPBD::route('/{record}'),
            'edit' => EditAPBD::route('/{record}/edit'),
        ];
    }
}
