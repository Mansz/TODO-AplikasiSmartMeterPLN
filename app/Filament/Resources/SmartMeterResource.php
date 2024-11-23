<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SmartMeterResource\Pages;
use App\Filament\Resources\SmartMeterResource\RelationManagers;
use App\Models\SmartMeter;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\FormsComponent;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\EditAction; // Pastikan ini diimpor
use Filament\Tables\Actions\BulkActionGroup; // Pastikan ini diimpor
use Filament\Tables\Actions\DeleteBulkAction; // Pastikan ini diimpor
use Filament\Tables\Filters\SelectFilter; // Pastikan ini diimpor


class SmartMeterResource extends Resource
{
    protected static ?string $model = SmartMeter::class;

    protected static ?string $navigationIcon = 'heroicon-o-light-bulb';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('serial_number')
                ->required()
                ->unique('smart_meters', 'serial_number', fn ($record) => $record ? $record->id : null),
            Forms\Components\TextInput::make('location')->required(),
            Forms\Components\Select::make('status')
                ->options(['active' => 'Active', 'inactive' => 'Inactive'])
                ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('serial_number')->label('Serial Number')->searchable(),
                Tables\Columns\TextColumn::make('location')->searchable(),
                Tables\Columns\SelectColumn::make('status')
                ->options([
                    'active' => 'Active',
                    'inactive' => 'Inactive'
                ])
                ->label('Status'),
                Tables\Columns\TextColumn::make('last_reading')
    ->label('Last Reading (kWh)')
    ->sortable()
    ->default('0.00') // Tampilkan 0.00 jika nilai kosong
    ->formatStateUsing(fn ($state) => number_format($state, 2) . ' kWh'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(['active' => 'Active', 'inactive' => 'Inactive']),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListSmartMeters::route('/'),
            'create' => Pages\CreateSmartMeter::route('/create'),
            'edit' => Pages\EditSmartMeter::route('/{record}/edit'),
        ];
    }
}
