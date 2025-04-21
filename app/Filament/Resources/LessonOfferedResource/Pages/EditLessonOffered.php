<?php

namespace App\Filament\Resources\LessonOfferedResource\Pages;

use App\Filament\Resources\LessonOfferedResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLessonOffered extends EditRecord
{
    protected static string $resource = LessonOfferedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
