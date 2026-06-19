<?php

namespace App\Filament\Resources\Districts\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DistrictForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('id_kecamatan')
                    ->label('Kode Kecamatan')
                    ->required()
                    ->maxLength(255)
                    ->unique()
                    ->validationMessages([
                        'unique' => 'Kode Kecamatan sudah digunakan. Silakan gunakan Kode yang lain.',
                    ])
                    ->placeholder('Masukkan Kode Kecamatan'),
                TextInput::make('nama_kecamatan')
                    ->label('Nama Kecamatan')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Masukkan Nama Kecamatan'),
            ]);
    }
}
