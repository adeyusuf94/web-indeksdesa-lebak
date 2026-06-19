<?php

namespace App\Filament\Resources\Districts\Pages;

use App\Filament\Resources\Districts\DistrictResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDistrict extends CreateRecord
{
    protected static string $resource = DistrictResource::class;

    protected static bool $canCreateAnother = false;

    protected static ?string $title = 'Tambah Kecamatan';

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Data Tersimpan';
    }
}
