<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Http;

class UmamiOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 5;

    protected function getStats(): array
    {
        $baseUrl = rtrim(config('services.umami.url'), '/');

        $websiteId = config('services.umami.website_id');

        $apiKey = config('services.umami.api_key');

        $response = Http::withHeaders([
            'x-umami-api-key' => $apiKey,
        ])->get(
            "{$baseUrl}/v1/websites/{$websiteId}/stats",
            [
                'startAt' => now()->startOfMonth()->timestamp * 1000,
                'endAt' => now()->endOfMonth()->timestamp * 1000,
            ]
        )
            ->json();


        // dd($response);
        // console_log($response);

        return [
            Stat::make(
                'Visitors',
                number_format($response['visitors'] ?? 0)
            )
                ->description('Pengunjung bulan ini'),

            Stat::make(
                'Visits',
                number_format($response['visits'] ?? 0)
            )
                ->description('Kunjungan bulan ini'),

            Stat::make(
                'Page Views',
                number_format($response['pageviews'] ?? 0)
            )
                ->description('Halaman dibuka'),
        ];
    }
}
