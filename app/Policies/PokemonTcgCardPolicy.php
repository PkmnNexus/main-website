<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\PokemonTcgCard;
use Illuminate\Auth\Access\HandlesAuthorization;

class PokemonTcgCardPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:PokemonTcgCard');
    }

    public function view(AuthUser $authUser, PokemonTcgCard $card): bool
    {
        return $authUser->can('View:PokemonTcgCard');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:PokemonTcgCard');
    }

    public function update(AuthUser $authUser, PokemonTcgCard $card): bool
    {
        return $authUser->can('Update:PokemonTcgCard');
    }

    public function delete(AuthUser $authUser, PokemonTcgCard $card): bool
    {
        return $authUser->can('Delete:PokemonTcgCard');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:PokemonTcgCard');
    }

    public function restore(AuthUser $authUser, PokemonTcgCard $card): bool
    {
        return $authUser->can('Restore:PokemonTcgCard');
    }

    public function forceDelete(AuthUser $authUser, PokemonTcgCard $card): bool
    {
        return $authUser->can('ForceDelete:PokemonTcgCard');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:PokemonTcgCard');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:PokemonTcgCard');
    }

    public function replicate(AuthUser $authUser, PokemonTcgCard $card): bool
    {
        return $authUser->can('Replicate:PokemonTcgCard');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:PokemonTcgCard');
    }
}