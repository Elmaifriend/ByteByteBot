<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IntentResource\Pages;
use App\Models\Intent;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class IntentResource extends Resource
{
    protected static ?string $model = Intent::class;

    protected static ?string $navigationIcon = 'heroicon-o-light-bulb';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('intent')
                ->label('Nombre')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('key')
                ->label('Clave')
                ->required()
                ->maxLength(255)
                ->unique(),

            Forms\Components\Textarea::make('description')
                ->label('Descripción')
                ->rows(4)
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('intent')->label('Intención'),
            Tables\Columns\TextColumn::make('key')->label('Clave'),
            Tables\Columns\TextColumn::make('description')->label('Descripción')->limit(60)->wrap(),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListIntents::route('/'),
            'create' => Pages\CreateIntent::route('/create'),
            'edit' => Pages\EditIntent::route('/{record}/edit'),
        ];
    }
}
