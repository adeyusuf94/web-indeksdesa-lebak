<?php

namespace App\Filament\Resources\Villages\Schemas;

use App\Models\District;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class VillageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('id_kecamatan')
                    ->label('Kecamatan')
                    ->options(function () {
                        return District::pluck('nama_kecamatan', 'id_kecamatan');
                    })
                    ->searchable()
                    ->placeholder('Pilih Kecamatan')
                    ->required()
                    ->live(),
                // ->afterStateUpdated(function (callable $set, ?string $state) {
                //     $id_kecamatan = \App\Models\District::find($state)?->id_kecamatan ?? 0;

                //     $set('id_desa', $id_kecamatan);
                // }),
                TextInput::make('id_desa')
                    ->label('Kode Desa')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Masukkan Kode Desa')
                    ->unique()
                    ->validationMessages([
                        'unique' => 'Kode Desa sudah digunakan. Silakan gunakan Kode yang lain.',
                    ]),
                TextInput::make('nama_desa')
                    ->label('Nama Desa')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Masukkan Nama Desa'),
            ]);
    }
}
