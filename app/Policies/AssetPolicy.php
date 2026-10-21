<?php

namespace App\Policies;

use App\Models\Asset;
use App\Models\User;

class AssetPolicy
{
    /**
     * Determine whether the user can view any assets.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'editor']);
    }

    /**
     * Determine whether the user can view the asset.
     */
    public function view(User $user, Asset $asset): bool
    {
        return $user->hasAnyRole(['admin', 'editor']);
    }

    /**
     * Determine whether the user can create assets.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'editor']);
    }

    /**
     * Determine whether the user can update the asset.
     */
    public function update(User $user, Asset $asset): bool
    {
        return $user->hasAnyRole(['admin', 'editor']);
    }

    /**
     * Determine whether the user can delete the asset.
     */
    public function delete(User $user, Asset $asset): bool
    {
        return $user->hasAnyRole(['admin', 'editor']);
    }

    /**
     * Determine whether the user can delete any assets.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'editor']);
    }
}