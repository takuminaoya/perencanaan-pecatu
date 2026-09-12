<?php

namespace App\Filament\Resources\ParameterStandarSatuanHargas;

use App\Filament\Resources\ParameterStandarSatuanHargas\Pages\ManageParameterStandarSatuanHargas;
use App\Models\ParameterStandarSatuanHarga;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class ParameterStandarSatuanHargaResource extends Resource
{
    protected static ?string $model = ParameterStandarSatuanHarga::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'uraian_barang';

    protected static string|UnitEnum|null $navigationGroup = 'Manajemen Masterdata';

    protected static ?int $navigationSort = 0;


    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Textarea::make('uraian_barang')
                    ->columnSpanFull(),
                Textarea::make('spesifikasi')
                    ->columnSpanFull(),
                Textarea::make('satuan')
                    ->columnSpanFull(),
                TextInput::make('harga_satuan')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('uraian_barang')
            ->columns([
                TextColumn::make('uraian_barang')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('spesifikasi')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('satuan')
                    ->sortable(),
                TextColumn::make('harga_satuan')
                    ->money('idr')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageParameterStandarSatuanHargas::route('/'),
        ];
    }
}
