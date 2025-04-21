<?php

namespace App\Filament\Resources\UserBaseResource\Pages;

use App\Filament\Resources\UserBaseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUserBase extends EditRecord
{
    protected static string $resource = UserBaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
