<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\IndexVillages\IndexVillageResource;
use App\Models\IndexVillage;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class StatusAllVillageTableWidget extends TableWidget
{
    // Gunakan full agar kontainer widgetnya lebar mentok
    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 4;

    public function table(Table $table): Table
    {
        return $table
            ->query(fn(): Builder => IndexVillage::query())
            ->heading('Detail Status Indeks Desa')
            ->columns([
                // Tambahkan ini untuk nomor urut otomatis
                TextColumn::make('No.')
                    ->state(
                        static fn($rowLoop, $livewire): string => (string) (
                            $rowLoop->iteration +
                            ($livewire->getTableRecordsPerPage() * ($livewire->getTablePage() - 1))
                        )
                    ),
                // TextColumn::make('id_kecamatan')->label('Kode Kecamatan'),
                TextColumn::make('kecamatan.nama_kecamatan')->label('Nama Kecamatan')->searchable()->sortable(),
                // TextColumn::make('id_desa')->label('Kode Desa'),
                TextColumn::make('desa.nama_desa')->label('Nama Desa')->searchable()->sortable(),
                TextColumn::make('skor')->label('Skor Indeks Desa')->sortable(),
                TextColumn::make('status_indeks')->label('Status Indeks Desa')->searchable()->sortable(),
                TextColumn::make('tahun')->label('Tahun')->searchable()->sortable(),
            ])
            ->filters([
                //
                SelectFilter::make('id_kecamatan')
                    ->label('Filter berdasarkan Kecamatan')
                    ->options(
                        IndexVillage::query()
                            ->select('kecamatan.id_kecamatan', 'kecamatan.nama_kecamatan')
                            ->distinct()
                            ->join('kecamatan', 'indeks_desa.id_kecamatan', '=', 'kecamatan.id_kecamatan')
                            ->orderBy('kecamatan.nama_kecamatan', 'asc')
                            ->pluck('kecamatan.nama_kecamatan', 'kecamatan.id_kecamatan')
                            ->toArray()
                    )
                    ->preload()
                    ->searchable()
                    ->multiple()
                    ->placeholder('Pilih Kecamatan'),
                SelectFilter::make('id_desa')
                    ->label('Filter berdasarkan Desa')
                    ->options(
                        IndexVillage::query()
                            ->select('desa.id_desa', 'desa.nama_desa')
                            ->distinct()
                            ->join('desa', 'indeks_desa.id_desa', '=', 'desa.id_desa')
                            ->orderBy('desa.nama_desa', 'asc')
                            ->pluck('desa.nama_desa', 'desa.id_desa')
                            ->toArray()
                    )
                    ->preload()
                    ->searchable()
                    ->multiple()
                    ->placeholder('Pilih Desa'),
                SelectFilter::make('status_indeks')
                    ->label('Filter berdasarkan Status Indeks Desa')
                    ->options([
                        'Mandiri' => 'Mandiri',
                        'Maju' => 'Maju',
                        'Berkembang' => 'Berkembang',
                        'Tertinggal' => 'Tertinggal',
                        'Sangat Tertinggal' => 'Sangat Tertinggal',
                    ])
                    ->preload()
                    ->searchable()
                    ->multiple()
                    ->placeholder('Pilih Status Indeks Desa'),
                SelectFilter::make('tahun')
                    ->label('Filter berdasarkan Tahun')
                    ->options(
                        IndexVillage::query()
                            ->select('tahun')
                            ->distinct()
                            ->orderBy('tahun', 'desc')
                            ->pluck('tahun', 'tahun')
                            ->toArray()
                    )
                    ->preload()
                    ->searchable()
                    ->multiple()
                    ->placeholder('Pilih Tahun'),
            ], layout: FiltersLayout::Modal)
            ->headerActions([
                //
            ])
            ->recordActions([
                // ViewAction::make('view')
                //     ->modalHeading('Detail Indeks Desa')
                //     // ->modalWidth('7xl')
                //     ->modalContent(fn($record) => view(
                //         'filament.modals.detail-indeks-desa',
                //         [
                //             'record' => $record,
                //         ]
                //     )),
                ViewAction::make('view')
                    ->url(fn($record) => IndexVillageResource::getUrl('view', [
                        'record' => $record,
                    ]))
                    ->label('Lihat Detail')
                    ->iconButton(),

            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ])
            ->striped()
            ->emptyStateHeading('Belum ada data indeks desa');
    }
}
