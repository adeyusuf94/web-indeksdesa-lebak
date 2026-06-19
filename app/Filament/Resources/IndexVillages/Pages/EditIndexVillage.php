<?php

namespace App\Filament\Resources\IndexVillages\Pages;

use App\Filament\Resources\IndexVillages\IndexVillageResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditIndexVillage extends EditRecord
{
    protected static string $resource = IndexVillageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['id_desa'] = strval($data['id_desa']);

        return $data;
    }
}
