<?php

namespace App\Filament\Widgets;

use App\Models\IndexVillage;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Components\Section;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatusAllVillageStatOverview extends StatsOverviewWidget implements HasForms
{
    use InteractsWithForms;

    public ?int $tahun = null;

    protected static ?int $sort = 1;

    protected int|string|array $columnSpan = 1;

    public function mount(): void
    {
        // 🔥 DEFAULT TAHUN SEKARANG
        $this->tahun = date('Y');
    }

    protected function getColumns(): int
    {
        return 1;
    }

    /**
     * Generate opsi tahun tanpa database (dari tahun sekarang s.d 2025)
     */
    private function getTahunOptions(): array
    {
        $years = [];

        for ($year = date('Y'); $year >= 2025; $year--) {
            $years[$year] = $year;
        }

        return $years ?: [date('Y') => date('Y')];
    }

    /**
     * Hitung rata-rata skor berdasarkan filter
     */
    private function getAverageSkor(): float
    {
        $avg = IndexVillage::query()
            ->when($this->tahun, fn($q) => $q->whereYear('tahun', $this->tahun))
            ->avg('skor');

        return round($avg ?? 0, 2);
    }

    /**
     * Tentukan status berdasarkan skor
     */
    private function getStatusIndex(float $skor): string
    {
        return match (true) {
            $skor >= 79.63 => 'Mandiri',
            $skor >= 69.35 => 'Maju',
            $skor >= 57.39 => 'Berkembang',
            $skor >= 49.49 => 'Tertinggal',
            default => 'Sangat Tertinggal',
        };
    }

    protected function getStats(): array
    {
        $avgSkor = $this->getAverageSkor();

        return [
            Section::make('Rata-rata Skor Indeks Desa')
                ->schema([

                    // 🔽 FILTER
                    Select::make('tahun')
                        ->label('Filter Tahun')
                        ->placeholder('Pilih Tahun')
                        ->options($this->getTahunOptions())
                        ->default(date('Y'))
                        ->live(),

                    // 📊 STAT
                    Stat::make('Rata-rata Skor Indeks Desa', $avgSkor),

                    Stat::make(
                        'Rata-rata Status Perkembangan Desa',
                        $this->getStatusIndex($avgSkor)
                    ),
                ])
                ->columns(1)
                ->compact(),
        ];
    }
}
