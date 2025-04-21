<?php

namespace App\Filament\Resources\LessonOfferedResource\Pages;

use App\Filament\Resources\LessonOfferedResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLessonOffereds extends ListRecords
{
    protected static string $resource = LessonOfferedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
