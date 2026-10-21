<?php

namespace App\Policies;

use App\Models\Page;
use App\Models\User;

class PagePolicy
{
    /**
     * Determine whether the user can view any pages.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can view the page.
     */
    public function view(User $user, Page $page): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can create pages.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can update the page.
     */
    public function update(User $user, Page $page): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can delete the page.
     */
    public function delete(User $user, Page $page): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can delete any pages.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasRole('admin');
    }
}