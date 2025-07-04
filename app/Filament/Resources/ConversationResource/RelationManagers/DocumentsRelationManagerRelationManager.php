<?php

namespace App\Filament\Resources\ConversationResource\RelationManagers;

use App\Models\Document;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Support\Str; // Mantener esta importación para Str::humanFileSize en la tabla

class DocumentsRelationManager extends RelationManager
{
    protected static string $relationship = 'documents';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('file_path')
                    ->label('Archivo')
                    ->disk('public')
                    ->directory('documents')
                    ->preserveFileNames()
                    ->storeFileNamesIn('file_name') // Esto es correcto y útil para el nombre
                    // ¡ELIMINADO: sizeColumn() y mimetypeColumn() y storeFileInformationIn()!
                    ->acceptedFileTypes([
                        'application/pdf',
                        'application/msword',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        'application/vnd.ms-excel',
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        'text/plain',
                        'image/jpeg',
                        'image/png',
                        'image/gif',
                    ])
                    ->maxSize(10240) // 10MB
                    ->downloadable()
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\Textarea::make('description')
                    ->label('Descripción')
                    ->maxLength(65535)
                    ->nullable()
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('file_name')
            ->columns([
                Tables\Columns\TextColumn::make('file_name')
                    ->label('Nombre del Archivo')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('mime_type')
                    ->label('Tipo')
                    ->searchable(),

                Tables\Columns\TextColumn::make('file_size')
                    ->label('Tamaño')
                    // Mantener Str::humanFileSize si quieres mostrarlo de forma legible
                    // Si file_size es nulo, esta función debe manejarlo bien o mostrará nada.
                    //->getStateUsing(fn (Document $record): string => $record->file_size ? Str::humanFileSize($record->file_size) : 'N/A')
                    ->sortable(),

                Tables\Columns\TextColumn::make('description')
                    ->label('Descripción')
                    ->limit(50)
                    ->tooltip(fn (string $state): string => $state)
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Subido el')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                 Tables\Actions\Action::make('download')
                    ->label('Descargar')
                    ->icon('heroicon-o-arrow-down-tray')
                    //->url(fn (Document $record): string => \Storage::disk('public')->url($record->file_path))
                    ->openUrlInNewTab(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
