<?php

namespace App\Filament\Resources\StudentDataResource\Pages;

use App\Filament\Resources\StudentDataResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStudentData extends ListRecords
{
    protected static string $resource = StudentDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
