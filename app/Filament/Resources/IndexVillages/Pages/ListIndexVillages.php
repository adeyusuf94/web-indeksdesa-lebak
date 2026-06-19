<?php

namespace App\Filament\Resources\IndexVillages\Pages;

use App\Filament\Resources\IndexVillages\IndexVillageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListIndexVillages extends ListRecords
{
    protected static string $resource = IndexVillageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Tambah Data Indeks Desa'),
        ];
    }
}
