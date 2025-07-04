<?php

namespace App\Filament\Resources\BotConfigResource\Pages;

use App\Filament\Resources\BotConfigResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBotConfigs extends ListRecords
{
    protected static string $resource = BotConfigResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
