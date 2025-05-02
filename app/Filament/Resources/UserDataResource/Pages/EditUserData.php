<?php

namespace App\Filament\Resources\UserDataResource\Pages;

use App\Filament\Resources\UserDataResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUserData extends EditRecord
{
    protected static string $resource = UserDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
