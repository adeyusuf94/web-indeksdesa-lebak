<?php

namespace App\Filament\Resources\Villages\Tables;

use App\Models\Village;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class VillagesTable
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
                TextColumn::make('id_kecamatan')->label('Kode Kecamatan')->sortable(),
                TextColumn::make('kecamatan.nama_kecamatan')->label('Nama Kecamatan')->searchable()->sortable(),
                TextColumn::make('id_desa')->label('Kode Desa')->sortable(),
                TextColumn::make('nama_desa')->label('Nama Desa')->searchable()->sortable(),
            ])
            ->filters([
                //
                SelectFilter::make('id_kecamatan')
                    ->label('Filter berdasarkan Kecamatan')
                    ->options(
                        Village::query()
                            ->select('kecamatan.id_kecamatan', 'kecamatan.nama_kecamatan')
                            ->distinct()
                            ->join('kecamatan', 'desa.id_kecamatan', '=', 'kecamatan.id_kecamatan')
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
                        Village::query()
                            ->select('id_desa', 'nama_desa')
                            ->distinct()
                            ->orderBy('nama_desa', 'asc')
                            ->pluck('nama_desa', 'id_desa')
                            ->toArray()
                    )
                    ->preload()
                    ->searchable()
                    ->multiple()
                    ->placeholder('Pilih Desa'),
            ], layout: FiltersLayout::Modal)
            ->recordActions([
                EditAction::make()
                    ->label('Ubah')
                    ->iconButton(),
                DeleteAction::make()
                    ->label('Hapus')
                    ->iconButton()
                    ->requiresConfirmation()
                    ->modalHeading('Konfirmasi Hapus')
                    ->modalDescription('Apakah Anda yakin ingin menghapus data desa ini? Tindakan ini tidak dapat dibatalkan.'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Belum ada data desa');
    }
}
