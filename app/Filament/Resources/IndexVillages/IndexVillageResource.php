<?php

namespace App\Filament\Resources\IndexVillages;

use App\Filament\Resources\IndexVillages\Pages\CreateIndexVillage;
use App\Filament\Resources\IndexVillages\Pages\EditIndexVillage;
use App\Filament\Resources\IndexVillages\Pages\ListIndexVillages;
use App\Filament\Resources\IndexVillages\Pages\ViewIndexVillage;
use App\Filament\Resources\IndexVillages\Schemas\IndexVillageForm;
use App\Filament\Resources\IndexVillages\Tables\IndexVillagesTable;
use App\Filament\Resources\IndexVillages\Widgets\IndexVillageTableWidget;
use App\Models\IndexVillage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class IndexVillageResource extends Resource
{
    protected static ?string $model = IndexVillage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    // protected static ?string $recordTitleAttribute = 'Data Indeks Desa';

    protected static ?string $modelLabel = 'Indeks Desa';

    protected static ?string $pluralModelLabel = 'Data Indeks Desa';

    // /**
    //  * 🔥 INI TEMPAT UNTUK SET ID SEBELUM DATA DISIMPAN
    //  */
    // protected function mutateFormDataBeforeCreate(array $data): array
    // {
    //     // Ambil nilai dari form
    //     $tahun = $data['tahun'];
    //     $idDesa = $data['id_desa'];

    //     // Format ID: tahun-id_desa
    //     $customId = $tahun . '-' . $idDesa;

    //     // Cek apakah sudah ada (biar tidak duplikat)
    //     if (\App\Models\IndexVillage::where('id', $customId)->exists()) {
    //         throw new \Exception('Data untuk desa dan tahun ini sudah ada.');
    //     }

    //     // Set ID ke data yang akan disimpan
    //     $data['id'] = $customId;

    //     return $data;
    // }

    // public static function getGloballySearchableAttributes(): array
    // {
    //     return ['id', 'tahun', 'status_indeks', 'skor', 'dimensi_layanan_dasar', 'dimensi_sosial', 'dimensi_ekonomi', 'dimensi_lingkungan', 'dimensi_aksesibilitas', 'dimensi_tata_kelola_pemerintah', 'kecamatan.nama_kecamatan', 'desa.nama_desa'];
    // }

    public static function form(Schema $schema): Schema
    {
        return IndexVillageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return IndexVillagesTable::configure($table);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ViewIndexVillage::configure($schema);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getWidgets(): array
    {
        return [
            IndexVillageTableWidget::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListIndexVillages::route('/'),
            'create' => CreateIndexVillage::route('/create'),
            'edit' => EditIndexVillage::route('/{record}/edit'),
            'view' => ViewIndexVillage::route('/{record}'),
        ];
    }
}
