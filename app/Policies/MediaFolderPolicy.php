<?php

namespace App\Policies;

use App\Models\MediaFolder;
use App\Models\User;

class MediaFolderPolicy
{
    /**
     * Determine whether the user can view any media folders.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'editor']);
    }

    /**
     * Determine whether the user can view the media folder.
     */
    public function view(User $user, MediaFolder $mediaFolder): bool
    {
        return $user->hasAnyRole(['admin', 'editor']);
    }

    /**
     * Determine whether the user can create media folders.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'editor']);
    }

    /**
     * Determine whether the user can update the media folder.
     */
    public function update(User $user, MediaFolder $mediaFolder): bool
    {
        return $user->hasAnyRole(['admin', 'editor']);
    }

    /**
     * Determine whether the user can delete the media folder.
     */
    public function delete(User $user, MediaFolder $mediaFolder): bool
    {
        return $user->hasAnyRole(['admin', 'editor']);
    }

    /**
     * Determine whether the user can delete any media folders.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'editor']);
    }
}