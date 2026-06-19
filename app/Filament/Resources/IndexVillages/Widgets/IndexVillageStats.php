<?php

namespace App\Filament\Resources\IndexVillages\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Model;

// BELUM TERPAKAI, KARENA SUDAH ADA DI VIEW PAGE
// BELUM KETEMU CARA HIDDEN FORM BAWAAN RESOURCE

class IndexVillageStats extends StatsOverviewWidget
{
    public ?Model $record = null;

    // Gunakan full agar kontainer widgetnya lebar mentok
    protected int|string|array $columnSpan = 'full';

    // 2. Paksa grid di dalam widget menjadi 2 kolom saja
    protected int|null|array $columns = 2;

    protected function getStats(): array
    {
        return [

            Stat::make('Skor', $this->record->skor),
            Stat::make('Status Desa', $this->record->status_indeks),
        ];
    }
}
