<?php

namespace App\Filament\Resources\UsageRecordResource\Pages;

use App\Filament\Resources\UsageRecordResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUsageRecord extends EditRecord
{
    protected static string $resource = UsageRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
