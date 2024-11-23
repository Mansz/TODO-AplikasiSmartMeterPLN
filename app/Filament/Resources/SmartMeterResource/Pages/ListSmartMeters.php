<?php

namespace App\Filament\Resources\SmartMeterResource\Pages;

use App\Filament\Resources\SmartMeterResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSmartMeters extends ListRecords
{
    protected static string $resource = SmartMeterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
