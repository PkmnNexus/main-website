<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\PokemonTcgSeries;
use Illuminate\Auth\Access\HandlesAuthorization;

class PokemonTcgSeriesPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:PokemonTcgSeries');
    }

    public function view(AuthUser $authUser, PokemonTcgSeries $series): bool
    {
        return $authUser->can('View:PokemonTcgSeries');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:PokemonTcgSeries');
    }

    public function update(AuthUser $authUser, PokemonTcgSeries $series): bool
    {
        return $authUser->can('Update:PokemonTcgSeries');
    }

    public function delete(AuthUser $authUser, PokemonTcgSeries $series): bool
    {
        return $authUser->can('Delete:PokemonTcgSeries');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:PokemonTcgSeries');
    }

    public function restore(AuthUser $authUser, PokemonTcgSeries $series): bool
    {
        return $authUser->can('Restore:PokemonTcgSeries');
    }

    public function forceDelete(AuthUser $authUser, PokemonTcgSeries $series): bool
    {
        return $authUser->can('ForceDelete:PokemonTcgSeries');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:PokemonTcgSeries');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:PokemonTcgSeries');
    }

    public function replicate(AuthUser $authUser, PokemonTcgSeries $series): bool
    {
        return $authUser->can('Replicate:PokemonTcgSeries');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:PokemonTcgSeries');
    }
}