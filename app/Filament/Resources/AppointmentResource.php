<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppointmentResource\Pages;
use App\Models\Appointment;
use Filament\Forms;
use Filament\Forms\Form; // Importar Form
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table; // Importar Table
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope; // Si usas Soft Deletes, si no, puedes quitarlo

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;

    // Define el icono para el menú de navegación
    protected static ?string $navigationIcon = 'heroicon-o-calendar'; // Puedes elegir otro icono si lo prefieres

    // Define el grupo de navegación (opcional, si quieres organizar tus recursos)
    protected static ?string $navigationGroup = 'Gestión de Citas';

    // Define la etiqueta del menú de navegación
    protected static ?string $navigationLabel = 'Citas';

    // Define un orden para la navegación (opcional)
    protected static ?int $navigationSort = -1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Detalles de la Cita')
                    ->description('Información principal de la cita y el cliente.')
                    ->columns(2) // Divide el formulario en 2 columnas
                    ->schema([
                        Forms\Components\TextInput::make('client_name')
                            ->label('Nombre del Cliente')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('email')
                            ->label('Correo Electrónico')
                            ->email() // Validación de email
                            ->required()
                            ->maxLength(255),

                        Forms\Components\DatePicker::make('date')
                            ->label('Fecha de la Cita')
                            ->required()
                            ->native(false) // Mejor UI para el calendario
                            ->minDate(now()) // No permitir agendar citas en el pasado
                            ->format('d/m/Y'), // Formato de visualización

                        Forms\Components\TimePicker::make('time')
                            ->label('Hora de la Cita')
                            ->required()
                            ->seconds(false) // No incluir segundos
                            ->minutesStep(15) // Paso de 15 minutos para la selección
                            ->displayFormat('h:i A'), // Formato de visualización (ej. 02:30 PM)

                        Forms\Components\Textarea::make('notes')
                            ->label('Notas Adicionales')
                            ->columnSpanFull() // Ocupa todo el ancho disponible
                            ->nullable()
                            ->rows(5)
                            ->maxLength(65535),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('client_name')
                    ->label('Cliente')
                    ->searchable() // Permite buscar por nombre
                    ->sortable(), // Permite ordenar por nombre

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),

                Tables\Columns\TextColumn::make('date')
                    ->label('Fecha')
                    ->date('d/m/Y') // Formato de fecha
                    ->sortable(),

                Tables\Columns\TextColumn::make('time')
                    ->label('Hora')
                    ->time('h:i A') // Formato de hora
                    ->sortable(),

                Tables\Columns\TextColumn::make('notes')
                    ->label('Notas')
                    ->toggleable(isToggledHiddenByDefault: true) // Oculto por defecto, se puede mostrar
                    ->limit(50) // Limita el texto para no ocupar mucho espacio
                    ->tooltip(function (string $state): string { // Muestra el texto completo al pasar el ratón
                        return $state;
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado el')
                    ->dateTime('d/m/Y H:i') // Formato de fecha y hora de creación
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true), // Oculto por defecto

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Actualizado el')
                    ->dateTime('d/m/Y H:i') // Formato de fecha y hora de actualización
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true), // Oculto por defecto
            ])
            ->filters([
            ])
            ->actions([
                Tables\Actions\EditAction::make(), // Acción para editar
                Tables\Actions\DeleteAction::make(), // Acción para eliminar
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(), // Acción para eliminar múltiples
                ]),
            ])
            ->defaultSort('date', 'desc'); // Ordenar por fecha de forma descendente por defecto
    }

    public static function getRelations(): array
    {
        return [
            // Aquí puedes definir relaciones si tu modelo Appointment tiene otras relaciones (ej. con un User)
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
            // 'view' => Pages\ViewAppointment::route('/{record}'), // Descomentar si quieres una página de vista detallada
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        // Muestra el número total de citas, útil para una vista rápida
        return static::getModel()::count();
    }

    // Si estás usando Soft Deletes en tu modelo, descomenta este método:
    /*
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
    */
}
