<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BotConfigResource\Pages;
use App\Models\BotConfig;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;

class BotConfigResource extends Resource
{
    protected static ?string $model = BotConfig::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static ?string $navigationGroup = 'Ajustes';

    protected static ?string $navigationLabel = 'Ajustes del bot';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('rules')
                    ->label('Reglas del Bot')
                    ->required()
                    ->rows(10)
                    ->placeholder('Ejemplo: Sé amable, sé gentil, responde eso, esta es la información de la empresa...'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('rules')
                    ->label('Reglas del Bot')
                    ->limit(100)
                    ->wrap(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBotConfigs::route('/'),
            'create' => Pages\CreateBotConfig::route('/create'),
            'edit' => Pages\EditBotConfig::route('/{record}/edit'),
        ];
    }
}
