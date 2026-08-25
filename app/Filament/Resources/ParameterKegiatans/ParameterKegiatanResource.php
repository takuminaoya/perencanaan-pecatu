<?php

namespace App\Filament\Resources\ParameterKegiatans;

use App\Filament\Resources\ParameterKegiatans\Pages\ManageParameterKegiatans;
use App\Models\ParameterKegiatan;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class ParameterKegiatanResource extends Resource
{
    protected static ?string $model = ParameterKegiatan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::HomeModern;

    protected static string|UnitEnum|null $navigationGroup = 'Manajemen Masterdata';

    protected static ?string $recordTitleAttribute = 'uraian';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('kode')
                    ->required(),
                TextInput::make('uraian')
                    ->required(),
                TextInput::make('kode_singkat'),
                TextInput::make('uraian_output'),
                TextInput::make('satuan_output'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('uraian')
            ->columns([
                TextColumn::make('kode')
                    ->searchable(),
                TextColumn::make('uraian')
                    ->searchable(),
                TextColumn::make('kode_singkat')
                    ->searchable(),
                TextColumn::make('uraian_output')
                    ->searchable(),
                TextColumn::make('satuan_output')
                    ->searchable(),
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
            'index' => ManageParameterKegiatans::route('/'),
        ];
    }
}
