<?php

namespace App\Filament\Resources\IndexVillages\Schemas;

use App\Models\District;
use App\Models\Village;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Text;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Enums\TextSize;

class IndexVillageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Desa')
                    ->schema([
                        Select::make('id_kecamatan')
                            ->label('Nama Kecamatan')
                            ->options(function () {
                                return District::pluck('nama_kecamatan', 'id_kecamatan');
                            })
                            ->searchable()
                            ->placeholder('Pilih Kecamatan')
                            ->required()
                            ->live()
                            ->afterStateUpdated(function (callable $set) {
                                $set('id_desa', null);
                            }),
                        // 🔥 DISABLE SAAT EDIT
                        // ->disabled(fn($operation) => $operation === 'edit')
                        // ->dehydrated(true),
                        Select::make('id_desa')
                            ->label('Nama Desa')
                            ->options(function (Get $get) {
                                return Village::where('id_kecamatan', $get('id_kecamatan'))->pluck('nama_desa', 'id_desa');
                            })
                            ->required()
                            ->searchable()
                            ->placeholder('Pilih Desa')
                            ->live()
                            ->afterStateUpdated(function (callable $set, Get $get) {
                                if ($get('tahun') && $get('id_desa')) {
                                    $set('id', $get('tahun').'-'.$get('id_desa'));
                                }
                            }),
                        // 🔥 DISABLE SAAT EDIT
                        // ->disabled(fn($operation) => $operation === 'edit')
                        // ->dehydrated(true),
                        Select::make('tahun')
                            ->label('Tahun')
                            ->options(function () {
                                $years = [];
                                for ($year = date('Y'); $year >= 2025; $year--) {
                                    $years[$year] = $year;
                                }

                                return $years;
                            })
                            ->placeholder('Pilih Tahun')
                            ->searchable()
                            ->required()
                            ->live()
                            ->afterStateUpdated(function (callable $set, Get $get) {
                                if ($get('tahun') && $get('id_desa')) {
                                    $set('id', $get('tahun').'-'.$get('id_desa'));
                                }
                            }),
                        // 🔥 DISABLE SAAT EDIT
                        // ->disabled(fn($operation) => $operation === 'edit')
                        // ->dehydrated(true),
                    ]),
                Section::make('Indeks Desa')
                    ->columns(2)
                    ->schema([
                        TextInput::make('dimensi_layanan_dasar')
                            ->label('Dimensi Layanan Dasar')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(170)
                            ->step(0.01)
                            ->belowLabel(Text::make('Nilai Maksimal : 170')->size(TextSize::ExtraSmall))
                            ->placeholder('Masukkan Nilai Dimensi Layanan Dasar'),
                        TextInput::make('dimensi_sosial')
                            ->label('Dimensi Sosial')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(85)
                            ->step(0.01)
                            ->belowLabel(Text::make('Nilai Maksimal : 85')->size(TextSize::ExtraSmall))
                            ->placeholder('Masukkan Nilai Dimensi Sosial'),
                        TextInput::make('dimensi_ekonomi')
                            ->label('Dimensi Ekonomi')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(160)
                            ->step(0.01)
                            ->belowLabel(Text::make('Nilai Maksimal : 160')->size(TextSize::ExtraSmall))
                            ->placeholder('Masukkan Nilai Dimensi Ekonomi'),
                        TextInput::make('dimensi_lingkungan')
                            ->label('Dimensi Lingkungan')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(90)
                            ->step(0.01)
                            ->belowLabel(Text::make('Nilai Maksimal : 90')->size(TextSize::ExtraSmall))
                            ->placeholder('Masukkan Nilai Dimensi Lingkungan'),
                        TextInput::make('dimensi_aksesibilitas')
                            ->label('Dimensi Aksesibilitas')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(50)
                            ->step(0.01)
                            ->belowLabel(Text::make('Nilai Maksimal : 50')->size(TextSize::ExtraSmall))
                            ->placeholder('Masukkan Nilai Dimensi Aksesibilitas'),
                        TextInput::make('dimensi_tata_kelola_pemerintah')
                            ->label('Dimensi Tata Kelola Pemerintah')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(80)
                            ->step(0.01)
                            ->belowLabel(Text::make('Nilai Maksimal : 80')->size(TextSize::ExtraSmall))
                            ->placeholder('Masukkan Nilai Dimensi Tata Kelola Pemerintah'),
                    ])->live()->afterStateUpdated(function (callable $set, Get $get) {
                        $dimensi_layanan_dasar = (float) $get('dimensi_layanan_dasar') ?? 0;
                        $dimensi_sosial = (float) $get('dimensi_sosial') ?? 0;
                        $dimensi_ekonomi = (float) $get('dimensi_ekonomi') ?? 0;
                        $dimensi_lingkungan = (float) $get('dimensi_lingkungan') ?? 0;
                        $dimensi_aksesibilitas = (float) $get('dimensi_aksesibilitas') ?? 0;
                        $dimensi_tata_kelola_pemerintah = (float) $get('dimensi_tata_kelola_pemerintah') ?? 0;

                        // Hitung skor indeks desa sebagai rata-rata dari semua dimensi
                        $skor = (($dimensi_layanan_dasar + $dimensi_sosial + $dimensi_ekonomi + $dimensi_lingkungan + $dimensi_aksesibilitas + $dimensi_tata_kelola_pemerintah) / 635) * 100; // Asumsikan total skor maksimal adalah 600

                        // Tentukan status indeks desa berdasarkan skor
                        $status_indeks = 'Tidak Diketahui'; // ⬅️ WAJIB DEFAULT

                        if ($skor >= 79.63 && $skor <= 100) {
                            $status_indeks = 'Mandiri';
                        } elseif ($skor >= 69.35 && $skor <= 79.62) {
                            $status_indeks = 'Maju';
                        } elseif ($skor >= 57.39 && $skor <= 69.34) {
                            $status_indeks = 'Berkembang';
                        } elseif ($skor >= 49.49 && $skor <= 57.38) {
                            $status_indeks = 'Tertinggal';
                        } elseif ($skor >= 0 && $skor <= 49.48) {
                            $status_indeks = 'Sangat Tertinggal';
                        }

                        // Set nilai skor dan status indeks desa
                        $set('skor', round($skor, 2));
                        $set('status_indeks', $status_indeks);
                    }),
                Section::make('Skor dan Status Indeks Desa')
                    ->schema([
                        TextInput::make('id')
                            ->label('Kode Indeks Desa')
                            ->disabled()
                            ->dehydrated(true) // 🔥 WAJIB biar ikut ke DB
                            ->default(function (Get $get) {
                                if ($get('tahun') && $get('id_desa')) {
                                    return $get('tahun').'-'.$get('id_desa');
                                }

                                return null;
                            })
                            ->placeholder('Kode akan terbentuk otomatis berdasarkan Tahun dan Desa')
                            ->unique()
                            ->validationMessages([
                                'unique' => 'Kode Indeks Desa sudah digunakan. Silakan gunakan buat yang lain.',
                            ]),
                        TextInput::make('skor')
                            ->label('Skor Indeks Desa')
                            ->disabled()
                            ->dehydrated() // tetap tersimpan ke DB
                            ->default(fn (Get $get) => $get('skor') !== null ? round($get('skor'), 2) : null)
                            ->placeholder('Skor akan dihitung otomatis'),
                        TextInput::make('status_indeks')
                            ->label('Status Indeks Desa')
                            ->disabled()
                            ->dehydrated() // tetap tersimpan ke DB
                            ->default(fn (Get $get) => $get('status_indeks'))
                            ->placeholder('Status akan ditentukan otomatis'),
                    ]),
            ]);
    }
}
