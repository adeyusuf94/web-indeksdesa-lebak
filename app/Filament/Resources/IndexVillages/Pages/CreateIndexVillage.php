<?php

namespace App\Filament\Resources\IndexVillages\Pages;

use App\Filament\Resources\IndexVillages\IndexVillageResource;
use Filament\Resources\Pages\CreateRecord;

class CreateIndexVillage extends CreateRecord
{
    protected static string $resource = IndexVillageResource::class;

    protected static bool $canCreateAnother = false;

    protected static ?string $title = 'Tambah Data Indeks Desa';

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Data Tersimpan';
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['id_desa'] = strval($data['id_desa']);

        return $data;
    }
}
