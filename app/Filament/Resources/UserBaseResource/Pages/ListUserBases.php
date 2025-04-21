<?php

namespace App\Filament\Resources\UserBaseResource\Pages;

use App\Filament\Resources\UserBaseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUserBases extends ListRecords
{
    protected static string $resource = UserBaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
