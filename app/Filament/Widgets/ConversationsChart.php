<?php

namespace App\Filament\Widgets;

use App\Models\Conversation;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class ConversationsChart extends ChartWidget
{
    protected static ?string $heading = 'Tendencia de Conversaciones';

    protected function getData(): array
    {
        $data = Trend::model(Conversation::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Conversaciones',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate)->toArray(),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date)->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line'; // Puedes cambiar a 'bar' o 'pie'
    }
}
