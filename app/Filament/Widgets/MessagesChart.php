<?php

namespace App\Filament\Widgets;

use App\Models\Message;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class MessagesChart extends ChartWidget
{
    protected static ?string $heading = 'Tendencia de Mensajes por Día';

    protected function getData(): array
    {
        $data = Trend::model(Message::class)
            ->between(
                start: now()->subDays(30),  // Últimos 30 días
                end: now(),
            )
            ->perDay()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Mensajes',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate)->toArray(),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date)->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line'; // O 'bar' si prefieres barras
    }
}
