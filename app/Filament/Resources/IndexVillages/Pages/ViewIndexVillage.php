<?php

namespace App\Filament\Resources\IndexVillages\Pages;

use App\Filament\Resources\IndexVillages\IndexVillageResource;
use App\Filament\Resources\IndexVillages\Widgets\IndexVillageTableWidget;
use App\Models\IndexVillage;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Schema;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ViewIndexVillage extends ViewRecord
{
    protected static string $resource = IndexVillageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Back')
                ->url(static::getResource()::getUrl('index')) // Redirects to the list page
                ->button()
                ->color('gray'),
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            IndexVillageTableWidget::class,
        ];
    }

    public function getHeading(): string
    {
        return 'Data Indeks Desa '.ucfirst($this->record->desa->nama_desa).' Tahun '.$this->record->tahun;
    }

    public static function configure(Schema $schema): Schema
    {
        return
            $schema
                ->components([
                    Stat::make('Skor', IndexVillage::query()->where('id', request()->route('record'))->value('skor')),
                    Stat::make('Status Desa', IndexVillage::query()->where('id', request()->route('record'))->value('status_indeks')),
                ]);
    }
}
