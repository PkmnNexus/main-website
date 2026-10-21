<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine whether the user can view any categories.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can view the category.
     */
    public function view(User $user, User $category): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can create categories.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can update the category.
     */
    public function update(User $user, User $category): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can delete the category.
     */
    public function delete(User $user, User $category): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can delete any categories.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasRole('admin');
    }
}