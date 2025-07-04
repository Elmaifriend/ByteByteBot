<?php

namespace App\Filament\Resources\IntentResource\Pages;

use App\Filament\Resources\IntentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIntent extends EditRecord
{
    protected static string $resource = IntentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
