<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\PokemonTcgSet;
use Illuminate\Auth\Access\HandlesAuthorization;

class PokemonTcgSetPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:PokemonTcgSet');
    }

    public function view(AuthUser $authUser, PokemonTcgSet $set): bool
    {
        return $authUser->can('View:PokemonTcgSet');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:PokemonTcgSet');
    }

    public function update(AuthUser $authUser, PokemonTcgSet $set): bool
    {
        return $authUser->can('Update:PokemonTcgSet');
    }

    public function delete(AuthUser $authUser, PokemonTcgSet $set): bool
    {
        return $authUser->can('Delete:PokemonTcgSet');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:PokemonTcgSet');
    }

    public function restore(AuthUser $authUser, PokemonTcgSet $set): bool
    {
        return $authUser->can('Restore:PokemonTcgSet');
    }

    public function forceDelete(AuthUser $authUser, PokemonTcgSet $set): bool
    {
        return $authUser->can('ForceDelete:PokemonTcgSet');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:PokemonTcgSet');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:PokemonTcgSet');
    }

    public function replicate(AuthUser $authUser, PokemonTcgSet $set): bool
    {
        return $authUser->can('Replicate:PokemonTcgSet');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:PokemonTcgSet');
    }
}