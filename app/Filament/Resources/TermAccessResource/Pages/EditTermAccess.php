<?php

namespace App\Filament\Resources\TermAccessResource\Pages;

use App\Filament\Resources\TermAccessResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTermAccess extends EditRecord
{
    protected static string $resource = TermAccessResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
