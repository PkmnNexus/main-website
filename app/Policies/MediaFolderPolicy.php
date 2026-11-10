<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\MediaFolder;
use Illuminate\Auth\Access\HandlesAuthorization;

class MediaFolderPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:MediaFolder');
    }

    public function view(AuthUser $authUser, MediaFolder $mediaFolder): bool
    {
        return $authUser->can('View:MediaFolder');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:MediaFolder');
    }

    public function update(AuthUser $authUser, MediaFolder $mediaFolder): bool
    {
        return $authUser->can('Update:MediaFolder');
    }

    public function delete(AuthUser $authUser, MediaFolder $mediaFolder): bool
    {
        return $authUser->can('Delete:MediaFolder');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:MediaFolder');
    }

    public function restore(AuthUser $authUser, MediaFolder $mediaFolder): bool
    {
        return $authUser->can('Restore:MediaFolder');
    }

    public function forceDelete(AuthUser $authUser, MediaFolder $mediaFolder): bool
    {
        return $authUser->can('ForceDelete:MediaFolder');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:MediaFolder');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:MediaFolder');
    }

    public function replicate(AuthUser $authUser, MediaFolder $mediaFolder): bool
    {
        return $authUser->can('Replicate:MediaFolder');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:MediaFolder');
    }

}