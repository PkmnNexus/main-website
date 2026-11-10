<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Trivia;
use Illuminate\Auth\Access\HandlesAuthorization;

class TriviaPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Trivia');
    }

    public function view(AuthUser $authUser, Trivia $trivia): bool
    {
        return $authUser->can('View:Trivia');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Trivia');
    }

    public function update(AuthUser $authUser, Trivia $trivia): bool
    {
        return $authUser->can('Update:Trivia');
    }

    public function delete(AuthUser $authUser, Trivia $trivia): bool
    {
        return $authUser->can('Delete:Trivia');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Trivia');
    }

    public function restore(AuthUser $authUser, Trivia $trivia): bool
    {
        return $authUser->can('Restore:Trivia');
    }

    public function forceDelete(AuthUser $authUser, Trivia $trivia): bool
    {
        return $authUser->can('ForceDelete:Trivia');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Trivia');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Trivia');
    }

    public function replicate(AuthUser $authUser, Trivia $trivia): bool
    {
        return $authUser->can('Replicate:Trivia');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Trivia');
    }

}