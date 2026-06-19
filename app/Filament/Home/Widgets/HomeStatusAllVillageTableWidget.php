<?php

namespace App\Filament\Home\Widgets;

use App\Models\IndexVillage;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\ViewAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Text;
use Filament\Support\Enums\TextSize;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class HomeStatusAllVillageTableWidget extends TableWidget
{
    // Gunakan full agar kontainer widgetnya lebar mentok
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => IndexVillage::query())
            ->heading('Detail Status Indeks Desa')
            ->columns([
                // Tambahkan ini untuk nomor urut otomatis
                TextColumn::make('No.')
                    ->state(
                        static fn ($rowLoop, $livewire): string => (string) (
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
                // ViewAction::make()
                //     ->url(fn($record) => HomeResource::getUrl('view', ['record' => $record->id]))
                //     ->label('Lihat Detail')
                ViewAction::make('view')
                    ->label('Lihat Detail')
                    ->iconButton()
                    ->modalHeading()
                    // ->modalWidth('7xl')
                    ->infolist(fn ($record) => [
                        Section::make('Informasi Umum')
                            ->schema([
                                TextEntry::make('desa.nama_desa')->label('Nama Desa'),
                                TextEntry::make('kecamatan.nama_kecamatan')->label('Nama Kecamatan'),
                                TextEntry::make('tahun')->label('Tahun'),
                            ])->columns(2),
                        Section::make('Skor dan Status Indeks Desa')
                            ->schema([
                                Stat::make('Skor', $record->skor),
                                Stat::make('Status Desa', $record->status_indeks),
                            ])->columns(2),
                        Section::make('Detail Dimensi Indeks Desa')
                            ->schema([
                                TextEntry::make('dimensi_layanan_dasar')->label('Dimensi Layanan Dasar')
                                    ->afterLabel(Text::make('Nilai Maksimal : 170')->size(TextSize::ExtraSmall)),
                                TextEntry::make('dimensi_sosial')->label('Dimensi Sosial')
                                    ->afterLabel(Text::make('Nilai Maksimal : 85')->size(TextSize::ExtraSmall)),
                                TextEntry::make('dimensi_ekonomi')->label('Dimensi Ekonomi')
                                    ->afterLabel(Text::make('Nilai Maksimal : 160')->size(TextSize::ExtraSmall)),
                                TextEntry::make('dimensi_lingkungan')->label('Dimensi Lingkungan')
                                    ->afterLabel(Text::make('Nilai Maksimal : 90')->size(TextSize::ExtraSmall)),
                                TextEntry::make('dimensi_aksesibilitas')->label('Dimensi Aksesibilitas')
                                    ->afterLabel(Text::make('Nilai Maksimal : 50')->size(TextSize::ExtraSmall)),
                                TextEntry::make('dimensi_tata_kelola_pemerintah')->label('Dimensi Tata Kelola Pemerintah')
                                    ->afterLabel(Text::make('Nilai Maksimal : 80')->size(TextSize::ExtraSmall)),
                            ])->columns(2),
                    ]),

            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ])->emptyStateHeading('Belum ada data indeks desa');
    }
}
