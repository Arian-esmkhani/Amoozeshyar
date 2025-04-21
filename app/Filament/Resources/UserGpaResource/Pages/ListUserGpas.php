<?php

namespace App\Filament\Resources\UserGpaResource\Pages;

use App\Filament\Resources\UserGpaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUserGpas extends ListRecords
{
    protected static string $resource = UserGpaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
