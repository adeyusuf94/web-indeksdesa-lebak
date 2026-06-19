<?php

namespace App\Filament\Resources\IndexVillages\Tables;

use App\Models\IndexVillage;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class IndexVillagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // Tambahkan ini untuk nomor urut otomatis
                TextColumn::make('No.')
                    ->state(
                        static fn ($rowLoop, $livewire): string => (string) (
                            $rowLoop->iteration +
                            ($livewire->getTableRecordsPerPage() * ($livewire->getTablePage() - 1))
                        )
                    ),
                TextColumn::make('id_kecamatan')->label('Kode Kecamatan')->searchable(),
                TextColumn::make('kecamatan.nama_kecamatan')->label('Nama Kecamatan')->searchable()->sortable(),
                TextColumn::make('id_desa')->label('Kode Desa')->searchable(),
                TextColumn::make('desa.nama_desa')->label('Nama Desa')->searchable()->sortable(),
                // TextColumn::make('dimensi_layanan_dasar')->label('Dimensi Layanan Dasar'),
                // TextColumn::make('dimensi_sosial')->label('Dimensi Sosial'),
                // TextColumn::make('dimensi_ekonomi')->label('Dimensi Ekonomi'),
                // TextColumn::make('dimensi_lingkungan')->label('Dimensi Lingkungan'),
                // TextColumn::make('dimensi_aksesibilitas')->label('Dimensi Aksesibilitas'),
                // TextColumn::make('dimensi_tata_kelola_pemerintah')->label('Dimensi Tata Kelola Pemerintah'),
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
            ->recordActions([
                ViewAction::make()
                    ->label('Lihat')
                    ->iconButton(),
                EditAction::make()
                    ->label('Ubah')
                    ->iconButton(),
                DeleteAction::make()
                    ->label('Hapus')
                    ->iconButton()
                    ->requiresConfirmation()
                    ->modalHeading('Konfirmasi Hapus')
                    ->modalDescription('Apakah Anda yakin ingin menghapus data indeks desa ini? Tindakan ini tidak dapat dibatalkan.'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Belum ada data indeks desa');
    }
}
