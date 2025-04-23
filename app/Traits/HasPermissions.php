<?php

namespace App\Traits;

use App\Enums\Permission;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasPermissions
{
    public function hasPermission(Permission $permission): bool
    {
        return $this->permissions()->where('name', $permission->value)->exists();
    }

    public function hasAnyPermission(array $permissions): bool
    {
        return $this->permissions()->whereIn('name', array_map(fn($p) => $p->value, $permissions))->exists();
    }

    public function hasAllPermissions(array $permissions): bool
    {
        return $this->permissions()->whereIn('name', array_map(fn($p) => $p->value, $permissions))->count() === count($permissions);
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Permission::class);
    }
}
