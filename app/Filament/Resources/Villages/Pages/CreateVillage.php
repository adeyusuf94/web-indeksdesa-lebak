<?php

namespace App\Filament\Resources\Villages\Pages;

use App\Filament\Resources\Villages\VillageResource;
use Filament\Resources\Pages\CreateRecord;

class CreateVillage extends CreateRecord
{
    protected static string $resource = VillageResource::class;

    protected static bool $canCreateAnother = false;

    protected static ?string $title = 'Tambah Desa';

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Data Tersimpan';
    }
}
