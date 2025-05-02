<?php

namespace App\Filament\Resources\StudentDataResource\Pages;

use App\Filament\Resources\StudentDataResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateStudentData extends CreateRecord
{
    protected static string $resource = StudentDataResource::class;
}
