<?php

namespace App\Models;

use App\Enums\Permission as PermissionEnum;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['name'];

    public function getEnumAttribute(): PermissionEnum
    {
        return PermissionEnum::from($this->name);
    }
}
