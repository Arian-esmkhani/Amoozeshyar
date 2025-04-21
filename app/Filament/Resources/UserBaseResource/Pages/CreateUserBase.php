<?php

namespace App\Filament\Resources\UserBaseResource\Pages;

use App\Filament\Resources\UserBaseResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUserBase extends CreateRecord
{
    protected static string $resource = UserBaseResource::class;
}
