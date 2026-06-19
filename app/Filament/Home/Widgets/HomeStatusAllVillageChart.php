<?php

namespace App\Filament\Home\Widgets;

use App\Models\IndexVillage;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class HomeStatusAllVillageChart extends ChartWidget
{
    // protected ?string $heading = 'Jumlah Desa Berdasarkan Status Indeks Desa';

    // protected static ?int $sort = 2;

    // protected static ?string $maxHeight = '400px';

    protected function getFilters(): array
    {
        // $years = IndexVillage::selectRaw('YEAR(tahun) as year')
        //     ->distinct()
        //     ->orderBy('year', 'desc')
        //     ->pluck('year', 'year')
        //     ->toArray();

        $years = [];
        for ($year = date('Y'); $year >= 2025; $year--) {
            $years[$year] = $year;
        }

        return $years ?: [date('Y') => date('Y')];
    }

    public function getHeading(): string
    {
        $activeFilter = $this->filter ?? date('Y');
        $exists = IndexVillage::whereYear('tahun', $activeFilter)->exists();

        if (! $exists) {
            return "⚠️ Tidak Ada Data di Tahun $activeFilter";
        }

        return "Distribusi Status Desa $activeFilter";
    }

    protected function getData(): array
    {
        // 1. Ambil tahun dari filter, default ke tahun sekarang
        $activeFilter = $this->filter ?? date('Y');
        // $activeFilter = 2025;

        // 2. Query untuk menghitung jumlah kata/status berdasarkan tahun
        // Contoh: menghitung berapa yang 'Mandiri', 'Majur', dsb di tahun tersebut
        $data = IndexVillage::query()
            ->whereYear('tahun', $activeFilter) // Pastikan tahun sama
            ->select('status_indeks', DB::raw('count(*) as total'))
            ->groupBy('status_indeks')
            ->pluck('total', 'status_indeks')
            ->toArray();

        // 3. Siapkan label dan nilainya
        // Jika data kosong, berikan array kosong agar tidak error
        $labels = array_keys($data); // Contoh: ['Mandiri', 'Berkembang']
        $values = array_values($data); // Contoh: [10, 25]

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Desa Tahun '.$activeFilter,
                    'data' => $values,
                    'backgroundColor' => [
                        '#36A2EB',
                        '#FF6384',
                        '#FFCE56',
                        '#4BC0C0',
                        '#9966FF',
                    ],
                    'animation' => [
                        'duration' => 1000,
                        'easing' => 'linear',
                        'delay' => 500,
                    ],
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'stepSize' => 1,
                    ],
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                ],
                'datalabels' => [
                    'display' => true,
                    'color' => '#fff',
                    'anchor' => 'start',
                    'align' => 'bottom',
                    'labels' => [
                        'title' => [
                            'font' => [
                                'weight' => 'bold',
                                'size' => 20,
                            ],
                        ],
                    ],
                ],

            ],
        ];
    }
}
