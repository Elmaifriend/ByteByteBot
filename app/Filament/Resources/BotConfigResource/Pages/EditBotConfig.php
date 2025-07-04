<?php

namespace App\Filament\Resources\BotConfigResource\Pages;

use App\Filament\Resources\BotConfigResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBotConfig extends EditRecord
{
    protected static string $resource = BotConfigResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
