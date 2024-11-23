<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UsageRecordResource\Pages;
use App\Filament\Resources\UsageRecordResource\RelationManagers;
use App\Models\UsageRecord;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\FormsComponent;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UsageRecordResource extends Resource
{
    protected static ?string $model = UsageRecord::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('smart_meter_id')
                ->label('Smart Meter')
                ->relationship('smartMeter', 'serial_number')
                ->required(),
                Forms\Components\TextInput::make('consumption')->required()->label('Consumption (kWh)'),
                Forms\Components\DateTimePicker::make('recorded_at')->required()->label('Recorded At'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('smartMeter.serial_number')->label('Smart Meter'),
                Tables\Columns\TextColumn::make('consumption')->label('Consumption (kWh)'),
                Tables\Columns\TextColumn::make('recorded_at')->label('Recorded At'),
            ])
            ->filters([
                //
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
            'index' => Pages\ListUsageRecords::route('/'),
            'create' => Pages\CreateUsageRecord::route('/create'),
            'edit' => Pages\EditUsageRecord::route('/{record}/edit'),
        ];
    }
}
