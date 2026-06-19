<?php

namespace App\Filament\Resources\Districts\Tables;

use App\Models\District;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class DistrictsTable
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
                TextColumn::make('nama_kecamatan')->label('Nama Kecamatan')->searchable()->sortable(),
            ])
            ->filters([
                //
                SelectFilter::make('id_kecamatan')
                    ->label('Filter berdasarkan Kecamatan')
                    ->options(
                        District::query()
                            ->select('id_kecamatan', 'nama_kecamatan')
                            ->distinct()
                            ->orderBy('nama_kecamatan', 'asc')
                            ->pluck('nama_kecamatan', 'id_kecamatan')
                            ->toArray()
                    )
                    ->preload()
                    ->searchable()
                    ->multiple()
                    ->placeholder('Pilih Kecamatan'),
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
                    ->modalDescription('Apakah Anda yakin ingin menghapus data kecamatan ini? Tindakan ini tidak dapat dibatalkan.'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Belum ada data kecamatan');
    }
}
