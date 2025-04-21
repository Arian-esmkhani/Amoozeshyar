<?php

namespace App\Filament\Resources\TermAccessResource\Pages;

use App\Filament\Resources\TermAccessResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTermAccesses extends ListRecords
{
    protected static string $resource = TermAccessResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
