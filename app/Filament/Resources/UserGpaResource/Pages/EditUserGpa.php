<?php

namespace App\Filament\Resources\UserGpaResource\Pages;

use App\Filament\Resources\UserGpaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUserGpa extends EditRecord
{
    protected static string $resource = UserGpaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
