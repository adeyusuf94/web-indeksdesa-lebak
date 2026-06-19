<?php

namespace App\Filament\Resources\IndexVillages\Widgets;

use App\Models\IndexVillage;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class IndexVillageTableWidget extends TableWidget
{
    public ?Model $record = null;

    // Gunakan full agar kontainer widgetnya lebar mentok
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Detail Dimensi Indeks Desa')
            ->query(fn (): Builder => IndexVillage::query()->where('id', $this->record->id)
                ->where('tahun', $this->record->tahun)
                ->latest()
                ->limit(1))
            ->columns([
                TextColumn::make('dimensi_layanan_dasar')
                    ->label('Dimensi Layanan Dasar')
                    ->headerTooltip('Nilai Maksimal: 170')
                    ->description('Nilai Maksimal : 170'),
                TextColumn::make('dimensi_sosial')
                    ->label('Dimensi Sosial')
                    ->headerTooltip('Nilai Maksimal: 85')
                    ->description('Nilai Maksimal : 85'),
                TextColumn::make('dimensi_ekonomi')
                    ->label('Dimensi Ekonomi')
                    ->headerTooltip('Nilai Maksimal: 160')
                    ->description('Nilai Maksimal : 160'),
                TextColumn::make('dimensi_lingkungan')
                    ->label('Dimensi Lingkungan')
                    ->headerTooltip('Nilai Maksimal: 90')
                    ->description('Nilai Maksimal : 90'),
                TextColumn::make('dimensi_aksesibilitas')
                    ->label('Dimensi Aksesibilitas')
                    ->headerTooltip('Nilai Maksimal: 50')
                    ->description('Nilai Maksimal : 50'),
                TextColumn::make('dimensi_tata_kelola_pemerintah')
                    ->label('Dimensi Tata Kelola Pemerintah')
                    ->headerTooltip('Nilai Maksimal: 80')
                    ->description('Nilai Maksimal : 80'),
            ])
            ->paginated(false) // Nonaktifkan pagination untuk menampilkan semua data sekaligus
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ])->emptyStateHeading('Belum ada data indeks desa');
    }
}
